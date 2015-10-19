<?php
// 如果我们使用 require 语句完成相同的案例，echo 语句不会继续执行，因为在 require 语句返回严重错误之后脚本就会终止执行：
include 'Configuration.php';
$isGET = Getrequestway();
if ($isGET == 1) {
  $userName = $_GET['userName'];
  $passWord = $_GET['passWord'];
}
else{
   $userName = $_POST['userName'];
   $passWord = $_POST['passWord'];
}
//判断用户名是否为空
if (empty($userName))
{
  echo json_encode(array("error"=>"请填写用户名"));
}
else if (empty($passWord))
{
  echo json_encode(array("error"=>"请填写密码"));
}
else
{
  //连接数据库
   $con = mysql_connect("localhost","root","000000");
   if (!$con)
   {
    die('Could not connect: ' . mysql_error());
   }
   else
   {
     // echo "连接成功<br/>";
   }
   //连接数据库
   mysql_select_db("datas", $con);
   //每次连接数据库，都需要设置数据库的子集
   mysql_query("set names utf8");
   $result = mysql_query("SELECT * FROM personInfomation where userName = $userName");
   $isexist = 0;
   while ($row = mysql_fetch_array($result)){
         $isexist = 1;
         if ($passWord == $row['passWord']){ 
              $paring = array('result' =>"1",'identityCode'=>$row['identityCode']);
              echo json_encode($paring);
         }
         else{
            echo json_encode(array("error"=>"密码错误"));
         }
   }
   //如果用户不存在
   if ($isexist == 0){ 
          echo json_encode(array("error"=>"用户不存在"));
   } 
}

   
?>
