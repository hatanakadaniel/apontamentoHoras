<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of itemMenu_model
 *
 * @author dhatanaka
 */
class ItemMenu_model extends CI_Model
{
    
    private $link;
    private $title;
    private $name;
    private $active = false;
    
    function __construct($name='', $link='', $active=false, $title='')
    {
        parent::__construct();
        $this->name = $name;
        $this->link = $link;
        $this->active = $active;
        $this->title = $title;
    }
    
    function newInstance($name='', $link='', $active=false, $title='')
    {
        return new ItemMenu_model($name, $link, $active, $title);
    }


    public function getLink()
    {
        return $this->link;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setLink($link)
    {
        $this->link = $link;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }

    public function setName($name)
    {
        $this->name = $name;
    }
    
    public function getActive()
    {
        return $this->active;
    }

    public function setActive($active)
    {
        $this->active = $active;
    }


}
