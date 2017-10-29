<?php

function getchaptersbyid($ch_id){
$response = array("error" => FALSE);
if($ch_id != ""){
return "error";
}
else{
include 'dbconnect.php';
$sql = "SELECT * FROM chapters where id = $ch_id";
if ($result = mysqli_query($conn, $sql)) {
	$data = mysqli_fetch_assoc($result)
	return $data['chap'];

} 
else {
    return "error";
}}


}

if(getchaptersbyid("1")){
	echo "hello";
}
?>