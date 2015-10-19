<?php
include 'Configuration.php';
$isCon = ConnectTothedatabase();
$identityCode = $_POST['identityCode'];
$allKey = array_keys($_POST);


if (count($allKey)==2){
	for ($i=0; $i < count($allKey); $i++){
 	$keyValue = $allKey[$i];
 	if ($keyValue != "identityCode"){
 		$value = $_POST[$keyValue];
 	    $Updateresult = mysql_query("UPDATE personInfomation SET $keyValue = '$value' WHERE identityCode = '$identityCode' ");
 	    if ($Updateresult) {
 	       echo json_encode(array("result"=>"1"));
 	    }
 	    else{
 	        echo json_encode(array("error"=>"修改失败"));
 	    }
 	}
  }
}
else {
	 echo json_encode(array("error"=>"参数错误"));
}
?>