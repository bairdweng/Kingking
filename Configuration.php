<?php
//返回1说明是GET请求,0为post
 function Getrequestway(){
	return 0;
}

 function ConnectTothedatabase(){
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
	return $con;
}
?>
