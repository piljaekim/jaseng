<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Calendar_lib extends CI_Controller {

    function __construct() {
        parent::__construct();

        $prefs = array(
            'start_day' => 'saturday',
            'month_type' => 'long',
            'day_type' => 'short',
            'show_next_prev' => TRUE,
            'next_prev_url' => 'http://192.168.0.27/index.php/calendar_lib/index'
        );

        $prefs['template'] = '

            {table_open}<table border="1" cellpadding="0" cellspacing="0">{/table_open}

            {heading_row_start}<tr>{/heading_row_start}

            {heading_previous_cell}<th><a href="{previous_url}">&lt;&lt;</a></th>{/heading_previous_cell}
            {heading_title_cell}<th colspan="{colspan}">{heading}</th>{/heading_title_cell}
            {heading_next_cell}<th><a href="{next_url}">&gt;&gt;</a></th>{/heading_next_cell}

            {heading_row_end}</tr>{/heading_row_end}

            {week_row_start}<tr>{/week_row_start}
            {week_day_cell}<td>{week_day}</td>{/week_day_cell}
            {week_row_end}</tr>{/week_row_end}

            {cal_row_start}<tr>{/cal_row_start}
            {cal_cell_start}<td>{/cal_cell_start}

            {cal_cell_content}<a href="{content}">{day}</a>{/cal_cell_content}
            {cal_cell_content_today}<div class="highlight"><a href="{content}">{day}</a></div>{/cal_cell_content_today}

            {cal_cell_no_content}{day}{/cal_cell_no_content}
            {cal_cell_no_content_today}<div class="highlight">{day}</div>{/cal_cell_no_content_today}

            {cal_cell_blank}&nbsp;{/cal_cell_blank}

            {cal_cell_end}</td>{/cal_cell_end}
            {cal_row_end}</tr>{/cal_row_end}

            {table_close}</table>{/table_close}
        ';


        $this->load->library('Calendar', $prefs);
    }

    function index() {

        $data = array(
            date('d') => 'main/showShowtimes',
            date('d') + 1 => 'main/showShowtimes',
            date('d') + 2 => 'main/showShowtimes',
            date('d') + 3 => 'main/showShowtimes'
        );
        if(!$this->uri->segment(3)){
            $year = date('Y');
        }else{
            $year = $this->uri->segment(3);
        }
        
        if(!$this->uri->segment(4)){
            $month = date('m');
        }else{
            $month = $this->uri->segment(4);
        }
        $data['calender'] = $this->calendar->generate($year, $month, $data);
        $this->load->view('calendar_lib_sample', $data);
    }

}
