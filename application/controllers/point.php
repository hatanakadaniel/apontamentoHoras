<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of point
 *
 * @author dhatanaka
 */
class Point extends MY_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('point_model', 'point');
        $this->load->language('point', 'pt-br');
        
        $this->load->library('form_validation');
        $this->load->language('form_validation', 'pt-br');
    }
    
    public function register()
    {
        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('date', 'Data', 'trim|xss_clean|required|callback_isDate');
            $this->form_validation->set_rules('time', 'Horário', 'trim|xss_clean|required|callback_isTime');
            if ($this->form_validation->run() == FALSE) {
                echo json_encode(
                    array(
                        "response"=>false,
                        "message" => $this->form_validation->error('time').$this->form_validation->error('date')
                    )
                );
            } else {
                $iptDate = $this->input->post('date');
                $iptTime = $this->input->post('time');
                if (isset($iptDate) && isset($iptTime) && !empty($iptDate) && !empty($iptTime)) {
                    $point = new stdClass();
                    $curDateTime = new DateTime($iptDate." ".$iptTime);
                    $point->dateTime = $curDateTime->format('Y-m-d H:i:s');
                    $this->point->insert($point);
                    echo json_encode(
                        array(
                            "response" => true,
                            "message" => $this->lang->line('point_success')
                        )
                    );
                } else {
                    echo json_encode(
                        array(
                            "response"=>false,
                            "message" => $this->lang->line('point_error')
                        )
                    );
                }
            }
        }
    }
    
    public function loadIndexPointTable()
    {
        if ($this->input->is_ajax_request()) {
            $curDateTime = new DateTime();
            $points = $this->createPoints($this->point->listAllbyDay($curDateTime->format('Y-m-d')));
            $timeLeft = $this->timeLeft($points);
            $timeElapsed = $this->timeElapsed($points);
            $timeEstimate = $this->timeEstimate($points);
            $timesPartial = $this->timesPartial($points);
            $pointsFormated = $this->formatPoints($points, $timesPartial);
            $this->addData(
                array(
                    'points' => $pointsFormated,
                    'timeEstimate' => isset($timeEstimate)&&!empty($timeEstimate)?$timeEstimate->format('H:i'):'-',
                    'timeElapsed' => $timeElapsed->format('H:i'),
                    'timeLeft' => $timeLeft->format('H:i')
                )
            );
            $this->load->view('site/index-pointTable', $this->getData());
        }
    }
    
    public function loadMonthPointTable()
    {
        if ($this->input->is_ajax_request()) {
            $curDateTime = new DateTime();
        
            $pointsMonth = $this->createMonthPoints($this->point->listAllbyMonth($curDateTime->format('Y-m-d')));
            $dateBegin = new DateTime('first day of '.$curDateTime->format('Y').'-'.$curDateTime->format('m'));
            $dateEnd = new DateTime('last day of '.$curDateTime->format('Y').'-'.$curDateTime->format('m'));

            $numMaxPointsMonth = $this->countNumMaxPointsMonth($pointsMonth);

            $totalHoursMonth = $this->timeElapsedMonth($pointsMonth);
            
            $timeBalance = $this->timeBalance($pointsMonth);
            
            $pointsMonthFormated = $this->formatPointsMonth($pointsMonth, $dateBegin, $dateEnd);
            
            $this->addData(
                array(
                    'pointsMonthFormated' => $pointsMonthFormated,
                    'numMaxPointsMonth' => $numMaxPointsMonth,
                    'totalHoursMonth' => ($totalHoursMonth->d*24+$totalHoursMonth->h.':'.$totalHoursMonth->i),
                    'timeBalance' => array(
                        'inverted' => $timeBalance->invert,
                        'interval' => str_pad(
                            $timeBalance->d*24+$timeBalance->h, 2, '0', STR_PAD_LEFT
                        ).':'.str_pad(
                            $timeBalance->i, 2, '0', STR_PAD_LEFT
                        )
                    )
                )
            );
            $this->load->view('site/month-pointTable', $this->getData());
        }
    }

    public function isDate($str)
    {
        if (preg_match('/^[0-9]{4}-[0-9]{2}-[0-9]{2}$/', $str) != 1) {
            $this->form_validation->set_message('isDate', 'O campo %s não está no formato correto');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
    public function isTime($str)
    {
        if (preg_match('/^(([0-1]{1}[0-9]{1})|([2]{1}[0-3]{1})):[0-5]{1}[0-9]{1}$/', $str) != 1) {
            $this->form_validation->set_message('isTime', 'O campo %s não está no formato correto');
            return FALSE;
        } else {
            return TRUE;
        }
    }
    
}
