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
                $applicants = explode(", ", $_POST['col_F'][$i]);

                foreach ($applicants as $applicants_row) {
                    $addApplicants = array(
                        'KOR_PATENT_STATUS_IDX' => $ins_id,
                        'APPLICATION_NUMBER' => $_POST['col_A'][$i],
                        'APPLICANTS' => $applicants_row
                    );
                    $result_applicants = $this->Db_m->insData('KOR_PATENT_APPLICANTS', $addApplicants, 'JASENG');
                }

                $registrant = explode(", ", $_POST['col_G'][$i]);

                foreach ($registrant as $registrant_row) {
                    $addRegistrant = array(
                        'KOR_PATENT_STATUS_IDX' => $ins_id,
                        'APPLICATION_NUMBER' => $_POST['col_A'][$i],
                        'REGISTRANT' => $registrant_row
                    );
                    $result_registrant = $this->Db_m->insData('KOR_PATENT_REGISTRANT', $addRegistrant, 'JASENG');
                }

                $inventor = explode(", ", $_POST['col_H'][$i]);

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
            $sheet_h = 'T';
            if($_POST['col_H'][$i] == '등록'){
                $sheet_h = 'T';
            }
            if($_POST['col_K'][$i] == 'ㅇ'){
                $sheet_k = 'T';
            }else{
                $sheet_k = 'F';
            }
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
//                    'END_DATE' => str_replace("-", "", $_POST['col_J'][$i]),
//                    'PATENT_NAME' => $_POST['col_E'][$i],
//                    'IS_SHOW' => $sheet_I
            );
            if ($addData['APPLICATION_NUMBER']) {
                print_r($addData);
                echo "<br>";
            }
            for ($j = 0; $j < sizeof($_POST['col_A1'][$j]); $j++) {
                $addData1 = array(
                    'APPLICATION_NUMBER' => $_POST['col_A1'][$j],
                    'CODE' => $_POST['col_F'][$i]
                );
                $addData2 = array(
                    'APPLICATION_NUMBER' => $_POST['col_A1'][$j],
                    'PRODUCT_DESIGNATION' => $_POST['col_G'][$i]
                );
            }
            print_r($addData1);
                echo "<br>";
                print_r($addData2);
                echo "<br>";
        }
    }

}

?>