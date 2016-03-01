<?php

defined('BASEPATH') OR exit('No direct script access allowed.');

/**
 *
 * Description of SSO
 * 
 * @author soniibrol
 *
 */
class Sso_new {

    var $ci;
    var $id;
    private $data = [];
    private $action_key = [];
    public $menu = [];
    public $access = [];
    public $curr_access = [];

    public function __construct() {
        $this->ci = & get_instance();
        $this->ci->load->helper('recursive');

        $this->id = $this->ci->session->userdata('user');
        $this->fetch_action_key();
        $this->get_access();
        $this->menu = $this->generate_menu();

        $this->checking_access();

        if (!isset($this->id))
            return;
    }

    private function get_current_access($module_id) {
        if (!empty($module_id)) {
            reset($this->curr_access);
            foreach ($this->access[$module_id] as $key => $value)
                array_push($this->curr_access, $this->action_key[$value]);
        }
    }

    private function fetch_action_key() {
        $action_key = $this->ci->db->get('actions')->result_array();
        foreach ($action_key as $key => $value)
            $this->action_key[$value['action_id']] = $value['action_alias'];
    }

    private function get_access() {
        $tmp = [];
        $userrole = $this->ci->db->get_where('user_role ur', ['ur.user_id' => $this->id])->result_array();
        foreach ($userrole as $key => $value) {
            $rolemodule = $this->ci->db->get_where('role_module rm', ['rm.role_id' => $value['role_id']])->result_array();
            foreach ($rolemodule as $k => $v) {
                if (isset($this->access[$v['module_id']]))
                    $this->access[$v['module_id']] = array_merge($this->access[$v['module_id']], unserialize($v['access_key']));
                else
                    $this->access[$v['module_id']] = unserialize($v['access_key']);

                $this->access[$v['module_id']] = array_unique($this->access[$v['module_id']]);
            }
        }
    }

    private function checking_access() {
        $url = $this->ci->router->fetch_class();
        $modules = $this->ci->db->get_where('modules md', ['md.module_url' => $url])->row_array();
        if (sizeof($modules) > 0) {
            $selected = $this->access[$modules['module_id']];
            if (empty($selected)) {
                redirect(404);
            } else {
                $this->get_current_access($modules['module_id']);
            }
        } else {
            redirect(404);
        }
    }

    public function check_access($code_access) {
        /* debug($this->curr_access); */
        if (!in_array($code_access, $this->curr_access))
            redirect(404);
    }

    private function generate_menu() {
        foreach ($this->access as $key => $value) {
            if (!empty($value)) {
                $this->ci->db->join('modules md', 'md.module_id = m.module_id', 'INNER');
                $this->ci->db->join('apps a', 'a.app_id = md.app_id', 'INNER');
                $menus = $this->ci->db->order_by('m.menu_order', 'asc')->get_where('menus m', ['m.module_id' => $key])->row_array();
                $this->data[] = $menus;
            }
        }
        $this->sorting_menu();
        $rec = data_recursive($this->data, 'menu_id', 'menu_parent');
        $str = $this->menu_tree($rec);
        return $str;
    }

    protected function menu_tree($data = []) {
        $str = NULL;
        if (!empty($data)) {
            foreach ($data as $v) {
                $lv1 = $v['data'];
                if (!empty($v['sub'])) {
                    $attr1 = (!empty($v['sub'])) ? '<i class="fa fa-angle-left pull-right"></i>' : NULL;
                    $c1 = (!empty($v['sub'])) ? 'class="treeview"' : NULL;
                    $str .= '<li ' . $c1 . '>' . anchor($lv1['module_url'], '<i class="fa ' . $lv1['menu_icon'] . '"></i> <span>' . $lv1['menu_name'] . '</span>' . $attr1);
                    $str .= '<ul class="treeview-menu">';
                    foreach ($v['sub'] as $vv) {
                        $lv2 = $vv['data'];
                        if (!empty($vv['sub'])) {
                            $attr2 = (!empty($vv['sub'])) ? '<i class="fa fa-angle-left pull-right"></i>' : NULL;
                            $str .= '<li>' . anchor($lv2['module_url'], '<i class="fa ' . $lv2['menu_icon'] . '"></i>' . $lv2['menu_name'] . $attr2);
                            $str .= '<ul class="treeview-menu">';
                            foreach ($vv['sub'] as $vvv) {
                                $lv3 = $vvv['data'];
                                $active = ($lv3['module_url'] == $this->ci->router->fetch_class()) ? 'active' : '';
                                $str .= '<li class="' . $active . '">' . anchor($lv3['app_url'] . $lv3['module_url'], '<i class="fa ' . $lv3['menu_icon'] . '"></i>' . nbs() . $lv3['menu_name']) . '</li>';
                            }
                            $str .= '</ul>';
                        } else {
                            $str .= '<li>' . anchor($lv2['module_url'], '<i class="fa ' . $lv2['menu_icon'] . '"></i> <span>' . $lv2['menu_name'] . '</span>');
                        }
                        $str .= '</li>';
                    }
                    $str .= '</ul>';
                } else {
                    $str .= '<li>' . anchor($lv1['module_url'], '<i class="fa ' . $lv1['menu_icon'] . '"></i> <span>' . $lv1['menu_name'] . '</span>');
                }
                $str .= '</li>';
            }
        }

        return $str;
    }

    private function sorting_menu() {
        $order = array();
        foreach ($this->data as $key => $value)
            $order[] = $value['menu_order'];

        array_multisort($order, SORT_ASC, $this->data);
    }

}
