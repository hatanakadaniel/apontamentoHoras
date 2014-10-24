<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of point_model
 *
 * @author dhatanaka
 */
class Point_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    public function insert($point)
    {
        $this->db->insert('point', $point);
    }
    
    public function listAll()
    {
        $sql = 'select * from point;';
        $stmt = $this->db->query($sql);
        return $stmt->result();
    }
    
    public function listAllbyDay($dateDay)
    {
        $sql = 'select
                    *
                        from
                            point
                                where
                                    dayofyear(dateTime) = dayofyear(?)
                                        order by
                                            dateTime;';
        $stmt = $this->db->query($sql, array($dateDay));
        return $stmt->result();
    }
    
    public function listAllbyMonth($dateMonth)
    {
        $sql = 'select
                    date_format(dateTime, "%Y/%m/%d") as dayOfMonth,
                    group_concat(dateTime order by dateTime) as dayPoints
                        from
                            point
                                where
                                    month(dateTime) = month(?)
                                        group by
                                            dayofyear(dateTime);';
        $stmt = $this->db->query($sql, array($dateMonth));
        return $stmt->result();
    }

    public function listOne($date)
    {
        $sql = 'select * from point where dateTime = ?;';
        $stmt = $this->db->query($sql, array($date));
        return $stmt->result();
    }
    
    
    public function listAllbyYear()
    {
        
    }
}
