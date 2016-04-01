<?php
	require_once ("config.php");
	require_once ("config2.php");
	require_once("getvars.php");
	require_once ("function.php");
class clasEcardWrapper{
	function make_db_connect(){
		global $dbserver,$database_name,$db_user,$db_password;	
		$connect = mysql_connect ($dbserver,$db_user,$db_password) or die("MySQL problem. Connect failed to server: $dbserver");
		mysql_select_db($database_name, $connect) or die("MySQL problem. Failed to select $database_name");
		return $connect;
	}
	function set_array_from_query($table_name,$column,$condition="") {
		if($condition !=""){
			$sql="SELECT $column FROM $table_name WHERE $condition";
		}
		else{
			$sql="SELECT $column FROM $table_name";
		}

		$array = array();
		$result = mysql_query($sql,clasEcardWrapper::make_db_connect());
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}

		if (mysql_num_rows($result) > 0){
			$x=0;
			while($row = mysql_fetch_row($result)){
				foreach($row as $i => $value) {
					$column = mysql_field_name($result,$i);
					$data["$column"] = $value;
					$array[$x] = $data;
				}
				$x++;
           }
		}
		return $array;
	}

	//---------------------------------------------------------------------------------------
	function set_array_from_query2($table_name,$column,$condition="") {
		if($condition !=""){
			$sql="SELECT $column FROM $table_name WHERE $condition";
		}
		else{
			$sql="SELECT $column FROM $table_name";
		}

		$array = array();
		$result = mysql_query($sql,$this->make_db_connect());
		if (!$result) {
			echo 'Could not run query: ' . mysql_error();
			exit;
		}

		if (mysql_num_rows($result) > 0){
			$x=0;
			while($row = mysql_fetch_row($result)){
				foreach($row as $i => $value) {
					$column = mysql_field_name($result,$i);
					$data["$column"] = $value;
					$array[$column] = $data;
				}
				$x++;
           }
		}
		return $array;
	}
}
/**
Object Call
*/
$cs_id=$_GET[cs_id];
if($cs_id!=""){
	$rs=clasEcardWrapper::set_array_from_query("max_ecardsent,max_ecard","*","max_ecardsent.cs_id='$cs_id' and max_ecardsent.cs_ec_id=max_ecard.ec_id");
}else{
	$rs=clasEcardWrapper::set_array_from_query("max_ecardsent,max_ecard","*","max_ecardsent.cs_ec_id=max_ecard.ec_id");
}
//print_r($rs);
$i=0;
$st="";
foreach($rs as $row){
	foreach($row as $key=>$value){
		//$st.= "&$key$i=$value";
	}
	//$st.="&fromwho$i=$row[cs_from_name]&towho$i=$row[cs_fname]&message$i=$row[cs_message]";
	$name=split(" ",$row[cs_from_name]);
	if($towhom!=""){
		$st="&fromwho=$name[0]&towho=$towhom&message=$row[cs_message]";
	}else{
		$st="&fromwho=$name[0]&towho=$row[cs_fname]&message=$row[cs_message]";
	}
	$i++;
}
//echo urlencode($st);
echo $st;
?>