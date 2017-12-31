<?php
namespace App\Models;

require dirname(\App\Helpers\Config::get("base/document"))."/libraries/spreadsheet/vendor/autoload.php";//excel_reader.php

class Grade extends \App\Base
{
    private $errors = [];
    private $page_id;
    public function __construct($page_id)
    {
        parent::__construct();
        $this->page_id = $page_id;
    }


	public function getErrorsHtml() 
	{
		$err = "";$sp="<br>";
		foreach ($this->errors as $error) {
			$err.=$error.$sp;
		}

		return $err;
	}
	private function getHeader($xls_data)
	{
		$header = ['grades'=>[]];
		$hrow = 0;
		foreach ($xls_data as $row => $cols) {
			$hrow = $row;
			foreach ($cols as $index => $value) {
				if($value === null)
					continue;

				if ($value == 'std.id') {
					$header['std'] = $index;
				} else if(strpos($value, 'grade:')!== false) {
					$arr = explode(':',$value);
					if (count($arr)<3) {
						$this->errors[]="The header of the grade is not correct";
						return false;
					}

					if (!is_numeric($arr[2])) {
						$this->errors[]="The percent of grade is not is not numeric!";
						return false;
					}

					$header['grades'][] = [];
					$i = count($header['grades'])-1;
					$header['grades'][$i]['name']=$arr[1];
					$header['grades'][$i]['index']=$index;
					$header['grades'][$i]['percent']=$arr[2];
				}
				# code...
			}
			if (count($header['grades']))
				break;
		}

		if(!isset($header['std'])) {
			$this->errors[] = "The std.id header is missing !";
			return 0;
		}
		if (!count($header['grades'])) {
			$this->errors[] = "the header grades is missing !";
			return 0;
		}

		return [$header,$hrow];
	}

	private function getCleanData($header,$xls_data)
	{
		$start_row = $header[1]+1;
		$header = $header[0];
		$students=[];
		for($r=$start_row;$r<count($xls_data);$r++) {
			$row = $xls_data[$r];
			if ($row[$header['std']] === null || empty($row[$header['std']]))
				break;
			$tmp = ['id'=> $row[$header['std']] , 'grades'=>[]];
			foreach ($header['grades'] as $grade) {
				$tmp['grades'][] = [];
				$i = count($tmp['grades'])-1;
				$tmp['grades'][$i]['title'] = $grade['name'];
				$tmp['grades'][$i]['reference'] = $grade['percent'];
				if (empty($row[$grade['index']])) {
					$this->errors[] = "grade is missing for std.id: ".$row[$header['std']];
					return false;
				}
				$tmp['grades'][$i]['grade'] = $row[$grade['index']];
			}
			$students[]=$tmp;

		}
		return $students;
	}

	private function deleteOldGrades() 
	{
		$this->db->write("DELETE from upload where info = 'grades:{$this->page_id}' ");
		return $this->db->write("DELETE from grade where page_id = {$this->page_id}");
	}

	private function insertGrades($students,$file_id)
	{
		$this->db->write("UPDATE upload SET info = 'grades:{$this->page_id}' where id = {$file_id}");
		$query = "INSERT into grade (`student_number`,`page_id`, `grade_title`,`grade`,`grade_reference`) VALUES ";
		$vals="";
		foreach ($students as $std) {
			
			foreach ($std['grades'] as $grade_arr) {
				$val = ", ( {$std['id']} , {$this->page_id} , '{$grade_arr['title']}' , {$grade_arr['grade']} , {$grade_arr['reference']} )";
				$vals.= $val;
				# code...
			}
		}
		$vals = trim($vals,",");

		$query.=$vals;

		return $this->db->write($query);
	}

    public function processGrades($data)
    {

    	//create directly an object instance of the IOFactory class, and load the xlsx file
    	$res = $this->db->readOne("SELECT * from upload where id = ?",[$data['file_id']]);
    	if (!$res) {
    		$this->errors[]='The file is not Exist!!';
    		return false;
    	}

		$fxls = $this->Config::get('base/document').'/'.$res['link'];

		$spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($fxls);


		//read excel data and store it into an array
		$xls_data = $spreadsheet->getActiveSheet()->toArray(null,true, true, false);

		if (($header = $this->getHeader($xls_data)) === false){
			var_dump($header);die;
			return false;
		} 

		$students = $this->getCleanData($header, $xls_data);
		if(!count($students)) {
			$this->errors[] = "Error in parsing spreadsheet";
			return false;
		}
		if(count($this->errors)){
			return false;
		}

		unset($xls_data);
		$this->deleteOldGrades();
		return $this->insertGrades($students,$data['file_id']);

    }

    public function removeGrades()
    {
    	$this->deleteOldGrades();
    }

    public function getUploadFileName()
    {
    	$res = $this->db->readOne("SELECT link from upload where info = 'grades:{$this->page_id}' ");
    	if (!$res)
    		return "No grades uploaded!";
    	return substr($res['link'],strpos($res['link'],'_')+1);
    }

    public function getStudentGrades($id)
    {
    	$grades  = $this->db->read("SELECT grade.* from grade where page_id = {$this->page_id} and student_number = ?",[$id]);
    	if(!$grades)
    		return ['grades'=>[],'total'=>[]];
    	$w=0;
    	$t = (float)0;
    	foreach ($grades as $grade) {
    		$w+= $grade['grade_reference'];
    		$t+= (((float)$grade['grade_reference'])/100)*$grade['grade'];
    	}

    	$t= 100*$t/(float)$w;
    	return ['grades'=>$grades,'total'=>['grade_reference'=>$w,'grade'=>$t]];
    }

    public function getAllStudentGrades()
    {
    	$res = $this->db->read("SELECT grade.*, CONCAT(user.first_name,' ',user.last_name) as username, user.id as user_id from grade inner join user on user.identification = grade.student_number where grade.page_id = {$this->page_id} order by student_number,grade_title");
    	if (!$res)
    		return [];
    	$students = [];
    	$students[] = ['no'=>1,'username'=>$res[0]['username'],'user_id'=>$res[0]['user_id'],'std.id'=>$res[0]['student_number'],'grades'=>[$res[0]['grade']]];

    	for($i=1;$i<count($res);$i++) {
    		if ($res[$i]['student_number'] == $res[$i-1]['student_number']) {
    			$students[count($students)-1]['grades'][] = $res[$i]['grade'];
    		} else {
    			$students[]= ['no'=>$i+1,'username'=>$res[$i]['username'],'user_id'=>$res[$i]['user_id'],'std.id'=>$res[$i]['student_number'],'grades'=>[$res[$i]['grade']]];
    		}
    	}
    	$headers = [ ['title'=>$res[0]['grade_title'], 'ref'=>$res[0]['grade_reference']] ];
    	for($i=1;$i<count($res);$i++) {
    		if ($res[$i]['student_number'] != $res[$i-1]['student_number']) {
    			break;
    		}
    		$headers[] = ['title'=>$res[$i]['grade_title'], 'ref'=>$res[$i]['grade_reference']];
    	}

    	return ['headers'=>$headers, 'students'=>$students];

    }

}

/*
<?php
namespace App\Models;

//require dirname(\App\Helpers\Config::get("base/document"))."/libraries/spreadsheet/vendor/autoload.php";//excel_reader.php
 require dirname(\App\Helpers\Config::get("base/document"))."/libraries/excel_reader/excel_reader.php";//

class Grade extends \App\Base
{
    private $errors = [];
    private $page_id;
    public function __construct($page_id)
    {
        parent::__construct();
        $this->page_id = $page_id;
    }


	public function getErrorsHtml() 
	{

	}

	private function deleteOldGrades() 
	{
		return $this->db->write("DELETE from grade where grade.page_user_id IN (select id from page_user where page_id = {$this->page_id})");
	}

    public function processGrades($data)
    {

    	//create directly an object instance of the IOFactory class, and load the xlsx file
    	$res = $this->db->readOne("SELECT * from upload where id = ?",[$data['file_id']]);
    	if (!$res) {
    		$this->errors[]='The file is not Exist!!';
    		return false;
    	}

		$fxls = $this->Config::get('base/document').'/'.$res['link'];
		$excel = new \PhpExcelReader; // creates object instance of the class
		$excel->read($fxls); // reads and stores the excel file data

		// Test to see the excel data stored in $sheets property
		echo '<pre>';
		var_export($excel->sheets);die;


    }

    public function getStudentGrades($id)
    {

    }

}
 */