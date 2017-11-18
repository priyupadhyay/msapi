/***********************************************************/
/********************** View Questions *********************/
/***********************************************************/

function viewquestion(){

	include 'dbconnect.php';


	$response = array("error" => FALSE);
	$sql = "SELECT * FROM questions WHERE `status`= 1 ";
	$result = mysqli_query($conn, $sql);
	$i=0;

	while($data = mysqli_fetch_assoc($result)){
		$response["error"] = FALSE;
		$response["data"][$i]["id"] = $data["id"];
		$response["data"][$i]["class"] = $data["class"];
		$response["data"][$i]["type"] = $data["type"];
		$response["data"][$i]["subject"] = $data["subject"];
		$response["data"][$i]["chapter"] = $data["chapter"];
		$response["data"][$i]["level"] = $data["level"];
		$response["data"][$i]["topic"] = $data["topic"];
		$response["data"][$i]["marks"] = $data["marks"];
		$response["data"][$i]["ques_txt"] = $data["ques_txt"];
		$response["data"][$i]["ques_img"] = $data["ques_img"];
		$response["data"][$i]["qr"] = $data["qr"];
		$response["data"][$i]["answer"] = $data["answer"];
		$response["data"][$i]["youtube"] = $data["youtube"];
		$i++;

	}
	$response["data"]["size"] = $i;

	echo json_encode($response);

}
viewquestion();	
