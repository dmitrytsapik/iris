<?php
require('/usr/share/php/smarty3/Smarty.class.php');
// Конструктор для Smarty
class Smarty_Modules extends Smarty {
public function __construct() {
    parent::__construct();
}
   function Smarty_Modules()
   {

        $this->Smarty();
        $this->template_dir = 'templates/';
        $this->compile_dir  = 'templates_c/';
        //$this->config_dir   = 'configs/';
        $this->caching = false;
        $this->cache_dir    = 'cache/';
	      //$this->cache_lifetime = 1;
        $smarty->force_compile = true;
    	$smarty->debugging = false;
   }
}
?>