<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Excel extends CI_Controller {

    function __construct() {
        parent::__construct();

        $this->JASENG = $this->load->database('JASENG', TRUE);

        $this->load->helper(array('url', 'date', 'form', 'alert'));
        $this->load->model('Db_m');
        $this->load->library('session');
        $this->load->library('PHPExcel');
    }

    function videoDataLoadExcel() {
        $UpFile = $_FILES["videoExcelUpFile"];

        $UpFileName = $UpFile["name"];

//        print_r($UpFile);

        $UpFilePathInfo = pathinfo($UpFileName);
        $UpFileExt = strtolower($UpFilePathInfo["extension"]);

        if ($UpFileExt != "xls" && $UpFileExt != "xlsx") {
            echo "엑셀파일만 업로드 가능합니다. (xls, xlsx 확장자의 파일포멧)";
            exit;
        }

        //업로드된 엑셀파일을 서버의 지정된 곳에 옮기기 위해 경로 적절히 설정
        $upload_path = $_SERVER["DOCUMENT_ROOT"] . "/upExcelFile/";
        $upfile_path = $upload_path . $UpFileName;


        if (is_uploaded_file($UpFile["tmp_name"])) {

            if (!move_uploaded_file($UpFile["tmp_name"], $upfile_path)) {
                echo "업로드된 파일을 옮기는 중 에러가 발생했습니다.";
                exit;
            }

//파일 타입 설정 (확자자에 따른 구분)
            $inputFileType = 'Excel2007';
            if ($UpFileExt == "xls") {
                $inputFileType = 'Excel5';
            }

//엑셀리더 초기화
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);

//데이터만 읽기(서식을 모두 무시해서 속도 증가 시킴)
            $objReader->setReadDataOnly(true);

//범위 지정(위에 작성한 범위필터 적용)
//            $objReader->setReadFilter($filterSubset);
//업로드된 엑셀 파일 읽기
            $objPHPExcel = $objReader->load($upfile_path);

//첫번째 시트로 고정
            $objPHPExcel->setActiveSheetIndex(0);

//고정된 시트 로드
            $objWorksheet = $objPHPExcel->getActiveSheet();

//시트의 지정된 범위 데이터를 모두 읽어 배열로 저장
            $sheetData_a = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_b = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_c = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_d = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_e = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_f = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_g = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_h = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_i = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_j = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_k = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_l = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $total_rows = '0';
            $total_rows = count($sheetData_a);
        }
        if ($total_rows >= 1) {
            $data['total_rows'] = $total_rows;
            $data['sheetData_a'] = $sheetData_a;
            $data['sheetData_b'] = $sheetData_b;
            $data['sheetData_c'] = $sheetData_c;
            $data['sheetData_d'] = $sheetData_d;
            $data['sheetData_e'] = $sheetData_e;
            $this->load->view('videoExcelView', $data);
        } else {
            echo "데이터가 없습니다.";
        }

//        print_r($total_rows);
    }

    function videoDataSave() {
        for ($i = 0; $i < $_POST['totalRows']; $i++) {
            if ($i != 0) {
                $sheet_a0 = explode('년', $_POST['col_A'][$i]);
                $sheet_a1 = str_replace("월", "", $sheet_a0[1]);
                if ($sheet_a1 < 10) {
                    $sheet_a1 = "0" . $sheet_a1;
                }
                $sheet_a = $sheet_a0[0] . $sheet_a1;
//                print_r($sheet_a);
                $addData[] = array(
                    'PUBLICATION_YEAR' => $sheet_a,
                    'WORK_GUBUN' => $_POST['col_B'][$i],
                    'TITLE' => $_POST['col_C'][$i],
                    'STORAGE_LOCATION' => $_POST['col_D'][$i],
                    'PRESS_PUBLISHER' => $_POST['col_E'][$i]
                );
            }
        }
        $res = $this->Db_m->insMultiData('VIDEO_PRODUCTION_LIST', $addData, 'JASENG');
//        print_r($addData);
        if ($res) {
            alert('업로드 되었습니다.', '/index.php/main');
        }
    }

    function donationDataLoadExcel() {
        $UpFile = $_FILES["donationExcelUpFile"];

        $UpFileName = $UpFile["name"];

//        print_r($UpFile);

        $UpFilePathInfo = pathinfo($UpFileName);
        $UpFileExt = strtolower($UpFilePathInfo["extension"]);

        if ($UpFileExt != "xls" && $UpFileExt != "xlsx") {
            echo "엑셀파일만 업로드 가능합니다. (xls, xlsx 확장자의 파일포멧)";
            exit;
        }

        //업로드된 엑셀파일을 서버의 지정된 곳에 옮기기 위해 경로 적절히 설정
        $upload_path = $_SERVER["DOCUMENT_ROOT"] . "/upExcelFile/";
        $upfile_path = $upload_path . $UpFileName;


        if (is_uploaded_file($UpFile["tmp_name"])) {

            if (!move_uploaded_file($UpFile["tmp_name"], $upfile_path)) {
                echo "업로드된 파일을 옮기는 중 에러가 발생했습니다.";
                exit;
            }

//파일 타입 설정 (확자자에 따른 구분)
            $inputFileType = 'Excel2007';
            if ($UpFileExt == "xls") {
                $inputFileType = 'Excel5';
            }

//엑셀리더 초기화
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);

//데이터만 읽기(서식을 모두 무시해서 속도 증가 시킴)
            $objReader->setReadDataOnly(true);

//범위 지정(위에 작성한 범위필터 적용)
//            $objReader->setReadFilter($filterSubset);
//업로드된 엑셀 파일 읽기
            $objPHPExcel = $objReader->load($upfile_path);

//첫번째 시트로 고정
            $objPHPExcel->setActiveSheetIndex(0);

//고정된 시트 로드
            $objWorksheet = $objPHPExcel->getActiveSheet();

//시트의 지정된 범위 데이터를 모두 읽어 배열로 저장
            $sheetData_a = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_b = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_c = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_d = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_e = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_f = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_g = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_h = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_i = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_j = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_k = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_l = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $total_rows = '0';
            $total_rows = count($sheetData_a);
        }
        if ($total_rows >= 1) {
            $data['total_rows'] = $total_rows;
            $data['sheetData_a'] = $sheetData_a;
            $data['sheetData_b'] = $sheetData_b;
            $data['sheetData_c'] = $sheetData_c;
            $data['sheetData_d'] = $sheetData_d;
            $data['sheetData_e'] = $sheetData_e;
            $this->load->view('donationExcelView', $data);
        } else {
            echo "데이터가 없습니다.";
        }

//        print_r($total_rows);
    }

    function donationDataSave() {
        for ($i = 0; $i < $_POST['totalRows']; $i++) {
            if ($i != 0) {
                if ($_POST['col_B'][$i] == '기부') {
                    $sheet_B = 'G';
                } else if ($_POST['col_B'][$i] == '현물기부') {
                    $sheet_B = 'C';
                }
                $addData[] = array(
                    'DATE' => str_replace("-", "", $_POST['col_A'][$i]),
                    'GUBUN' => $sheet_B,
                    'TREATMENT' => $_POST['col_C'][$i],
                    'PRICE' => $_POST['col_D'][$i],
                    'CONTENTS' => $_POST['col_E'][$i]
                );
            }
        }
//        print_r($addData);
        $res = $this->Db_m->insMultiData('DONATION_HISTORY', $addData, 'JASENG');
//        print_r($addData);
        if ($res) {
            alert('업로드 되었습니다.', '/index.php/main');
        }
    }

    function korPatentDataLoadExcel() {
        $UpFile = $_FILES["korPatentExcelUpFile"];

        $UpFileName = $UpFile["name"];

//        print_r($UpFile);

        $UpFilePathInfo = pathinfo($UpFileName);
        $UpFileExt = strtolower($UpFilePathInfo["extension"]);

        if ($UpFileExt != "xls" && $UpFileExt != "xlsx") {
            echo "엑셀파일만 업로드 가능합니다. (xls, xlsx 확장자의 파일포멧)";
            exit;
        }

        //업로드된 엑셀파일을 서버의 지정된 곳에 옮기기 위해 경로 적절히 설정
        $upload_path = $_SERVER["DOCUMENT_ROOT"] . "/upExcelFile/";
        $upfile_path = $upload_path . $UpFileName;


        if (is_uploaded_file($UpFile["tmp_name"])) {

            if (!move_uploaded_file($UpFile["tmp_name"], $upfile_path)) {
                echo "업로드된 파일을 옮기는 중 에러가 발생했습니다.";
                exit;
            }

//파일 타입 설정 (확자자에 따른 구분)
            $inputFileType = 'Excel2007';
            if ($UpFileExt == "xls") {
                $inputFileType = 'Excel5';
            }

//엑셀리더 초기화
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);

//데이터만 읽기(서식을 모두 무시해서 속도 증가 시킴)
            $objReader->setReadDataOnly(true);

//범위 지정(위에 작성한 범위필터 적용)
//            $objReader->setReadFilter($filterSubset);
//업로드된 엑셀 파일 읽기
            $objPHPExcel = $objReader->load($upfile_path);

//첫번째 시트로 고정
            $objPHPExcel->setActiveSheetIndex(0);

//고정된 시트 로드
            $objWorksheet = $objPHPExcel->getActiveSheet();

//시트의 지정된 범위 데이터를 모두 읽어 배열로 저장
            $sheetData_a = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_b = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_c = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_d = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_e = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_f = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_g = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_h = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_i = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_j = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_k = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_l = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $total_rows = '0';
            $total_rows = count($sheetData_a);
        }
        if ($total_rows >= 1) {
            $data['total_rows'] = $total_rows;
            $data['sheetData_a'] = $sheetData_a;
            $data['sheetData_b'] = $sheetData_b;
            $data['sheetData_c'] = $sheetData_c;
            $data['sheetData_d'] = $sheetData_d;
            $data['sheetData_e'] = $sheetData_e;
            $data['sheetData_f'] = $sheetData_f;
            $data['sheetData_g'] = $sheetData_g;
            $data['sheetData_h'] = $sheetData_h;
            $data['sheetData_i'] = $sheetData_i;
            $data['sheetData_j'] = $sheetData_j;
            $this->load->view('korPatentExcelView', $data);
        } else {
            echo "데이터가 없습니다.";
        }

//        print_r($total_rows);
    }

    function korPatentDataSave() {
        for ($i = 0; $i < $_POST['totalRows']; $i++) {
            if ($i != 0) {
                $sheet_C = $_POST['col_C'][$i];
                if ($_POST['col_I'][$i] == '공개') {
                    $sheet_I = 'T';
                } else if (!$_POST['col_I'][$i]) {
                    $sheet_I = 'F';
                }
                if ($_POST['col_C'][$i] == '거절') {
                    $sheet_C = 0;
                }
                $addData = array(
                    'APPLICATION_NUMBER' => $_POST['col_A'][$i],
                    'FILING_DATE' => str_replace("-", "", $_POST['col_B'][$i]),
                    'REG_NUMBER' => $sheet_C,
                    'REG_DATE' => str_replace("-", "", $_POST['col_D'][$i]),
                    'END_DATE' => str_replace("-", "", $_POST['col_J'][$i]),
                    'PATENT_NAME' => $_POST['col_E'][$i],
                    'IS_SHOW' => $sheet_I
                );

//                print_r($addData);

                $result = $this->Db_m->insData('KOR_PATENT_STATUS', $addData, 'JASENG');

                $ins_id = $this->JASENG->insert_id();
                $applicants = explode(",", $_POST['col_F'][$i]);

                foreach ($applicants as $applicants_row) {
                    $addApplicants = array(
                        'KOR_PATENT_STATUS_IDX' => $ins_id,
                        'APPLICATION_NUMBER' => $_POST['col_A'][$i],
                        'APPLICANTS' => $applicants_row
                    );
                    $result_applicants = $this->Db_m->insData('KOR_PATENT_APPLICANTS', $addApplicants, 'JASENG');
                }

                $registrant = explode(",", $_POST['col_G'][$i]);

                foreach ($registrant as $registrant_row) {
                    $addRegistrant = array(
                        'KOR_PATENT_STATUS_IDX' => $ins_id,
                        'APPLICATION_NUMBER' => $_POST['col_A'][$i],
                        'REGISTRANT' => $registrant_row
                    );
                    $result_registrant = $this->Db_m->insData('KOR_PATENT_REGISTRANT', $addRegistrant, 'JASENG');
                }

                $inventor = explode(",", $_POST['col_H'][$i]);

                foreach ($inventor as $inventor_row) {
                    $addInventor_row = array(
                        'KOR_PATENT_STATUS_IDX' => $ins_id,
                        'APPLICATION_NUMBER' => $_POST['col_A'][$i],
                        'INVENTOR' => $inventor_row
                    );
                    $result_inventor = $this->Db_m->insData('KOR_PATENT_INVENTOR', $addInventor_row, 'JASENG');
                }
            }
        }
//        exit;
        alert('업로드 되었습니다.', '/index.php/main');
    }

    function foreignPatentDataLoadExcel() {
        $UpFile = $_FILES["foreignPatentExcelUpFile"];

        $UpFileName = $UpFile["name"];

//        print_r($UpFile);

        $UpFilePathInfo = pathinfo($UpFileName);
        $UpFileExt = strtolower($UpFilePathInfo["extension"]);

        if ($UpFileExt != "xls" && $UpFileExt != "xlsx") {
            echo "엑셀파일만 업로드 가능합니다. (xls, xlsx 확장자의 파일포멧)";
            exit;
        }

        //업로드된 엑셀파일을 서버의 지정된 곳에 옮기기 위해 경로 적절히 설정
        $upload_path = $_SERVER["DOCUMENT_ROOT"] . "/upExcelFile/";
        $upfile_path = $upload_path . $UpFileName;


        if (is_uploaded_file($UpFile["tmp_name"])) {

            if (!move_uploaded_file($UpFile["tmp_name"], $upfile_path)) {
                echo "업로드된 파일을 옮기는 중 에러가 발생했습니다.";
                exit;
            }

//파일 타입 설정 (확자자에 따른 구분)
            $inputFileType = 'Excel2007';
            if ($UpFileExt == "xls") {
                $inputFileType = 'Excel5';
            }

//엑셀리더 초기화
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);

//데이터만 읽기(서식을 모두 무시해서 속도 증가 시킴)
            $objReader->setReadDataOnly(true);

//범위 지정(위에 작성한 범위필터 적용)
//            $objReader->setReadFilter($filterSubset);
//업로드된 엑셀 파일 읽기
            $objPHPExcel = $objReader->load($upfile_path);

//첫번째 시트로 고정
            $objPHPExcel->setActiveSheetIndex(0);

//고정된 시트 로드
            $objWorksheet = $objPHPExcel->getActiveSheet();

//시트의 지정된 범위 데이터를 모두 읽어 배열로 저장
            $sheetData_a = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_b = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_c = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_d = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_e = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_f = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_g = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_h = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_i = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_j = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_k = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_l = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $total_rows = '0';
            $total_rows = count($sheetData_a);
        }
        if ($total_rows >= 1) {
            $data['total_rows'] = $total_rows;
            $data['sheetData_a'] = $sheetData_a;
            $data['sheetData_b'] = $sheetData_b;
            $data['sheetData_c'] = $sheetData_c;
            $data['sheetData_d'] = $sheetData_d;
            $data['sheetData_e'] = $sheetData_e;
            $data['sheetData_f'] = $sheetData_f;
            $data['sheetData_g'] = $sheetData_g;
            $data['sheetData_h'] = $sheetData_h;
            $data['sheetData_i'] = $sheetData_i;
            $data['sheetData_j'] = $sheetData_j;
            $data['sheetData_k'] = $sheetData_k;
            $data['sheetData_l'] = $sheetData_l;
            $this->load->view('foreignPatentExcelView', $data);
        } else {
            echo "데이터가 없습니다.";
        }
    }

    function foreignPatentDataSave() {
        for ($i = 0; $i < $_POST['totalRows']; $i++) {
            if ($i != 0) {
                $sheet_C = $_POST['col_C'][$i];
                if ($_POST['col_K'][$i] == '공개') {
                    $sheet_K = 'T';
                } else if (!$_POST['col_K'][$i]) {
                    $sheet_K = 'F';
                }
                if ($_POST['col_C'][$i] == '거절') {
                    $sheet_C = 0;
                }
                if ($_POST['col_E'][$i]) {
                    $select_country_idx_sql = "SELECT
                                                COUNTRY_CODE_IDX 
                                               FROM 
                                                COUNTRY_CODE 
                                               WHERE 
                                                COUNTRY_CODE = '" . $_POST['col_E'][$i] . "'";
                    $country_idx_res = $this->Db_m->getInfo($select_country_idx_sql, 'JASENG');
                    $country_idx = $country_idx_res->COUNTRY_CODE_IDX;
                } else {
                    $country_idx = NULL;
                }
                $addData = array(
                    'APPLICATION_NUMBER' => $_POST['col_A'][$i],
                    'FILING_DATE' => str_replace("-", "", $_POST['col_B'][$i]),
                    'REG_NUMBER' => $sheet_C,
                    'REG_DATE' => str_replace("-", "", $_POST['col_D'][$i]),
                    'COUNTRY_CODE_IDX' => $country_idx,
                    'PATENT_NAME' => $_POST['col_F'][$i],
                    'SUMMATION' => $_POST['col_J'][$i],
                    'IS_SHOW' => $sheet_K,
                    'END_DATE' => str_replace("-", "", $_POST['col_L'][$i])
                );

//                print_r($addData);echo "<br>";

                $result = $this->Db_m->insData('FOREIGN_PATENT_STATUS', $addData, 'JASENG');

                $ins_id = $this->JASENG->insert_id();

                $applicants = explode(",", $_POST['col_G'][$i]);

                foreach ($applicants as $applicants_row) {
                    $addApplicants = array(
                        'FOREIGN_PATENT_STATUS_IDX' => $ins_id,
                        'APPLICANTS' => $applicants_row
                    );
                    $result_applicants = $this->Db_m->insData('FOREIGN_PATENT_APPLICANTS', $addApplicants, 'JASENG');
                }

                $registrant = explode(",", $_POST['col_H'][$i]);

                foreach ($registrant as $registrant_row) {
                    $addRegistrant = array(
                        'FOREIGN_PATENT_STATUS_IDX' => $ins_id,
                        'REGISTRANT' => $registrant_row
                    );
                    $result_registrant = $this->Db_m->insData('FOREIGN_PATENT_REGISTRANT', $addRegistrant, 'JASENG');
                }

                $inventor = explode(",", $_POST['col_I'][$i]);

                foreach ($inventor as $inventor_row) {
                    $addInventor_row = array(
                        'FOREIGN_PATENT_STATUS_IDX' => $ins_id,
                        'INVENTOR' => $inventor_row
                    );
                    $result_inventor = $this->Db_m->insData('FOREIGN_PATENT_INVENTOR', $addInventor_row, 'JASENG');
                }
            }
        }
//        exit;
        alert('업로드 되었습니다.', '/index.php/main');
    }

    function domesticBrandsDataLoadExcel() {
        $UpFile = $_FILES["domesticBrandsExcelUpFile"];

        $UpFileName = $UpFile["name"];

//        print_r($UpFile);

        $UpFilePathInfo = pathinfo($UpFileName);
        $UpFileExt = strtolower($UpFilePathInfo["extension"]);

        if ($UpFileExt != "xls" && $UpFileExt != "xlsx") {
            echo "엑셀파일만 업로드 가능합니다. (xls, xlsx 확장자의 파일포멧)";
            exit;
        }

        //업로드된 엑셀파일을 서버의 지정된 곳에 옮기기 위해 경로 적절히 설정
        $upload_path = $_SERVER["DOCUMENT_ROOT"] . "/upExcelFile/";
        $upfile_path = $upload_path . $UpFileName;


        if (is_uploaded_file($UpFile["tmp_name"])) {

            if (!move_uploaded_file($UpFile["tmp_name"], $upfile_path)) {
                echo "업로드된 파일을 옮기는 중 에러가 발생했습니다.";
                exit;
            }

//파일 타입 설정 (확자자에 따른 구분)
            $inputFileType = 'Excel2007';
            if ($UpFileExt == "xls") {
                $inputFileType = 'Excel5';
            }

//엑셀리더 초기화
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);

//데이터만 읽기(서식을 모두 무시해서 속도 증가 시킴)
            $objReader->setReadDataOnly(true);

//범위 지정(위에 작성한 범위필터 적용)
//            $objReader->setReadFilter($filterSubset);
//업로드된 엑셀 파일 읽기
            $objPHPExcel = $objReader->load($upfile_path);

//첫번째 시트로 고정
            $objPHPExcel->setActiveSheetIndex(0);

//고정된 시트 로드
            $objWorksheet = $objPHPExcel->getActiveSheet();

//시트의 지정된 범위 데이터를 모두 읽어 배열로 저장
            $sheetData_a = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_b = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_c = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_d = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_e = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_f = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_g = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_h = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_i = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_j = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_k = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
//            $sheetData_l = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $total_rows = '0';
            $total_rows = count($sheetData_a);
        }
        if ($total_rows >= 1) {
            $data['total_rows'] = $total_rows;
            $data['sheetData_a'] = $sheetData_a;

            $this->load->view('domesticBrandsExcelView', $data);
        } else {
            echo "데이터가 없습니다.";
        }
    }

    function domesticBrandsDataSave() {
        for ($i = 0; $i < $_POST['totalRows']; $i++) {
            if ($i != 0) {
                $sheet_h = 'T';
                if ($_POST['col_H'][$i] == '등록') {
                    $sheet_h = 'T';
                }
                if ($_POST['col_K'][$i] == 'ㅇ') {
                    $sheet_k = 'T';
                } else {
                    $sheet_k = 'F';
                }

                //DOMESTIC_BRANDS insert array
                $addData = array(
                    'APPLICATION_NUMBER' => $_POST['col_A'][$i][0],
                    'FILING_DATE' => str_replace("-", "", $_POST['col_B'][$i]),
                    'REG_NUMBER' => $_POST['col_C'][$i],
                    'BRAND' => $_POST['col_D'][$i],
                    'TRADENAME' => $_POST['col_E'][$i],
                    'STATE' => $sheet_h,
                    'EXPIRATION_DATE' => str_replace("-", "", $_POST['col_I'][$i]),
                    'REG_DATE' => str_replace("-", "", $_POST['col_J'][$i]),
                    'REG_EXISTENCE' => $sheet_k
                );

                //DOMESTIC_BRANDS insert sql function
                if ($addData['APPLICATION_NUMBER']) {
//                echo "data0 = ";
//                print_r($addData);
//                echo "<br>";

                    $result = $this->Db_m->insData('DOMESTIC_BRANDS', $addData, 'JASENG');

                    $ins_id = $this->JASENG->insert_id();

                    $application_number = $addData['APPLICATION_NUMBER'];
                }

                //code explode(explode by " ") serch count
                $code = explode(" ", $_POST['col_F'][$i]);
//            echo "codeArray = ";
//            print_r($code);
//            echo "<br>";

                for ($k = 0; $k < sizeof($code); $k++) {
                    //CODE_IDX serch sql function
                    $code_idx_selectSql = "SELECT
                                        CLASSIFICATION_CODE_IDX 
                                       FROM 
                                        CLASSIFICATION_CODE 
                                       WHERE 
                                        CODE = $code[$k]";
                    $code_idx_res = $this->Db_m->getInfo($code_idx_selectSql, 'JASENG');

                    //DOMESTIC_BRANDS_CODE insert array
                    $addData1 = array(
                        'DOMESTIC_BRANDS_IDX' => $ins_id,
                        'CLASSIFICATION_CODE_IDX' => $code_idx_res->CLASSIFICATION_CODE_IDX,
                        'APPLICATION_NUMBER' => $application_number
                    );
//                echo "date1 = ";
//                print_r($addData1);
//                echo "<br>";
                    $this->Db_m->insData('DOMESTIC_BRANDS_CODE', $addData1, 'JASENG');
                }

                //DOMESTIC_BRANDS_PRODUCT_DESIGNATION insert array
                $addData2 = array(
                    'DOMESTIC_BRANDS_IDX' => $ins_id,
                    'APPLICATION_NUMBER' => $application_number,
                    'PRODUCT_DESIGNATION' => $_POST['col_G'][$i]
                );
//            echo "date2 = ";
//            print_r($addData2);
//            echo "<br><br>";
                $this->Db_m->insData('DOMESTIC_BRANDS_PRODUCT_DESIGNATION', $addData2, 'JASENG');
            }
        }
        alert('업로드 되었습니다.', '/index.php/main');
    }

    function foreignBrandsDataLoadExcel() {
        $UpFile = $_FILES["foreignBrandsExcelUpFile"];

        $UpFileName = $UpFile["name"];

//        print_r($UpFile);

        $UpFilePathInfo = pathinfo($UpFileName);
        $UpFileExt = strtolower($UpFilePathInfo["extension"]);

        if ($UpFileExt != "xls" && $UpFileExt != "xlsx") {
            echo "엑셀파일만 업로드 가능합니다. (xls, xlsx 확장자의 파일포멧)";
            exit;
        }

        //업로드된 엑셀파일을 서버의 지정된 곳에 옮기기 위해 경로 적절히 설정
        $upload_path = $_SERVER["DOCUMENT_ROOT"] . "/upExcelFile/";
        $upfile_path = $upload_path . $UpFileName;


        if (is_uploaded_file($UpFile["tmp_name"])) {

            if (!move_uploaded_file($UpFile["tmp_name"], $upfile_path)) {
                echo "업로드된 파일을 옮기는 중 에러가 발생했습니다.";
                exit;
            }

//파일 타입 설정 (확자자에 따른 구분)
            $inputFileType = 'Excel2007';
            if ($UpFileExt == "xls") {
                $inputFileType = 'Excel5';
            }

//엑셀리더 초기화
            $objReader = PHPExcel_IOFactory::createReader($inputFileType);

//데이터만 읽기(서식을 모두 무시해서 속도 증가 시킴)
            $objReader->setReadDataOnly(true);

//범위 지정(위에 작성한 범위필터 적용)
//            $objReader->setReadFilter($filterSubset);
//업로드된 엑셀 파일 읽기
            $objPHPExcel = $objReader->load($upfile_path);

//첫번째 시트로 고정
            $objPHPExcel->setActiveSheetIndex(0);

//고정된 시트 로드
            $objWorksheet = $objPHPExcel->getActiveSheet();

//시트의 지정된 범위 데이터를 모두 읽어 배열로 저장
            $sheetData_a = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_b = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_c = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_d = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_e = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_f = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_g = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_h = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_i = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_j = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_k = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);
            $sheetData_l = $objPHPExcel->getActiveSheet()->toArray(null, true, true, true);

            $total_rows = '0';
            $total_rows = count($sheetData_a);
        }
        if ($total_rows >= 1) {
            $data['total_rows'] = $total_rows;
            $data['sheetData_a'] = $sheetData_a;

            $this->load->view('foreignBrandsExcelView', $data);
        } else {
            echo "데이터가 없습니다.";
        }
    }

    function foreignBrandsDataSave() {
        $o = 0;
        for ($i = 0; $i < $_POST['totalRows']; $i++) {

            if ($_POST['col_L'][$i] == "ㅇ") {
                $reg_existence = "T";
            } else {
                $reg_existence = "F";
            }

            $final_disposal = "";
            if ($_POST['col_K'][$i] == "공고") {
                $final_disposal = "G";
            }
            if ($_POST['col_K'][$i] == "출원") {
                $final_disposal = "C";
            }
            if ($_POST['col_K'][$i] == "등록결정") {
                $final_disposal = "A";
            }
            if ($_POST['col_K'][$i] == "거절") {
                $final_disposal = "F";
            }

            if ($_POST['col_A'][$i] && $_POST['col_A'][$i] != '마드리드' && $i > 0) {
                //COUNTRY_CODE select idx
                $country_code_sql = "SELECT
                                        COUNTRY_CODE_IDX FROM COUNTRY_CODE WHERE CODE_NAME LIKE '%" . $_POST['col_A'][$i] . "%'";
                $country_code_res = $this->Db_m->getInfo($country_code_sql, 'JASENG');

                //FOREIGN_BRANDS insert array
                $addData = array(
                    'COUNTRY_CODE_IDX' => $country_code_res->COUNTRY_CODE_IDX,
                    'BRAND' => $_POST['col_B'][$i],
                    'FILING_DATE' => str_replace("-", "", $_POST['col_C'][$i])
                );
//                echo "FOREIGN_BRANDS = ";print_r($addData);echo "<br>";

                $result = $this->Db_m->insData('FOREIGN_BRANDS', $addData, 'JASENG');

                $ins_id = $this->JASENG->insert_id();

                //분류코드 
                $code = explode(",", $_POST['col_H'][$i]);

                for ($l = 0; $l < sizeof($code); $l++) {
                    //CLASSIFICATION_CODE_IDX select idx
                    $code_idx_selectSql = "SELECT
                                        CLASSIFICATION_CODE_IDX 
                                       FROM 
                                        CLASSIFICATION_CODE 
                                       WHERE 
                                        CODE = $code[$l]";
                    $code_idx_res = $this->Db_m->getInfo($code_idx_selectSql, 'JASENG');

                    //FOREIGN_BRANDS_CODE insert array
                    $addData1 = array(
                        'FOREIGN_BRANDS_IDX' => $ins_id,
                        'CLASSIFICATION_CODE_IDX' => $code_idx_res->CLASSIFICATION_CODE_IDX
                    );
//                    echo "FOREIGN_BRANDS_CODE = ";print_r($addData1); echo "<br>";
                    $result = $this->Db_m->insData('FOREIGN_BRANDS_CODE', $addData1, 'JASENG');
                }

                //출원자
                $applicants = explode(",", $_POST['col_I'][$i]);

                for ($k = 0; $k < sizeof($applicants); $k++) {
                    //FOREIGN_BRANDS_APPLICANTS insert array
                    $addData2 = array(
                        'FOREIGN_BRANDS_IDX' => $ins_id,
                        'APPLICANTS' => $applicants[$k]
                    );
//                    echo "FOREIGN_BRANDS_APPLICANTS = ";print_r($addData2); echo "<br>";
                    $result = $this->Db_m->insData('FOREIGN_BRANDS_APPLICANTS', $addData2, 'JASENG');
                }

                //FOREIGN_BRANDS_SPECIFY_COUNTRY insert array
                $addData3 = array(
                    'FOREIGN_BRANDS_IDX' => $ins_id,
//                        'COUNTRY_CODE_IDX' => $applicants[$k],
                    'APPLICATION_NUMBER' => $_POST['col_D'][$i],
                    'REG_DATE' => str_replace("-", "", $_POST['col_E'][$i]),
                    'END_DATE' => str_replace("-", "", $_POST['col_F'][$i]),
                    'REG_NUMBER' => $_POST['col_G'][$i],
                    'FINAL_DISPOSAL' => $final_disposal,
                    'REG_EXISTENCE' => $reg_existence
                );
//                echo "FOREIGN_BRANDS_SPECIFY_COUNTRY = ";print_r($addData3);echo "<br><br>";
                $result = $this->Db_m->insData('FOREIGN_BRANDS_SPECIFY_COUNTRY', $addData3, 'JASENG');
            }

            if ($_POST['col_A'][$i] && $_POST['col_A'][$i] == '마드리드' && $i > 0) {
                $o ++;
                //COUNTRY_CODE select idx
                $country_code_sql = "SELECT
                                        COUNTRY_CODE_IDX 
                                     FROM 
                                        COUNTRY_CODE 
                                     WHERE 
                                        CODE_NAME LIKE '%" . $_POST['col_A'][$i] . "%'";
                $country_code_res = $this->Db_m->getInfo($country_code_sql, 'JASENG');

                //FOREIGN_BRANDS insert array
                $addData = array(
                    'COUNTRY_CODE_IDX' => $country_code_res->COUNTRY_CODE_IDX,
                    'BRAND' => $_POST['col_B'][$i],
                    'FILING_DATE' => str_replace("-", "", $_POST['col_C'][$i])
                );
//                echo "마드리드 FOREIGN_BRANDS = ";print_r($addData);echo "<br>";
                $result = $this->Db_m->insData('FOREIGN_BRANDS', $addData, 'JASENG');

                $ins_id = $this->JASENG->insert_id();

                //분류코드 
                $code = explode(",", $_POST['col_H'][$i]);

                for ($l = 0; $l < sizeof($code); $l++) {
                    //CLASSIFICATION_CODE_IDX select idx
                    $code_idx_selectSql = "SELECT
                                        CLASSIFICATION_CODE_IDX 
                                       FROM 
                                        CLASSIFICATION_CODE 
                                       WHERE 
                                        CODE = $code[$l]";
                    $code_idx_res = $this->Db_m->getInfo($code_idx_selectSql, 'JASENG');

                    //FOREIGN_BRANDS_CODE insert array
                    $addData1 = array(
                        'FOREIGN_BRANDS_IDX' => $ins_id,
                        'CLASSIFICATION_CODE_IDX' => $code_idx_res->CLASSIFICATION_CODE_IDX
                    );
//                    echo "마드리드 FOREIGN_BRANDS_CODE = ";print_r($addData1); echo "<br>";
                    $result = $this->Db_m->insData('FOREIGN_BRANDS_CODE', $addData1, 'JASENG');
                }

                //출원자
                $applicants = explode(",", $_POST['col_I'][$i]);

                for ($k = 0; $k < sizeof($applicants); $k++) {
                    //FOREIGN_BRANDS_APPLICANTS insert array
                    $addData2 = array(
                        'FOREIGN_BRANDS_IDX' => $ins_id,
                        'APPLICANTS' => $applicants[$k]
                    );
//                    echo "마드리드 FOREIGN_BRANDS_APPLICANTS = ";print_r($addData2); echo "<br>";
                    $result = $this->Db_m->insData('FOREIGN_BRANDS_APPLICANTS', $addData2, 'JASENG');
                }


//                    echo "배열수 = ".sizeof($_POST['col_J1'.$o]);
                for ($m = 0; $m < sizeof($_POST['col_J1' . $o]); $m++) {
                    if ($_POST['col_L1' . $o][$m] == "ㅇ") {
                        $reg_existence = "T";
                    } else {
                        $reg_existence = "F";
                    }

                    $final_disposal = "";
                    if ($_POST['col_K1' . $o][$m] == "공고") {
                        $final_disposal = "G";
                    }
                    if ($_POST['col_K1' . $o][$m] == "출원") {
                        $final_disposal = "C";
                    }
                    if ($_POST['col_K1' . $o][$m] == "등록결정") {
                        $final_disposal = "A";
                    }
                    if ($_POST['col_K1' . $o][$m] == "거절") {
                        $final_disposal = "F";
                    }

                    if (!$_POST['col_D1' . $o][$m]) {
                        $application_number = $_POST['col_D'][$i];
                    } else {
                        $application_number = $_POST['col_D1' . $o][$m];
                    }

//                    print_r($_POST['col_J1'.$o][$m]);
                    //COUNTRY_CODE select idx
                    $country_code_sql = "SELECT
                                            COUNTRY_CODE_IDX 
                                         FROM 
                                            COUNTRY_CODE 
                                         WHERE 
                                            CODE_NAME LIKE '%" . $_POST['col_J1' . $o][$m] . "%'";

                    $country_code_res = $this->Db_m->getInfo($country_code_sql, 'JASENG');


                    //FOREIGN_BRANDS_SPECIFY_COUNTRY insert array
                    $addData3 = array(
                        'FOREIGN_BRANDS_IDX' => $ins_id,
                        'COUNTRY_CODE_IDX' => $country_code_res->COUNTRY_CODE_IDX,
                        'APPLICATION_NUMBER' => $application_number,
                        'REG_DATE' => str_replace("-", "", $_POST['col_E1' . $o][$m]),
                        'END_DATE' => str_replace("-", "", $_POST['col_F1' . $o][$m]),
                        'REG_NUMBER' => $_POST['col_G1' . $o][$m],
                        'FINAL_DISPOSAL' => $final_disposal,
                        'REG_EXISTENCE' => $reg_existence
                    );
//                    echo "마드리드 FOREIGN_BRANDS_SPECIFY_COUNTRY = ";print_r($addData3);echo "<br>";
                    $result = $this->Db_m->insData('FOREIGN_BRANDS_SPECIFY_COUNTRY', $addData3, 'JASENG');
                }
//                echo "<br>";
            }
        }
        alert('업로드 되었습니다.', '/index.php/main');
    }

}

?>