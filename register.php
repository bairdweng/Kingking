<?php
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
	echo json_encode(array("error"=>"请填写名称"));
}
else if (empty($passWord))
{
	echo json_encode(array("error"=>"请填写密码"));
}
else
{
 //连接服务器
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

  //创建数据表
   //每次连接数据库，都需要设置数据库的子集
   mysql_query("set names utf8");
//设置id为主键并且自增
 $sql = "CREATE TABLE personInfomation 
(
id INT UNSIGNED NOT NULL PRIMARY KEY AUTO_INCREMENT,
name varchar(2000),
gender varchar(2000),
face varchar(2000),
adress varchar(2000),
userName varchar(2000),
passWord varchar(2000),
identityCode varchar(2000)
)"; 
 mysql_query($sql,$con);

 //判断数据库是否存在这个用户，如果不存在，那么添加用户，如果存在，返回错误信息。
   $result = mysql_query("SELECT * FROM personInfomation where userName = $userName");
   $isexist = 0;
   while ($row = mysql_fetch_array($result)) {
         $isexist = 1;
   }
   if ($isexist == 0){           
      //生成GUID唯一编码
      $userGuid = guid();
      //记住char类型要加引号
      mysql_query("INSERT INTO personInfomation (userName, passWord, identityCode)VALUES('$userName','$passWord','$userGuid')");
       echo json_encode(array("result"=>"1"));
   }
   else{
  	   echo json_encode(array("error"=>"用户已注册"));
   }
}  
 //返回数据库的错误码
echo mysql_error();

//生成GUID的函数。
function guid()
{
    if (function_exists('com_create_guid')){
        return com_create_guid();
    }else{
        mt_srand((double)microtime()*10000);//optional for php 4.2.0 and up.
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $hyphen = chr(45);// "-"
        $uuid = chr(123)// "{"
                .substr($charid, 0, 8).$hyphen
                .substr($charid, 8, 4).$hyphen
                .substr($charid,12, 4).$hyphen
                .substr($charid,16, 4).$hyphen
                .substr($charid,20,12)
                .chr(125);// "}"

       $lengforGuid = strlen($uuid);
       $userGuid = substr($uuid,1,$lengforGuid-2);

        return $userGuid;
    }
}
?>

