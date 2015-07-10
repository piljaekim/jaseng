<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->GNB = $this->load->database('JASENG', TRUE);

        $this->load->helper(array('url', 'date', 'form', 'alert'));
        $this->load->model('Db_m');
        $this->load->library('session');
    }
    
    function index(){
        $this->load->view('loginForm');
    }
    
}
?>