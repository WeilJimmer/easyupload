<?php  
@ini_set('date.timezone','Asia/Taipei');
@header('Content-type: text/html; charset=UTF-8');

$myip=$_SERVER["REMOTE_ADDR"];
session_id(md5($myip));
@session_start();

$myip = $_SERVER["REMOTE_ADDR"];

?>
<html>
<head>
<meta content="text/html;charset=UTF-8" http-equiv="Content-Type">
<meta name="viewport" content="width=device-width,initial-scale=0.75,maximum-scale=1.0, user-scalable=no"/>
<title>單檔上傳</title>
<style type="text/css">
.style1 {
	color: #FF0000;
}
</style>
<script>
var file_namex = "";
var file_sizex = 0;
var http = new XMLHttpRequest("Microsoft.XMLHTTP");

function check_pw(uw,pw){
	http.onreadystatechange=function(){
		if (http.readyState==4 && http.status==200){
			if (http.responseText=='1'){
				show_result.innerHTML = "<font color='lime'><b>帳號密碼正確。</b></font>";
				return true;
			}else{
				show_result.innerHTML = "<font color='red'><b>帳號密碼錯誤！</b></font>";
				return false;
			}			
		}else if(http.readyState==4){
			show_result.innerHTML = "<font color='red'><b>連接失敗-" + http.status + "</b></font>";
			return false;
		}
	}
	http.open("GET","upload.php?check_pw=1&uwd=" + uw + "&pwd=" + pw + '&rnd=' + Math.random(),true);
	http.send();
}

function check(){
	if (file.value==""){
		alert('空檔案！');
		return false;
	}
	var k = file_namex.lastIndexOf(".");
	var kk = file_namex.substring(k,k.length);
	if (k<0 || kk===""){
		alert('檔案名稱有誤！');
		return false;
	}
	if (show_result.innerText.toString()!=="帳號密碼正確。"){
		alert('帳號密碼錯誤！');
		return false;
	}else{
		return true;
	}
}

function fileSelected() {
	var file = document.getElementById('file').files[0];
	if (file) {
		var fileSize = 0;
		file_sizex = file.size;
		if (file.size > 1024 * 1024){
			fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
		}else{
			fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
		}
		file_namex = file.name;
		document.getElementById('showX').innerHTML = '檔案名稱：' + file.name + '<br>檔案大小：' + fileSize + '<br>檔案類型：' + file.type;
	}
}

function uploadFile() {
	a = check();
	if (!a){
		return false;
	}
	var fd = new FormData();
	fd.append("userword",uw.value);
	fd.append("password",pw.value);
	fd.append("file", document.getElementById('file').files[0]);
	var xhr = new XMLHttpRequest();
	xhr.upload.addEventListener("progress", uploadProgress, false);
	xhr.addEventListener("load", uploadComplete, false);
	xhr.addEventListener("error", uploadFailed, false);
	xhr.addEventListener("abort", uploadCanceled, false);
	xhr.open("POST", "upload.php");
	xhr.send(fd);
}

function uploadProgress(evt) {
	if (evt.lengthComputable) {
		var percentComplete = Math.round(evt.loaded * 100 / evt.total);
		document.getElementById('progressNumberX').max = evt.total;
		document.getElementById('progressNumberX').value = evt.loaded;
		document.getElementById('progressNumber').innerHTML = percentComplete.toString() + '%';
	}else {
		document.getElementById('progressNumber').innerHTML = '失敗！';
	}
}

function uploadComplete(evt) {
	document.getElementById('showX').innerHTML=(evt.target.responseText);
}

function uploadFailed(evt) {
	alert("上傳失敗！");
}

function uploadCanceled(evt) {
	alert("已經取消上傳！");
}
</script>
</head>
<body style="color: #FFFFFF; background-color: #000000; ">
<div id="content">
<center>
<div>
<h2>單檔上傳</h2>
</div>
<form id="form1" action="upload.php" method="post" target="Ix" enctype="multipart/form-data" onsubmit="return check();">
 <table style="text-align: left; width: 500px; height: 85px;" border="1" cellpadding="2" cellspacing="2">
  <tbody>
      <tr>
        <td width="90px"><span class="style1">*</span>檔案名稱：</td>
        <td><input type="file" id="file" name="file" onchange="fileSelected();"></td>
      </tr>
	  <tr>
        <td><span class="style1">*</span>上傳帳號：</td>
        <td><input name="u" id="uw" maxlength="30" type="text" style="width: 230px"></td>
      </tr>
	  <tr>
        <td><span class="style1">*</span>上傳密碼：</td>
        <td><input name="p" id="pw" maxlength="30" type="password" onkeyup="check_pw(uw.value,this.value);" style="width: 230px"><span id="show_result"></span></td>
      </tr>
      <tr>
        <td></td>
        <td><input value="上傳檔案" onclick="uploadFile();return false;" type="button">&nbsp; &nbsp; &nbsp; &nbsp;<input name="Reset" value="清除重寫" type="reset"></td>
      </tr>
	  <tr>
		<td></td>
		<td><progress id="progressNumberX" max="100" value="0" style="width:100%"></progress><br><div id="progressNumber" style="width:100%;"></div><br><div style="width:100%;height:80px;"><span id="showX" style="color:#FF0000"></span></div></td>
	  </tr>
   </tbody>
  </table>
</form>
</center>
</div>
</body>
</html><?exit;?>