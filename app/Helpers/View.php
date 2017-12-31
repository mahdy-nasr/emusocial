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

    public function partPath($partName)
    {
            $base = Config::get('base/url').'/';

            extract($this->_data);
            return dirname(Config::get('base/document')).'/Views/Pages/'.$partName.".php"; 
    }

    public function load($file,$param = [])
    {


    	$base = Config::get('base/url').'/';

        $arr = explode(':',$file);
        //var_dump($arr);die;
       // var_dump($template);
        if (count($arr) > 1) {
            $template = $this->_templatePath.$arr[0].'.php';
             $file = $this->_viewPath.$arr[0]."/".$arr[1].'.php';
            $files = [];
            
            for($i=2;$i<count($arr);$i++) {
                $files['file'.$i] = $this->_viewPath.$arr[1]."-parts/".$arr[$i].'.php';
            }
            extract($files);
            
        } else {
            $template = $this->_viewPath.$arr[0].'.php';
        }

        $this->_data = $param;

        
	    extract($param);
	    ob_start();
	    include($template);
	    return ob_get_clean();
    }
}