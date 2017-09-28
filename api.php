<?php
header("Content-Type: application/json");

/***********************************************************/
/******************* Functions Switching *******************/
/***********************************************************/

if(isset($_POST["func"]) && !empty($_POST["func"])){
	switch ($_POST["func"]) {
		case 'viewquestion':

			viewquestion();
			break;
		case 'viewsubject':

			viewsubject();
			break;
		case 'viewchapter':

			viewchapter();
			break;
		case 'viewtopic':

			viewtopic();
			break;
		case 'countdata':

			countdata();
			break;
		

		
		default:
		$response = array("error" => TRUE);
	$response["error_msg"] = "Function name not defined.";
    echo json_encode($response);
			break;
	}

}
else{
	$response = array("error" => TRUE);
	$response["error_msg"] = "Function name missing.";
    echo json_encode($response);
}


/***********************************************************/
/********************* Functions Start *********************/
/***********************************************************/

/***********************************************************/
/********************** View Questions *********************/
/***********************************************************/

function viewquestion(){

include 'dbconnect.php';


$response = array("error" => FALSE);
$sql = "SELECT * FROM questions";
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
	//Options Remaining
	$response["data"][$i]["answer"] = $data["answer"];
	$response["data"][$i]["youtube"] = $data["youtube"];
	$i++;

}
$response["data"]["size"] = $i;

echo json_encode($response);

}	

/***********************************************************/
/********************* View Subjects  *********************/
/***********************************************************/

function viewsubject(){

include 'dbconnect.php';


$response = array("error" => FALSE);
$sql = "SELECT * FROM subjects";
$result = mysqli_query($conn, $sql);
$i=0;

while($data = mysqli_fetch_assoc($result)){
	$response["error"] = FALSE;
	$response["data"][$i]["id"] = $data["id"];
	$response["data"][$i]["name"] = $data["subject"];
	$response["data"][$i]["chapter_count"] = $data["chapno"];
	$response["data"][$i]["question_count"] = $data["qno"];
	
	$i++;

}
$response["data"]["size"] = $i;

echo json_encode($response);

}

/***********************************************************/
/********************* View Chapters *********************/
/***********************************************************/

function viewchapter(){

include 'dbconnect.php';


$response = array("error" => FALSE);
$sql = "SELECT * FROM chapters";
$result = mysqli_query($conn, $sql);
$i=0;

while($data = mysqli_fetch_assoc($result)){
	$response["error"] = FALSE;
	$response["data"][$i]["id"] = $data["id"];
	$response["data"][$i]["name"] = $data["chap"];
	$response["data"][$i]["subject"] = $data["subject"];
	$response["data"][$i]["class"] = $data["class"];
	$response["data"][$i]["topic_count"] = $data["topicno"];
	
	$i++;

}
$response["data"]["size"] = $i;

echo json_encode($response);

}

/***********************************************************/
/*********************** View Topics ***********************/
/***********************************************************/

function viewtopic(){

include 'dbconnect.php';


$response = array("error" => FALSE);
$sql = "SELECT topics.id as id, name, chap FROM topics,chapters where ch_id = chapters.id";
$result = mysqli_query($conn, $sql);
$i=0;

while($data = mysqli_fetch_assoc($result)){
	$response["error"] = FALSE;
	$response["data"][$i]["id"] = $data["id"];
	$response["data"][$i]["name"] = $data["name"];
	$response["data"][$i]["chapter"] = $data["chap"];
	
	
	$i++;

}
$response["data"]["size"] = $i;

echo json_encode($response);

}

/***********************************************************/
/********************* Count data *********************/
/***********************************************************/

function countdata(){

include 'dbconnect.php';


$response = array("error" => FALSE);
$sql = "SELECT
  (SELECT COUNT(*) FROM questions)  as question_count, 
  (SELECT COUNT(*) FROM chapters) as chapter_count,
  (SELECT COUNT(*) FROM subjects) as subject_count,
  (SELECT COUNT(*) FROM topics) as topic_count,
  (SELECT COUNT(*) FROM quest_paper) as questionpaper_count,
  (SELECT COUNT(*) FROM chapters) as chapter_count,
  (SELECT COUNT(*) FROM user) as user_count";
$result = mysqli_query($conn, $sql);
$i=0;
if($data = mysqli_fetch_assoc($result)){
	$response["error"] = FALSE;
	$response["data"]["questions_count"] = $data["question_count"];
	$response["data"]["chapters_count"] = $data["question_count"];
	$response["data"]["subjects_count"] = $data["subject_count"];
	$response["data"]["topics_count"] = $data["topic_count"];
	$response["data"]["questionpaper_count"] = $data["questionpaper_count"];
	$response["data"]["users_count"] = $data["user_count"];
}

echo json_encode($response);

}

/***********************************************************/
/*********************  *********************/
/***********************************************************/

function addsubject(){

include 'dbconnect.php';

$subject_name = $_POST['subject_name']
$response = array("error" => FALSE);
$sql = "INSERT INTO subjects (subject)
		VALUES ('$subject_name')";

if (mysqli_query($conn, $sql)) {
	$response["error"] = FALSE;
	$response["msg"] = "Subject added successfully!";
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Subject could not be added!";
}

echo json_encode($response);

}


?>

