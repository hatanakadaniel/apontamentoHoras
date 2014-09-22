<?php

if (!defined('BASEPATH')) {
    exit('No direct script access allowed');
}

class site extends MY_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('point_model', 'point');
    }

    public function index()
    {
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
        
        $this->addData(array('curDateTime' => $curDateTime->format('Y/m/d H:i:s')));
        $this->addData(array('mensagem' => $this->lang->line('error_teste')));
        $this->addJS(array('site/index.js'));
        $this->addCSS(array('site/index.css'));
        $this->loadView('site/index');
    }
    
    public function month()
    {
        $curDateTime = new DateTime();
        
        $pointsMonth = $this->createMonthPoints($this->point->listAllbyMonth($curDateTime->format('Y-m-d')));
        $dateBegin = new DateTime('first day of '.$curDateTime->format('Y').'-'.$curDateTime->format('m'));
        $dateEnd = new DateTime('last day of '.$curDateTime->format('Y').'-'.$curDateTime->format('m'));
        
        $numMaxPointsMonth = $this->countNumMaxPointsMonth($pointsMonth);
        
        $totalHoursMonth = $this->timeElapsedMonth($pointsMonth);
        
//        print_r($pointsMonth);
//        echo "<br><br>";
//        print_r($this->countNumMaxPointsMonth($pointsMonth));
//        echo "<br><br>";
//        die();
//        $date = new DateTime();
//        for ($date = clone $dateBegin; $date <= $dateEnd; $date->add(new DateInterval('P1D'))) {
//            print_r($date);
//            echo "<br>";
//        }
        $pointsMonthFormated = $this->formatPointsMonth($pointsMonth, $dateBegin, $dateEnd);
//        print_r($pointsMonthFormated);
//        die();
        $this->addData(
            array(
                'pointsMonthFormated' => $pointsMonthFormated,
                'numMaxPointsMonth' => $numMaxPointsMonth,
                'totalHoursMonth' => ($totalHoursMonth->d*24+$totalHoursMonth->h.':'.$totalHoursMonth->i)
            )
        );
        $this->addJS(array('site/month.js'));
        $this->addCSS(array('site/month.css'));
        $this->menu->setItemActive('Mês');
        $this->loadView('site/month');
    }
    
    
//    private function countHoursMonth($pointsMonth)
//    {
//        $numMax = 0;
//        if (isset($pointsMonth) && !empty($pointsMonth)) {
//            foreach ($pointsMonth as $pointMonth) {
//                $numMax = count($pointMonth->dayPoints)>$numMax?count($pointMonth->dayPoints):$numMax;
//            }
//        }
//        return $numMax;
//    }

}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
