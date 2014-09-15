<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of MY_Controller
 *
 * @author dhatanaka
 */
class MY_Controller extends CI_Controller
{
    
    private $data = array();
    
    public function __construct()
    {
        parent::__construct();
        $this->load->model('menu_model', 'menu');
        $this->data = array(
            'menu' => $this->menu->getItensMenu(),
            'js' => array(),
            'css' => array()
        );
        $this->addCSS(array('index.css'));
        $this->addJS(array('index.js'));
    }
    
    public function addJS($arrayJS=array())
    {
        $this->data['js'] = array_merge($this->data['js'], $arrayJS);
    }
    
    public function addCSS($arrayCSS=array())
    {
        $this->data['css'] = array_merge($this->data['css'], $arrayCSS);
    }
    
    public function addData($arrayData=array())
    {
        $this->data = array_merge($this->data, $arrayData);
    }
    
    public function getData()
    {
        return $this->data;
    }

    public function loadView($view='site/index')
    {
        $this->addData(array('view' => $view));
        $this->load->view('index', $this->data);
    }
    
    protected function timeElapsedMonth($pointsMonth)
    {
//        print_r($pointsMonth);
//        die();
        $teste = new DateTime('00:00');
        $timeElapsedMonth = new DateTime('00:00');
        if (isset($pointsMonth) && !empty($pointsMonth)) {
            foreach ($pointsMonth as $pointMonth) {
                $dateDiff = $timeElapsedMonth->diff($this->timeElapsed($pointMonth->dayPoints), true);
                $timeElapsedMonth->add($dateDiff);
//                print_r($timeElapsedMonth);
//                die();
            }
            $timeElapsedMonth = ($timeElapsedMonth->getTimestamp() - $teste->getTimestamp())/3600;
        }
        print_r(intval($timeElapsedMonth));
        echo "<br><br>";
        print_r($timeElapsedMonth->h);
        die();
        return $timeElapsedMonth;
    }
    
    protected function timeElapsed($points)
    {
        $timeElapsed = new DateTime('00:00');
        if (isset($points) && !empty($points)) {
            for (
                $i=0;
                (
                    (($i < count($points)) && (count($points)%2 === 0)) ||
                    (($i < count($points)-1) && (count($points)%2 !== 0))
                ) ? true : false;
                $i+=2
            ) {
                $diffTime = $points[$i]->diff($points[$i+1]);
                $timeElapsed->add($diffTime);
            }
        }
        return $timeElapsed;
    }
    
    protected function timeLeft($points)
    {
        $timeLeft = new DateTime('08:00');
        if (isset($points) && !empty($points)) {
            for (
                $i=0;
                (
                    (($i < count($points)) && (count($points)%2 === 0)) ||
                    (($i < count($points)-1) && (count($points)%2 !== 0))
                ) ? true : false;
                $i+=2
            ) {
                $diffTime = $points[$i]->diff($points[$i+1]);
                $timeLeft->sub($diffTime);
                if ($timeLeft < new DateTime('00:00')) {
                    $timeLeft = new DateTime('00:00');
                }
            }
        }
        return $timeLeft;
    }
    
    protected function timeEstimate($points)
    {
        $timeLeft = new DateTime('00:00');
        $timeEstimate = null;
        if (isset($points) && !empty($points) && $this->timeLeft($points) > new DateTime('00:00')) {
            if (count($points)%2 === 1) {
                $timeEstimate = clone $points[count($points)-1];
                $diffTime = $timeLeft->diff($this->timeLeft($points));
                $timeEstimate->add($diffTime);
            }
        }
        return $timeEstimate;
    }
    
    protected function timesPartial($points)
    {
        $timePartial = array();
        if (isset($points) && !empty($points)) {
            for (
                $i=0;
                (
                    (($i < count($points)) && (count($points)%2 === 0)) ||
                    (($i < count($points)-1) && (count($points)%2 !== 0))
                ) ? true : false;
                $i+=2
            ) {
                $auxTimePartial = new DateTime('00:00');
                $diffTime = $points[$i]->diff($points[$i+1]);
                $auxTimePartial->add($diffTime);
                array_push($timePartial, $auxTimePartial);
            }
        }
        return $timePartial;
    }


    protected function createPoints($points)
    {
        if (isset($points) && !empty($points)) {
            foreach ($points as &$point) {
                $point = new DateTime($point->dateTime);
            }
        }
        return $points;
    }
    
    protected function createMonthPoints($monthPoints)
    {
        if (isset($monthPoints) && !empty($monthPoints)) {
            
            foreach ($monthPoints as &$dayPoint) {
                $dayPoint->dayOfMonth = new DateTime($dayPoint->dayOfMonth);
                $auxDayPoints = json_decode($dayPoint->dayPoints);
                
                foreach ($auxDayPoints as &$auxDayPoint) {
                    $auxDayPoint = new DateTime($auxDayPoint->dateTime);
                }
//                print_r($auxDayPoints);
//                echo "<br><br>";
//                die();
                
                $dayPoint->dayPoints = $auxDayPoints;
//                print_r($dayPoint);
//                die();
                
            }
        }
        return $monthPoints;
    }
    
    protected function formatPoints($points, $timesPartial)
    {
        $pointsFormated = array();
        if (isset($points) && !empty($points)) {
            foreach ($points as $i => $point) {
                $auxPointsFormated = new stdClass();
                $auxPointsFormated->hour = $point->format('H:i');
                if ($i%2 === 0 && isset($timesPartial) && !empty($timesPartial) && array_key_exists(($i/2), $timesPartial)) {
                    $auxPointsFormated->partial = $timesPartial[($i/2)]->format('H:i');
                }
                array_push($pointsFormated, $auxPointsFormated);
            }
        }
        return $pointsFormated;
    }
    
    protected function formatPointsMonth($pointsMonth, $dateBegin, $dateEnd)
    {
        $pointsMonthFormated = array();
        for ($date = clone $dateBegin; $date <= $dateEnd; $date->add(new DateInterval('P1D'))) {
            $pointsDay = new stdClass();
            $pointsDay->dayOfMonth = $date->format('d/m/Y');
            $pointsDay->totalHour = 0;
            if (isset($pointsMonth) && !empty($pointsMonth)) {
                foreach ($pointsMonth as $pointMonth) {
//                    var_dump($date);
//                    var_dump($pointMonth->dayOfMonth);
//                    die();
//                    echo "<br><br>";
                    if ($date == $pointMonth->dayOfMonth) {
                        $pointsDay->dayPoints = array();
//                        $totalHour = new DateTime('00:00');
                        foreach ($pointMonth->dayPoints as $dayPoint) {
//                            $auxPointFormated = new stdClass();
//                            $auxPointsFormated->hour = $point->format('H:i');
//                            if ($i%2 === 0 && isset($timesPartial) && !empty($timesPartial) && array_key_exists(($i/2), $timesPartial)) {
//                                $auxPointsFormated->partial = $timesPartial[($i/2)]->format('H:i');
//                            }
                            array_push($pointsDay->dayPoints, $dayPoint->format('H:i'));
                        }
                        $pointsDay->totalHour = $this->timeElapsed($pointMonth->dayPoints)->format('H:i');
                    }
                }
            }
            array_push($pointsMonthFormated, $pointsDay);
//            print_r($date);
//            echo "<br>";
        }
        
        return $pointsMonthFormated;
    }
    
}
