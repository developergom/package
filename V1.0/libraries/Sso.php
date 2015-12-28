<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of sso
 *
 * @author nanank
 */
class Sso {

    var $ci;
    var $id;
    private $data = [];
    public $menu = [];
    public $access = [];

    public function __construct() {
        $this->ci =& get_instance();
        $this->ci->load->model('Sso/Mn', 'mn');
        $this->ci->load->library('Setting');

        $this->id = $this->ci->session->userdata('user');
        $this->data = $this->get_data();
        $this->menu = $this->set_menu();
        $this->access = $this->set_access();
        if (!isset($this->id))
            return;
    }

    private function get_data() {
        $this->ci->db->join('rm r', 'r.mid = m.mid');
        $this->ci->db->join('url u', 'u.rid = r.rid');
        $query = $this->ci->db->get_where('mn m', ['u.uid' => $this->id, 'm.mstat' => TRUE]);
        $result = $query->result_array();
        if (!empty($result)) {
            $data = [];
            $tmp = [];
            foreach ($result as $val) {
                $mpar = ($val['mpar'] == 1) ? 0 : $val['mpar'];
                $tmp[$val['mid']][] = json_decode_db($val['rmk']);
                $data[$val['mid']] = [
                    'mid' => $val['mid'],
                    'mpar' => $mpar,
                    'mnme' => $val['mnme'],
                    'mico' => $val['mico'],
                    'mlnk' => $val['mlnk']
                ];
            }

            $array_key = [];
            foreach ($tmp as $k => $v) {
                $array_key[$k] = [];
                foreach ($v as $vv) {
                    if(is_array($vv) == FALSE)
                        continue;
                    
                    $array_key[$k] = array_merge($array_key[$k], $vv);
                }
                $array_key[$k] = array_unique($array_key[$k]);
                sort($array_key[$k]);
            }

            foreach ($data as $kk => $vvv)
                $data[$kk]['key'] = $array_key[$kk];
            
        }

        return (isset($data)) ? $data : [];
    }

    private function set_menu() {
        $tmp = [];
        foreach ($this->data as $v)
            $tmp[] = $v;

        $menu = data_recursive($tmp, 'mid', 'mpar');
        return $this->menu_tree($menu);
    }

    protected function menu_tree($data = []) {
        $str = NULL;
        if (!empty($data)) {
            foreach ($data as $v) {
                $lv1 = $v['data'];
                if (!empty($v['sub'])) {
                    $attr1 = (!empty($v['sub'])) ? '<i class="fa fa-angle-left pull-right"></i>' : NULL;
                    $c1 = (!empty($v['sub'])) ? 'class="treeview"' : NULL;
                    $str .= '<li ' . $c1 . '>' . anchor($lv1['mlnk'], '<i class="fa ' . $lv1['mico'] . '"></i> <span>' . $lv1['mnme'] . '</span>' . $attr1);
                    $str .= '<ul class="treeview-menu">';
                    foreach ($v['sub'] as $vv) {
                        $lv2 = $vv['data'];
                        if (!empty($vv['sub'])) {
                            $attr2 = (!empty($vv['sub'])) ? '<i class="fa fa-angle-left pull-right"></i>' : NULL;
                            $str .= '<li>' . anchor($lv2['mlnk'], '<i class="fa ' . $lv2['mico'] . '"></i>' . $lv2['mnme'] . $attr2);
                            $str .= '<ul class="treeview-menu">';
                            foreach ($vv['sub'] as $vvv) {
                                $lv3 = $vvv['data'];
                                $str .= '<li>' . anchor($lv3['mlnk'], '<i class="fa ' . $lv3['mico'] . '"></i>' . nbs() . $lv3['mnme']) . '</li>';
                            }
                            $str .= '</ul>';
                        } else {
                            $str .= '<li>' . anchor($lv2['mlnk'], '<i class="fa ' . $lv2['mico'] . '"></i> <span>' . $lv2['mnme'] . '</span>');
                        }
                        $str .= '</li>';
                    }
                    $str .= '</ul>';
                } else {
                    $str .= '<li>' . anchor($lv1['mlnk'], '<i class="fa ' . $lv1['mico'] . '"></i> <span>' . $lv1['mnme'] . '</span>');
                }
                $str .= '</li>';
            }
        }

        return $str;
    }

    protected function set_access() {
        $mdata = $this->ci->mn->gtbylnk($this->ci->setting->uri_string());
        $tmp = [];
        if (!empty($mdata)) {
            foreach ($this->data as $k => $v) {
                if ($k == $mdata['mid'] && $v['mlnk'] == $this->ci->setting->uri_string())
                    $tmp[] = $v['key'];
            }
        }

        return reset($tmp);
    }

}