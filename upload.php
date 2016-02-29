<?php
/*重要設定*/
@ini_set('date.timezone','Asia/Taipei');  
@header('Content-type: text/html; charset=UTF-8');
/*End*/
require_once('config.php');
$myip=$_SERVER["REMOTE_ADDR"];
session_id(md5($myip));
@session_start();

$read_=@file('./pwdx/user.txt');
if ($read_==""){
	exit("<span style='background-color:#FF0000;'>ERROR</span>");
}

for($i=0;$i<count($read_);$i++){
	$kk=explode("|",$read_[$i]);
	$uw[]=trim($kk[0],chr(10));
	$pw[]=trim($kk[1],chr(10));
}

if($_GET['check_pw']=='1'){
	$x = array_search($_GET['uwd'],$uw);
	if($x>=0 and md5(md5(md5($_GET['pwd'])))==$pw[$x]){
		echo '1';
	}else{
		echo '0';
	}
	exit;
}

$x = array_search($_POST['userword'],$uw);
if($x>=0 and md5(md5(md5($_POST['password'])))==$pw[$x]){
}else{
	exit("帳號密碼錯誤！");
}

$fn=$_FILES["file"]["name"];
$fz=ceil($_FILES["file"]["size"] / 1024);
$myip = $_SERVER["REMOTE_ADDR"];
$time=date('Y-m-d l H:i:s');
$ktime=date('YmdHis');
$kmtime=date('Ymd');

$filename = $fn;		//檔案檔名
$ext_name = strrchr($filename, ".");		//取得副檔名 .jpg，請注意有包含點〝 . 〞
$ext_name = str_replace(".", "", $ext_name);	//去除附檔名前的點

if ($_FILES["file"]["size"]==0){
exit("<center><font color='red'><b>錯誤！空檔案！</b></font></center>");
}

if ($_FILES["file"]["error"] > 0){
exit("<center><font color='red'><b>錯誤！代碼：".$_FILES["file"]["error"]."。【${fn}】上傳失敗！</b></font></center>");
}

if (!file_exists('./upload/'.$uw[$x])){
	mkdir('./upload/'.$uw[$x]);
}

move_uploaded_file($_FILES["file"]["tmp_name"],"./upload/".$uw[$x]."/".$fn);

exit("<center><font color='lime'><b>上傳完成！<br>$root_path/upload/".$uw[$x]."/${fn}<br>【${fn}】大小：${fz} KByte</b></font></center>");
?>