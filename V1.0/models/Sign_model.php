<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of In_model
 *
 * @author nanank
 */
class Sign_model extends GN_Model {

    public $_table = 'users';
    public $primary_key = 'user_id';
    public $count_wrong_password = 3;

    public function __construct() {
        parent::__construct();
        $this->load->library('encrypt');
    }

    public function in($key = NULL, $pass) {
        $key = $this->security->xss_clean($key);
        $by_username = $this->get_by('user_name', $key);
        if (empty($by_username)) {
            $by_email = $this->get_by('user_email', $key);
            if (empty($by_email)) {
                return 'invalid';
            } else {
                return $this->_do_sign_in($by_email, $pass);
            }
        } else {
            return $this->_do_sign_in($by_username, $pass);
        }
    }

    private function _do_sign_in($user, $pass) {
        $decode = $this->encrypt->decode($user->user_password);
        if ($pass == $decode) {
            $this->session->set_userdata('user', $user->user_id);
            return 'success';
        } else {
            $user = $this->get($user->user_id);
            $this->before_update = ['log'];
            if ($user->user_count_wrong_password < $this->count_wrong_password) {
                $this->update($user->user_id, ['user_count_wrong_password' => $this->count_wrong_password + 1]);
                return 'warning';
            } else if ($user->user_count_wrong_password == $this->count_wrong_password) {
                $this->update($user->user_id, ['user_status' => 'blocked']);
                return 'blocked';
            } else {
                return 'wrong';
            }
        }
    }

}
