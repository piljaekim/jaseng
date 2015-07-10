<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class ClassificationCode extends CI_Controller {
    function __construct() {
        parent::__construct();

        $this->JASENG = $this->load->database('JASENG', TRUE);

        $this->load->helper(array('url', 'date', 'form', 'alert'));
        $this->load->model('Db_m');
        $this->load->library('session');
    }
    
    function index(){
        $sql = "SELECT CLASSIFICATION_CODE_IDX, CODE, CODE_NAME, IS_USE
                    FROM 
                CLASSIFICATION_CODE";
        $data['list'] = $this->Db_m->getList($sql, 'JASENG');
        
        $this->load->view('classificationCode', $data);
    }
    
    function useCheck(){
        $sql = "SELECT
                    CODE 
                FROM 
                    CLASSIFICATION_CODE 
                WHERE 
                    CODE = '".$_POST['code']."'";
        $res = $this->Db_m->getInfo($sql, 'JASENG');
        if(!$res){
            echo "SUCCESS";
        }else{
            echo "FAILED";
        }
    }
    
    function saveData(){
        $newData = array(
            'CODE' => $_POST['code'],
            'CODE_NAME' => $_POST['code_name'],
            'IS_USE' => 'T'
        );
        
        $res = $this->Db_m->insData('CLASSIFICATION_CODE', $newData, 'JASENG');
        if($res){
            alert('등록되었습니다.', '/index.php/classificationCode');
        }
    }
    
    function upDateCodeName(){
        $up_sql = "UPDATE
                        CLASSIFICATION_CODE 
                   SET 
                        CODE_NAME='".$_POST['code_name']."'
                   WHERE 
                        CLASSIFICATION_CODE_IDX=".$_POST['idx']."";
        $res = $this->JASENG->query($up_sql);
        if($res){
            alert('수정되었습니다.', '/index.php/classificationCode');
        }
    }
}
