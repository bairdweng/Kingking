<?php
include 'Configuration.php';
$isCon = ConnectTothedatabase();

$byte = $_POST["image"];
$identityCode = $_POST['identityCode'];
   
// $identityCode = $_GET['identityCode'];
//查询数据库中的图片。
$result = mysql_query("SELECT * FROM personInfomation where identityCode = '$identityCode'");
$isImage = 0;
 while ($row = mysql_fetch_array($result)){
        $faceURL = $row['face'];
        if ($faceURL == "") {
        	   $isImage = 0;
        }
        else{
        	   $isImage = 1;
        }
    }

//如果文件存在，那么修改这个图片。
if ($isImage == 1) {
   $Subface = explode('/',$faceURL); 
   $imageName = end($Subface);
   $pathname = "/Applications/XAMPP/xamppfiles/htdocs/Kingking/image/".$imageName;
   $file = fopen($pathname,"w+");
  if(unlink($pathname)){
    
  }
  else{
  	  echo json_encode(array("error"=>"删除失败"));

  }
}
	// echo "没有这张图";
    $byte = str_replace(' ','',$byte);   //处理数据 
    $byte = str_ireplace("<",'',$byte);
    $byte = str_ireplace(">",'',$byte);
    $byte=pack("H*",$byte);      //16进制转换成二进制
	$filename=time().".jpg";//要生成的图片名字
	$file = fopen("/Applications/XAMPP/xamppfiles/htdocs/Kingking/image/".$filename,"w+");
	$fw = fwrite($file,$byte);//写入  

    if ($fw){
	$imageURL = "http://".$_SERVER['SERVER_NAME']."/Kingking/image/".$filename;
    //将URL写入数据库。
     $Updateresult = mysql_query("UPDATE personInfomation SET face = '$imageURL' WHERE identityCode = '$identityCode'");
     if ($Updateresult == 1){
	    echo json_encode(array("result"=>"1","imageURL"=>$imageURL));
        }
      else{
             echo json_encode(array("error"=>"修改失败"));
          }
      }
      else{
	        echo json_encode(array("error"=>"上传失败"));
      }
?>