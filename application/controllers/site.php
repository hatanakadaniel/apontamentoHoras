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
        $this->load->language('month', 'pt-br');
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
        $this->addJS(array('site/index.js'));
        $this->addCSS(array('site/index.css'));
        $this->loadView('site/index');
    }
    
    public function month($month='')
    {
//        print_r($month);
//        die();
        $curDateTime = new DateTime($month);

        $forMonth = clone $curDateTime;
        $forMonth->add(new DateInterval('P1M'));
        $backMonth = clone $curDateTime;
        $backMonth->sub(new DateInterval('P1M'));

//        print_r($forMonth->format('M'));
//        echo "<br><br>";
//        print_r($backMonth);
//        die();
        
        $pointsMonth = $this->createMonthPoints($this->point->listAllbyMonth($curDateTime->format('Y-m-d')));
//        print_r($pointsMonth);
//        die();
        
        $dateBegin = new DateTime('first day of '.$curDateTime->format('Y').'-'.$curDateTime->format('m'));
        $dateEnd = new DateTime('last day of '.$curDateTime->format('Y').'-'.$curDateTime->format('m'));
        
        $numMaxPointsMonth = $this->countNumMaxPointsMonth($pointsMonth);
        
        $totalHoursMonth = $this->timeElapsedMonth($pointsMonth);
        
        $timeBalance = $this->timeBalance($pointsMonth);
        
        $pointsMonthFormated = $this->formatPointsMonth($pointsMonth, $dateBegin, $dateEnd);
        
//        print_r($pointsMonthFormated);
//        die();
        
        
        if (isset($timeBalance) && !empty($timeBalance)) {
            $this->addData(
                array(
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
        }
        if (strcmp(strtoupper(get_class($totalHoursMonth)), strtoupper('DateInterval')) == 0) {
            $this->addData(
                array(
                    'totalHoursMonth' => ($totalHoursMonth->d*24+$totalHoursMonth->h.':'.$totalHoursMonth->i)
                )
            );
        }
        
        $this->addData(
            array(
                'pointsMonthFormated' => $pointsMonthFormated,
                'numMaxPointsMonth' => $numMaxPointsMonth,
                'backMonth' => strtolower($backMonth->format('M')),
                'forMonth' => strtolower($forMonth->format('M')),
                'month' => $this->lang->line(strtolower($curDateTime->format('M')))
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
