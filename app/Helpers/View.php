<?php
namespace App\Helpers;

class View
{
    private $_mode = 'frontend';
    private $_viewPath;
    private $_templatePath;
    private $_data;
    public function __construct ()
    {
    	$this->_viewPath = dirname(Config::get('base/document')).'/Views/Pages/';
    	$this->_templatePath = dirname(Config::get('base/document')).'/Views/Templates/';

    }

    public function addPart($partName)
    {
            $base = Config::get('base/url').'/';

            extract($this->_data);
            include dirname(Config::get('base/document')).'/Views/Pages/'.$partName.".php"; 
    }

    public function load($file,$param = [])
    {


    	$base = Config::get('base/url').'/';

        $template = explode(':',$file);
       // var_dump($template);
        if (count($template) == 2) {
            $file = $this->_viewPath.$template[0]."/".$template[1].'.php';
            $template = $this->_templatePath.$template[0].'.php';
        } else {
            $template = $this->_viewPath.$template[0].'.php';
        }
        $this->_data = $param;


	    extract($param);
	    ob_start();
	    include($template);
	    return ob_get_clean();
    }
}