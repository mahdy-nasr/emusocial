<?php
namespace App\Helpers;

class View
{
    private $_mode = 'frontend';
    private $_viewPath;
    private $_templatePath;
    public function __construct ()
    {
    	$this->_viewPath = Config::get('base/document').'/../Views/Pages/';
        var_dump($this->_viewPath);
    	$this->_templatePath = Config::get('base/document').'/../Views/templates/';
        var_dump( $this->_templatePath);

    }


    public function load($file,$param = [])
    {
    	$base = Config::get('base/url').'/';

        $template = explode(':',$file);
       // var_dump($template);
        if (count($template) == 2) {
            $file = $this->_viewPath.$template[1].'.php';
            $template = $this->_templatePath.$template[0].'.php';
        } else {
            $template = $this->_viewPath.$template[0].'.php';
        }


	    extract($param);
	    ob_start();
	    include($template);
	    return ob_get_clean();
    }
}