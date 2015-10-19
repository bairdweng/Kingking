<?php
include 'Configuration.php';
$isGET = Getrequestway();
//判断是否是get请求
if ($isGET == 1) {
    $identityCode = $_GET['identityCode'];
	
}
else{
    $identityCode = $_POST['identityCode'];
}
//连接数据库
$con = mysql_connect("localhost","root","000000");
if (!$con){
die('Could not connect: ' . mysql_error());
}
else{
// echo "连接成功<br/>";
}
//连接数据库
mysql_select_db("datas", $con);
//每次连接数据库，都需要设置数据库的子集
mysql_query("set names utf8");
//当然这里limit 1很重要。这要mysql找到一条记录后就不会在往下找了。这里执行所影响的行数不是0就是1，性能提高了不少。
$result = mysql_query("SELECT * FROM personInfomation where identityCode = '$identityCode'  limit 1");

if (mysql_num_rows($result)==0) {
	 echo json_encode(array("error"=>"用户不存在"));
}
else{
	  echo json_encode(mysql_fetch_object($result));
}
?>