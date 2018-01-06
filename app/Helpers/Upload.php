<?php
namespace App\Helpers;

class Upload
{
    private $table_name  = "upload";
    private $quality = 80;
    private $max_file_size = 101;// 101 MByte.
    private $db = null;
    private $type = null; 
    private $files = null;
    private $path = null;
    private $link = null;
    private $result = [];
    private $errors = [];

    const IMAGE_TYPE = 'image';
    const JPG_FAMILY = 'jpg_family';
    const VIDEO_TYPE = 'video';
    const FILE_TYPE  = 'file';

    public function __construct($type)
    {
        $this->db = DB::getInstance();
        $this->files = $this->reArrayFiles();
        $this->path = dirname(Config::get('base/document')).'/public/uploads/';
        $this->link = 'uploads/';
        $this->type = $type;
        $this->result = [];
        $this->errors = [];
    }
    public function getErrors()
    {
        return $this->errors;
    }
    public function getResult()
    {
        return $this->result;
    }

    private function reArrayFiles() {
        $arr = [];
        foreach ($_FILES as $key => $value) {
            $arr[$key] = [];
            foreach ($value as $attribute => $filesvalues) {
                if (is_array($filesvalues)) {

                    foreach ($filesvalues as $index => $val) {
                        if (!isset($arr[$key][$index]))
                            $arr[$key][$index] = [];

                        $arr[$key][$index][$attribute]= $val;
                    }
                } else {
                    if (!isset($arr[$key][0])) {
                        $arr[$key][0] = [];
                    }
                    $arr[$key][0][$attribute] = $filesvalues;
                }
            }
            # code...
        }
        return $arr;
    }

    private function compress($source, $quality = null) 
    {
        if ($quality == null)
            $quality = $this->quality;
        $info = getimagesize($source);

        if ($info === false)
            return false;

        if ($info['mime'] == 'image/jpeg' || $info['mime'] == 'image/pjpeg' || $info['mime'] == 'image/jpg') 
            $image = imagecreatefromjpeg($source);

        elseif ($info['mime'] == 'image/gif') 
            $image = imagecreatefromgif($source);

        elseif ($info['mime'] == 'image/png') 
            $image = imagecreatefrompng($source);
        unlink($source);
        imagejpeg($image, $source, $quality);

        return true;
    }
    private function checkSize($size) 
    {
        if ($size < $this->max_file_size)
            return true;
        $this->errors[] = "The file is to large!";
        return  false;
    }

    private function checkTypes($type,$allowd=null)
    {
        if (!$allowd) {
            $allowd = $this->type;
        }

        if ($allowd == 'file')
            return true;

        $types = [
        'image' => ['jpeg','jpg','gif','png','pjpeg'],
        'jpg_family' => ['jpeg','jpg','pjpeg'],
        'video' => ['mp4','flv','mpeg','webm','3gpp','x-flv','wmv']
        ];
        return in_array($type,$types[$allowd]);
    }

    public function imageFixOrientation($path)
    {
        $image = imagecreatefromjpeg($path);
        $exif = exif_read_data($path);
    
        if (empty($exif['Orientation']))
        {
            return false;
        }
    
        switch ($exif['Orientation'])
        {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;
            case 6:
                $image = imagerotate($image, - 90, 0);
                break;
            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }
        unlink($path);
        imagejpeg($image, $path);
    
        return true;
    }
    private function addRecord($file)
    {
        if (!is_string($file))
            return false;
        if ($this->db->write("INSERT into {$this->table_name} (`link`,`type`) VALUES ('$file','{$this->type}')"))
            return $this->db->last_id();
        $this->errors[] = "error add file in Database!";
        return false;

    }
    public function getExtention($file_name)
    {
        return $ext=strtolower(pathinfo($file_name, PATHINFO_EXTENSION));   
    }
    private function convertToMB($size)
    {
        return ceil($size/1000000.0);
    }

    private function uploadFile($file) 
    {
        $old_name   = $file['name'];
        $temp_name  = $file['tmp_name'];
        $ext        = $this->getExtention($old_name);
        $size       = $this->convertToMB($file['size']);

        if ($size>1)
            $this->quality = 50;
        
        $new_name = str_replace(' ','_',time().'_'.$old_name);
        $new_path     = $this->path.$new_name;
        $new_link     = $this->link.$new_name;

        if (!$this->checkSize($size)) {
            return false;
        }

        if(!$this->checkTypes($ext)) {
            $this->errors[] = 'File type Not allowd!';
            return false;
        }


        //move file to correct path;
        if (!move_uploaded_file($temp_name, $new_path)) {
            echo json_encode($file);die;
            $this->errors[] = "error process your file!";
            return false;
        }

        if($id = $this->addRecord($new_link)) {
            $this->result[] = ['id'=>$id,'name'=>$old_name,'link'=>$new_link];
        } else {
            return false;
        }

        if ($this->checkTypes($ext,self::IMAGE_TYPE)) {

            $this->compress($new_path);
        }

        if ($this->checkTypes($ext,self::JPG_FAMILY)) {
            $this->imageFixOrientation($new_path);
        }
        return true;
    }

    public function  uploadAll($inputs)
    {
        if (!is_array($inputs) || !count($inputs)) {
            return false;
        }
        $res = true;
        foreach ($this->files as $input_name => $input_files) {
             
            if (!in_array($input_name, $inputs)) {
                continue;
            }
            foreach ($input_files as $file) {
                
                $res &= $this->uploadFile($file);
                    
            }
        }
        return $res;
                    
    }
}