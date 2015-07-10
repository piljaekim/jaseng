<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login_ok extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->JASENG = $this->load->database('JASENG', TRUE);

        $this->load->helper(array('url', 'date', 'form', 'alert'));
        $this->load->model('Db_m');
        $this->load->library('session');
    }
    
    function loginOk(){
        
        $sql = "SELECT 
                    ID 
                FROM
                    MEMBER
                WHERE 
                    ID = '".$_POST['id']."' AND
                    PWD = '".$_POST['pwd']."'";
//        print_r($sql);exit;
        $res = $this->Db_m->getInfo($sql, 'JASENG');
        
        if($res){
            //세션 생성
            $newdata = array(
                'ID' => $res->ID
            );
            
//            'MGRID' => $result->MGRID,
            $this->session->set_userdata($newdata);
            
            alert('로그인되었습니다.', '/index.php/main');
        }else{
//            echo "ddd";exit;
            alert('아이디 혹은 비밀번호를 확인해주세요', '/index.php/login');
        }
    }
    
}
?>