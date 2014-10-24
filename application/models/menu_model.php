<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of menu_model
 *
 * @author dhatanaka
 */
class Menu_model extends CI_Model
{
    
    private $itensMenu = array();
        
    function __construct()
    {
        parent::__construct();
        $CI =& get_instance();
        $CI->load->model('itemmenu_model', 'itemMenu');
        array_push($this->itensMenu, $CI->itemMenu->newInstance('Home', base_url(), true));
        array_push($this->itensMenu, $CI->itemMenu->newInstance('Mês', base_url('site/month'), false));
        array_push($this->itensMenu, $CI->itemMenu->newInstance('xlsx Reader', base_url('reader/'), false));
    }
    
    public function getItensMenu()
    {
        return $this->itensMenu;
    }

    public function setItensMenu($itensMenu)
    {
        $this->itensMenu = $itensMenu;
    }
    
    public function setItemActive($itemMenuName)
    {
        foreach ($this->itensMenu as &$itemMenu) {
            $itemMenu->setActive(false);
            if (strcmp($itemMenu->getName(), $itemMenuName) == 0) {
                $itemMenu->setActive(true);
            }
        }
    }

}
