<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Uploader extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
        $this->load->library('plupload');
        $this->load->model('filemanager');
    }

    function upload()
    {
		if (!isset($_GET['user_id']))
		{
			log_message('debug', "plupload : no user_id specified");
		} else if (!isset($_GET['group_id']))
		{
			log_message('debug', "plupload : no group_id specified");
		} else {
			log_message('debug', "plupload upload _FILES: ".serialize($_FILES));
			log_message('debug', "plupload upload _POST: ".serialize($_POST));
			echo $this->plupload->process_upload($_REQUEST,$_FILES, array('user_id' => $_GET['user_id'], 'group_id' => $_GET['group_id']));
		}
    }

	function delete()
	{
		$doDelete = 0;
		$id = $_GET['id'];
		$v = $_GET['v'];
		
		if (!$id || !$v)
		{
			echo json_encode('0');
			exit;
		}
		
		$file = $this->filemanager->get_file($id);
		if ($file)
		{
			$verify_str = "user_id=".$file->user_id."&group_id=".$file->group_id."&encID=".$file->encID."&encFileName=".$file->encFileName;
			$verify = sha1($verify_str);
			
			if ($v == $verify)
				$doDelete = 1;
			else 
				$doDelete = 0;
				
		} else {
			echo json_encode('0');
			exit;
			
		}

		if ($doDelete)
		{
			$this->filemanager->del_file($id);
			$filepath = getcwd()."/filestorage/".$file->encFileName;
			unlink($filepath);
			echo json_encode('1');
			exit;
			
		}
		
		echo json_encode('0');
		exit;
		
	}

	function download($encID)
	{
		$fileDetails = $this->filemanager->get_file($encID);
		$download_file = getcwd()."/filestorage/".$fileDetails->encFileName;
		$download_file_name = $fileDetails->name;
		$handle = fopen($download_file, "r");
		$ctype = $fileDetails->type;
		
		header("Pragma: public");
		header("Expires: 0");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Cache-Control: private",false);
		header("Content-Type: $ctype");
		header("Content-Disposition: attachment; filename=\"".basename($download_file_name)."\";");
		header("Content-Transfer-Encoding: binary");
		header("Content-Length: ".@filesize($download_file));
		set_time_limit(0);
		@readfile("$download_file") or die("File not found.");

	}
}