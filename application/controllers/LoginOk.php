<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class LoginOk extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->GNB = $this->load->database('JASENG', TRUE);

        $this->load->helper(array('url', 'date', 'form', 'alert'));
        $this->load->model('Db_m');
        $this->load->library('session');
    }
    
    function loginOk(){
        $sql = "SELECT
                    ID 
                FROM 
                    WHERE 
                MEMBER 
                    ID = '".$_POST['id']."' AND
                    PASSWORD = '".$_POST['pwd']."'";
        
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
            alert('아이디 혹은 비밀번호를 확인해주세요', '/index.php/login');
        }
    }
    
}
?>