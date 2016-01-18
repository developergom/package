<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Description of Province
 *
 * @author nanank
 */
class Prvnc extends GN_Model {

    public $_db_group = 'RESIDENCE';
    public $_table = 'Prvnc';
    public $primary_key = 'pid';
    public $belongs_to = [
        'Cntry' => [
            'model' => 'Cntry',
            'primary_key' => 'cid'
        ]
    ];

    public function __construct() {
        parent::__construct();
    }

}

/* End of file Prvnc.php */
/* Location: ./application/model/Prvnc.php */