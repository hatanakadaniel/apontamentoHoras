<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of point
 *
 * @author esilvajrs2it
 */
class Reader extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('point_model', 'point');   
    }

    public function index()
    {
    	$this->addJS(array('reader/index.js'));
        $this->menu->setItemActive('xlsx Reader');
    	$this->loadView('reader/index');
    }

    public function import()
    {
    	$config['upload_path'] = './uploads/';
		$config['allowed_types'] = '*';
        $config['overwrite'] = true;

		$this->load->library('upload', $config);

		if ($this->upload->do_upload()) {
            $xlsx = $this->excelToObject($this->upload->data());
        } else {
            die($this->upload->display_errors());
        }

		$xlsxArray = $this->translate($xlsx);

        $xlsxArray = $this->removeTrash($xlsxArray);      

        $points = $this->createInsertData($xlsxArray);
        foreach ($points as $point) {

            if (!$this->_haveAlready($point)) { 
                $this->point->insert(array('dateTime' => $point));
            } 
        }

        $this->success();
    }

    public function success()
    {
        $this->addJS(array('reader/index.js'));
        $this->loadView('reader/success');
    }

    private function _haveAlready($date)
    {
        if ($this->point->listOne($date)) {
            return true;
        }
        return false;
    }

    private function excelToObject($data)
    {

        $folder = $data['file_name'].".folder";
        if (!is_dir($data['file_path']."/".$folder."/")) {
            mkdir($data['file_path'].$folder);
            chmod($data['file_path'].$folder, 0777);
        }
        $dir = $data['file_path'].$folder;
         
        // Unzip
        $zip = new ZipArchive;
        $file = $data['full_path'];
        chmod($file,0777);
        if ($zip->open($file) === TRUE) {
                $zip->extractTo($dir);
                $zip->close();
        } 

        // Open up shared strings & the first worksheet
        $strings = simplexml_load_file($dir . '/xl/sharedStrings.xml');
        $sheet   = simplexml_load_file($dir . '/xl/worksheets/sheet1.xml');
         
        // Parse the rows
        $xlrows = $sheet->sheetData->row;
         
        foreach ($xlrows as $xlrow) {
            $arr = array();
                    $row = 0;
                    foreach ($xlrows as $xlrow) {

                        // In each row, grab it's value
                        foreach ($xlrow->c as $cell) {
                            $v = (string) $cell->v;

                            // If it has a "t" (type?) of "s" (string?), use the value to look up string value
                            if (isset($cell['t']) && $cell['t'] == 's') {
                                $s  = array();
                                $si = $strings->si[(int) $v];

                                // Register & alias the default namespace or you'll get empty results in the xpath query
                                $si->registerXPathNamespace('n', 'http://schemas.openxmlformats.org/spreadsheetml/2006/main');

                                // Cat together all of the 't' (text?) node values
                                foreach($si->xpath('.//n:t') as $t) {

                                    $s[] = (string) $t;

                                }
                               $v = implode($s);

                            }

                            $arr[$row][] = $v;

                        }

                            $row++;
                      }
        }     
        @unlink($dir);
        @unlink($file);

        return $arr;
    }

    private function createInsertData(array $xlsxArray)
    {
        foreach ($xlsxArray as $row) {

            for ($i = 0; $i <= 4; $i++) 
            {
                if ($i != 0) {
                    if (!empty($row[$i])){
                        $arr[] = $row[0]." ".$row[$i]."<br>";
                    }
                }
            }
        }

        return $arr;
    }

    private function translate($xlsxArray)
    {
        foreach ($xlsxArray as $x => $row) {
            foreach ($row as $j => $cell) {
                if ( !$this->isString($cell) )
                {
                    if($date = $this->isDate($cell))
                    {
                        $xlsxArray[$x][$j] = $date;
                    } else if($time = $this->isTime($cell))
                    {
                        $xlsxArray[$x][$j] = $time;
                    }
                } else {
                    unset($xlsxArray[$x][$j]);
                }
            }
        }
        return $xlsxArray;
    }

    private function isString($cell)
    {
        if ($cell / 2) {
            return false;
        } 
        return true;
    }

    private function isDate($cell)
    {
        $cdate = $this->convertExcelDate($cell);
         if ($cdate != "1970-01-01") {
            return $cdate;
        }  
        return false;
    }

    private function isTime($cell)
    {
         if ($ctime = $this->convertExcelTime($cell)) {
            return $ctime;
        }  
        return false;
    }
    
    private function convertExcelDate($date)
    {
        return date("Y-m-d",mktime(0,0,0,1,$date-1,1900));
    }

    private function convertExcelTime($time)
    {
        $time = $time*24*60;
        $hours = floor($time / 60);
        $minutes = ($time % 60);
        return $hours.":".$minutes.":00";
    }

    private function removeTrash(array $xlsxArray)
    {
        foreach ($xlsxArray as $key => $item) {
            if (empty($item))
            {
                unset($xlsxArray[$key]);   
            }
        }
        return $xlsxArray;
    }

}
