<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calendar_lib extends CI_Controller {

    function __construct() {
        parent::__construct();

        $prefs = array(
            'start_day' => 'sunday',
            'month_type' => 'long',
            'day_type' => 'short',
            'show_next_prev' => TRUE,
            'next_prev_url' => 'http://192.168.0.27/index.php/calendar_lib/index'
        );

        $prefs['template'] = '

            {table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar">{/table_open}

            {heading_row_start}<tr>{/heading_row_start}

            {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
            {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
            {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

            {heading_row_end}</tr>{/heading_row_end}

            {week_row_start}<tr>{/week_row_start}
            {week_day_cell}<td>{week_day}</td>{/week_day_cell}
            {week_row_end}</tr>{/week_row_end}

            {cal_row_start}<tr class="days">{/cal_row_start}
            {cal_cell_start}<td class="day">{/cal_cell_start}

            {cal_cell_content}
                <div class="day_num">{day}</div>
                <div class="content">{content}</div>
            {/cal_cell_content}
            {cal_cell_content_today}
                <div class="day_num highlight">{day}</div>
                <div class="content">{content}</div>
            {/cal_cell_content_today}

            {cal_cell_no_content}
                <div class="day_num">{day}</div>
            {/cal_cell_no_content}
            {cal_cell_no_content_today}
                <div class="day_num highlight">{day}</div>
            {/cal_cell_no_content_today}

            {cal_cell_blank}&nbsp;{/cal_cell_blank}

            {cal_cell_end}</td>{/cal_cell_end}
            {cal_row_end}</tr>{/cal_row_end}

            {table_close}</table>{/table_close}
        ';

        $this->JASENG = $this->load->database('JASENG', TRUE);
        $this->load->helper(array('url', 'date', 'form', 'alert'));
        $this->load->model('Db_m');
        $this->load->library('Calendar', $prefs);
    }

    //달력 로드시 데이터 조회쿼리
    function get_calendar_data($year, $month) {
        $sql = "SELECT
                    DATE, CONTENTS
                FROM 
                    CALENDAR 
                WHERE 
                    DATE LIKE '$year-$month%'";
        $res = $this->Db_m->getList($sql, 'JASENG');

        $data = array();
        foreach ($res as $row) {
            $data[substr($row['DATE'], 8, 2)] = $row['CONTENTS'];
        }
        return $data;
    }

    //달력에서 직접 데이터 입력 수정
    function add_calendar_data($date, $data) {
        $select_count = "SELECT
                            COUNT(*) CNT 
                         FROM 
                            CALENDAR 
                         WHERE 
                            DATE='$date'";
        $res_count = $this->Db_m->getInfo($select_count, 'JASENG');

        if ($res_count->CNT >= 1) {
            $upDate_sql = "UPDATE CALENDAR SET CONTENTS='$data' WHERE DATE='$date'";
            $res_update = $this->JASENG->query($upDate_sql);
        } else {
            $addData = array(
                'DATE' => $date,
                'CONTENTS' => $data
            );

            $res = $this->Db_m->insData('CALENDAR', $addData, 'JASENG');
        }
    }

    //달력부르는 function
    function index() {

        if (!$this->uri->segment(3)) {
            $year = date('Y');
        } else {
            $year = $this->uri->segment(3);
        }

        if (!$this->uri->segment(4)) {
            $month = date('m');
        } else {
            $month = $this->uri->segment(4);
        }

        if ($day = $this->input->post('day')) {
            $this->add_calendar_data("$year-$month-$day", $this->input->post('data'));
        }

//        $this->add_calendar_data('2015-07-20', '추가테스트 업데이트');

        $data = $this->get_calendar_data($year, $month);
        $data['calender'] = $this->calendar->generate($year, $month, $data);
        $this->load->view('calendar_lib_sample', $data);
    }

    //버튼 일정저장버튼
    function saveContents() {
        $select_count = "SELECT
                            COUNT(*) CNT 
                         FROM 
                            CALENDAR 
                         WHERE 
                            DATE='" . $_POST['date'] . "'";
        $res_count = $this->Db_m->getInfo($select_count, 'JASENG');

        if ($res_count->CNT >= 1) {
            $upDate_sql = "UPDATE CALENDAR SET CONTENTS='" . $_POST['contents'] . "' WHERE DATE='" . $_POST['date'] . "'";
            $res = $this->JASENG->query($upDate_sql);
        } else {
            $addData = array(
                'DATE' => $_POST['date'],
                'CONTENTS' => $_POST['contents']
            );

            $res = $this->Db_m->insData('CALENDAR', $addData, 'JASENG');
        }
        
        if($res){
            echo "SUCCESS";
        }else{
            echo "FAILED";
        }
    }

}
