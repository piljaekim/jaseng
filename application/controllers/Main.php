<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->JASENG = $this->load->database('JASENG', TRUE);

        $this->load->helper(array('url', 'date', 'form', 'alert'));
        $this->load->model('Db_m');
        $this->load->library('session');
    }
    
//    function _remap($method) {
//        
//    }
    

    function index() {
        if (!$this->session->userdata['ID']) {
            alert('로그인 후 사용 가능 합니다.', '/index.php/login');
            exit;
        }else{
            $this->load->view('main');
        }
    }

}

?>