<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Calendar extends CI_Controller
{
    function __construct()
    {
        parent::__construct();

        $this->load->helper('url');
//        $this->load->library('plupload');
//	      $this->load->model('filemanager');
    }

	function index()
	{
		
	}
	
	
	function main()
	{
		$this->load->view('layout/content/modules/calendar/main');
	}
	
	function edit()
	{
		$this->load->view('layout/content/modules/calendar/edit');
	}

	function js2PhpTime($jsdate){
	  if(preg_match('@(\d+)/(\d+)/(\d+)\s+(\d+):(\d+)@', $jsdate, $matches)==1){
	    $ret = mktime($matches[4], $matches[5], 0, $matches[1], $matches[2], $matches[3]);
	    //echo $matches[4] ."-". $matches[5] ."-". 0  ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
	  }else if(preg_match('@(\d+)/(\d+)/(\d+)@', $jsdate, $matches)==1){
	    $ret = mktime(0, 0, 0, $matches[1], $matches[2], $matches[3]);
	    //echo 0 ."-". 0 ."-". 0 ."-". $matches[1] ."-". $matches[2] ."-". $matches[3];
	  }
	  return $ret;
	}

	function php2JsTime($phpDate){
	    //echo $phpDate;
	    //return "/Date(" . $phpDate*1000 . ")/";
	    return date("m/d/Y H:i", $phpDate);
	}

	function php2MySqlTime($phpDate){
	    return date("Y-m-d H:i:s", $phpDate);
	}

	function mySql2PhpTime($sqlDate){
	    $arr = date_parse($sqlDate);
	    return mktime($arr["hour"],$arr["minute"],$arr["second"],$arr["month"],$arr["day"],$arr["year"]);

	}

	function addCalendar($st, $et, $sub, $ade){
	  $ret = array();
	  try{
		if ($group_id == "") { $group_id = "0"; }
		$sql = "insert into calendar (Subject, StartTime, EndTime, IsAllDayEvent, user_id, group_id) values ('"
		  .mysql_real_escape_string($sub)."', '"
		  .$this->php2MySqlTime($this->js2PhpTime($st))."', '"
		  .$this->php2MySqlTime($this->js2PhpTime($et))."', '"
		  .mysql_real_escape_string($ade)."', '"
		  .mysql_real_escape_string($_GET['user_id'])."', '"
		  .mysql_real_escape_string($_GET['group_id'])."' )";
		//echo($sql);

		//echo($sql);
		error_log($sql);


		if(mysql_query($sql)==false){
		  $ret['IsSuccess'] = false;
		  $ret['Msg'] = mysql_error();
		}else{
		  $ret['IsSuccess'] = true;
		  $ret['Msg'] = 'add success';
		  $ret['Data'] = mysql_insert_id();
		}
		}catch(Exception $e){
		 $ret['IsSuccess'] = false;
		 $ret['Msg'] = $e->getMessage();
	  }
	  return $ret;
	}


	function addDetailedCalendar($st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
	  $ret = array();
	  try{
		if ($group_id == "") { $group_id = "0"; }
		$sql = "insert into calendar (Subject, StartTime, EndTime, IsAllDayEvent, Description, Location, Color, user_id, group_id) values ('"
		  .mysql_real_escape_string($sub)."', '"
		  .$this->php2MySqlTime($this->js2PhpTime($st))."', '"
		  .$this->php2MySqlTime($this->	js2PhpTime($et))."', '"
		  .mysql_real_escape_string($ade)."', '"
		  .mysql_real_escape_string($dscr)."', '"
		  .mysql_real_escape_string($loc)."', '"
		  .mysql_real_escape_string($color)."', '"
		  .mysql_real_escape_string($_GET['user_id'])."', '"
		  .mysql_real_escape_string($_GET['group_id'])."' )";

			if(mysql_query($sql)==false){
		  $ret['IsSuccess'] = false;
		  $ret['Msg'] = mysql_error();
		}else{
		  $ret['IsSuccess'] = true;
		  $ret['Msg'] = 'add success';
		  $ret['Data'] = mysql_insert_id();
		}
		}catch(Exception $e){
		 $ret['IsSuccess'] = false;
		 $ret['Msg'] = $e->getMessage();
	  }
	  return $ret;
	}

	function listCalendarByRange($sd, $ed){
	  $ret = array();
	  $ret['events'] = array();
	  $ret["issort"] =true;
	  $ret["start"] = $this->php2JsTime($sd);
	  $ret["end"] = $this->php2JsTime($ed);
	  $ret['error'] = null;
	  try{
		if ($_GET["group_id"] == "") 
		{
			$sql = "select * from calendar where StartTime between '"
			  .$this->php2MySqlTime($sd)."' and '". $this->php2MySqlTime($ed)."' and user_id='".$_GET['user_id']."'";
		} else {
			$sql = "select * from calendar where StartTime between '"
			  .$this->php2MySqlTime($sd)."' and '". $this->php2MySqlTime($ed)."' and user_id='".$_GET['user_id']."' and group_id='".$_GET['group_id']."'";
		}
		$handle = mysql_query($sql);

		//echo $sql;

		while ($row = mysql_fetch_object($handle)) {
		  //$ret['events'][] = $row;
		  //$attends = $row->AttendeeNames;
		  //if($row->OtherAttendee){
		  //  $attends .= $row->OtherAttendee;
		  //}
		  //echo $row->StartTime;
		  $ret['events'][] = array(
			$row->Id,
			$row->Subject,
			$this->php2JsTime($this->mySql2PhpTime($row->StartTime)),
			$this->php2JsTime($this->mySql2PhpTime($row->EndTime)),
			$row->IsAllDayEvent,
			0, //more than one day event
			//$row->InstanceType,
			0,//Recurring event,
			$row->Color,
			1,//editable
			$row->Location, 
			''
		  );
		}
		}catch(Exception $e){
		 $ret['error'] = $e->getMessage();
	  }
	  return $ret;
	}

	function listCalendar($day, $type){
	  $phpTime = $this->js2PhpTime($day);
	  //echo $phpTime . "+" . $type;
	  switch($type){
		case "month":
		  $st = mktime(0, 0, 0, date("m", $phpTime), 1, date("Y", $phpTime));
		  $et = mktime(0, 0, -1, date("m", $phpTime)+1, 1, date("Y", $phpTime));
		  break;
		case "week":
		  //suppose first day of a week is monday 
		  $monday  =  date("d", $phpTime) - date('N', $phpTime) + 1;
		  //echo date('N', $phpTime);
		  $st = mktime(0,0,0,date("m", $phpTime), $monday, date("Y", $phpTime));
		  $et = mktime(0,0,-1,date("m", $phpTime), $monday+7, date("Y", $phpTime));
		  break;
		case "day":
		  $st = mktime(0, 0, 0, date("m", $phpTime), date("d", $phpTime), date("Y", $phpTime));
		  $et = mktime(0, 0, -1, date("m", $phpTime), date("d", $phpTime)+1, date("Y", $phpTime));
		  break;
	  }
	  //echo $st . "--" . $et;
	  return $this->listCalendarByRange($st, $et);
	}

	function updateCalendar($id, $st, $et){
	  $ret = array();
	  try{
		$sql = "update calendar set"
		  . " starttime='" . $this->php2MySqlTime($this->js2PhpTime($st)) . "', "
		  . " endtime='" . $this->php2MySqlTime($this->js2PhpTime($et)) . "' "
		  . "where id='".$id."' ";
		//echo $sql;
			if(mysql_query($sql)==false){
		  $ret['IsSuccess'] = false;
		  $ret['Msg'] = mysql_error();
		}else{
		  $ret['IsSuccess'] = true;
		  $ret['Msg'] = 'Succefully';
		}
		}catch(Exception $e){
		 $ret['IsSuccess'] = false;
		 $ret['Msg'] = $e->getMessage();
	  }
	  return $ret;
	}

	function updateDetailedCalendar($id, $st, $et, $sub, $ade, $dscr, $loc, $color, $tz){
	  $ret = array();
	  try{
		$sql = "update calendar set"
		  . " starttime='" . $this->php2MySqlTime($this->js2PhpTime($st)) . "', "
		  . " endtime='" . $this->php2MySqlTime($this->js2PhpTime($et)) . "', "
		  . " subject='" . mysql_real_escape_string($sub) . "', "
		  . " isalldayevent='" . mysql_real_escape_string($ade) . "', "
		  . " description='" . mysql_real_escape_string($dscr) . "', "
		  . " location='" . mysql_real_escape_string($loc) . "', "
		  . " color='" . mysql_real_escape_string($color) . "' "
		  . "where id='".$id."' ";
		//echo $sql;
			if(mysql_query($sql)==false){
		  $ret['IsSuccess'] = false;
		  $ret['Msg'] = mysql_error();
		}else{
		  $ret['IsSuccess'] = true;
		  $ret['Msg'] = 'Succefully';
		}
		}catch(Exception $e){
		 $ret['IsSuccess'] = false;
		 $ret['Msg'] = $e->getMessage();
	  }
	  return $ret;
	}

	function removeCalendar($id){
	  $ret = array();
	  try{
		$sql = "delete from calendar where id='".$id."'";
			if(mysql_query($sql)==false){
		  $ret['IsSuccess'] = false;
		  $ret['Msg'] = mysql_error();
		}else{
		  $ret['IsSuccess'] = true;
		  $ret['Msg'] = 'Succefully';
		}
		}catch(Exception $e){
		 $ret['IsSuccess'] = false;
		 $ret['Msg'] = $e->getMessage();
	  }
	  return $ret;
	}
	

	function datafeed()
	{
		mysql_connect("localhost","root","krakow132!!!") or
		die("Could not connect: " . mysql_error());
		mysql_select_db("igroups") or 
		die("Could not select database: " . mysql_error());
		
		header('Content-type:text/javascript;charset=UTF-8');
		$method = $_GET["method"];
		switch ($method) {
			case "add":
				$ret = $this->addCalendar($_POST["CalendarStartTime"], $_POST["CalendarEndTime"], $_POST["CalendarTitle"], $_POST["IsAllDayEvent"]);
				break;
			case "list":
				$ret = $this->listCalendar($_POST["showdate"], $_POST["viewtype"]);
				break;
			case "update":
				$ret = $this->updateCalendar($_POST["calendarId"], $_POST["CalendarStartTime"], $_POST["CalendarEndTime"]);
				break; 
			case "remove":
				$ret = $this->removeCalendar( $_POST["calendarId"]);
				break;
			case "adddetails":
				$st = $_POST["stpartdate"] . " " . $_POST["stparttime"];
				$et = $_POST["etpartdate"] . " " . $_POST["etparttime"];
				if(isset($_GET["id"])){
					$ret = $this->updateDetailedCalendar($_GET["id"], $st, $et, 
						$_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
						$_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
				}else{
					$ret = $this->addDetailedCalendar($st, $et,                    
						$_POST["Subject"], isset($_POST["IsAllDayEvent"])?1:0, $_POST["Description"], 
						$_POST["Location"], $_POST["colorvalue"], $_POST["timezone"]);
				}        
				break; 


		}
		echo json_encode($ret); 

	
		
	}
}
