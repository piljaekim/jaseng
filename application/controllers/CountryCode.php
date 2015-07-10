<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');
class CountryCode extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->JASENG = $this->load->database('JASENG', TRUE);

        $this->load->helper(array('url', 'date', 'form', 'alert'));
        $this->load->model('Db_m');
        $this->load->library('session');
    }
    
    function index(){
        
        $sql = "SELECT COUNTRY_CODE_IDX, COUNTRY_CODE, CODE_NAME, IS_USE
                    FROM 
                COUNTRY_CODE";
        $data['list'] = $this->Db_m->getList($sql, 'JASENG');
        
        $this->load->view('countryCode', $data);
    }
    
    function useCheck(){
        $sql = "SELECT
                    COUNTRY_CODE 
                FROM 
                    COUNTRY_CODE 
                WHERE 
                    COUNTRY_CODE = '".$_POST['country_code']."'";
        $res = $this->Db_m->getInfo($sql, 'JASENG');
        if(!$res){
            echo "SUCCESS";
        }else{
            echo "FAILED";
        }
    }
    
    function saveData(){
        $newData = array(
            'COUNTRY_CODE' => $_POST['country_code'],
            'CODE_NAME' => $_POST['code_name'],
            'IS_USE' => 'T'
        );
        
        $res = $this->Db_m->insData('COUNTRY_CODE', $newData, 'JASENG');
        if($res){
            alert('등록되었습니다.', '/index.php/countryCode');
        }
    }
    
    function upDateCodeName(){
        $up_sql = "UPDATE
                        COUNTRY_CODE 
                   SET 
                        CODE_NAME='".$_POST['code_name']."'
                   WHERE 
                        COUNTRY_CODE_IDX=".$_POST['idx']."";
        $res = $this->JASENG->query($up_sql);
        if($res){
            alert('수정되었습니다.', '/index.php/countryCode');
        }
    }
}
