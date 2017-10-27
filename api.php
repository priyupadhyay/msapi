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
		case 'addsubject':

			addsubject();
			break;
		case 'addchapter':

			addchapter();
			break;
		case 'addtopic':

			addtopic();
			break;
		case 'getchapters':

			getchapters();
			break;
		case 'gettopics':

			gettopics();
			break;
		case 'deletequestion':

			deletequestion();
			break;
		case 'deletesubject':

			deletesubject();
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
/********************* Add Subject *********************/
/***********************************************************/

function addsubject(){
$response = array("error" => FALSE);
if(!isset($_POST["subject_name"]) || empty($_POST["subject_name"])){
$response["error"] = TRUE;
    $response["error_msg"] = "Insert data Missing!";
}
else{
include 'dbconnect.php';

$subject_name = $_POST["subject_name"];
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
}
echo json_encode($response);



}

/***********************************************************/
/********************* Add Chapter *********************/
/***********************************************************/

function addchapter(){
$response = array("error" => FALSE);
if(!isset($_POST["chapter_name"]) || empty($_POST["chapter_name"]) || !isset($_POST["subject"]) || empty($_POST["subject"]) || !isset($_POST["class"]) || empty($_POST["class"])){
$response["error"] = TRUE;
    $response["error_msg"] = "Insert data Missing!";
}
else{
include 'dbconnect.php';

$chapter_name = $_POST["chapter_name"];
$subject = $_POST["subject"];
$class = $_POST["class"];
$response = array("error" => FALSE);
$sql = "INSERT INTO chapters (chap,class,subject)
		VALUES ('$chapter_name', '$class', '$subject')";

if (mysqli_query($conn, $sql)) {
	$response["error"] = FALSE;
	$response["msg"] = "Chapter added successfully!";
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Chapter could not be added!";
}
}
echo json_encode($response);



}



/***********************************************************/
/********************* Add Topics *********************/
/***********************************************************/

function addtopic() {
$response = array("error" => FALSE);
if(!isset($_POST["ch_id"]) || empty($_POST["ch_id"]) || !isset($_POST["topic"]) || empty($_POST["topic"]) ){
$response["error"] = TRUE;
    $response["error_msg"] = "Insert data Missing!";
}
else{
include 'dbconnect.php';

$ch_id = $_POST["ch_id"];
$topic = $_POST["topic"];

$response = array("error" => FALSE);
$sql = "INSERT INTO topics (ch_id,name)
		VALUES ('$ch_id', '$topic')";

if (mysqli_query($conn, $sql)) {
	$response["error"] = FALSE;
	$response["msg"] = "topic added successfully!";
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Topic could not be added!";
}
}
echo json_encode($response);

}




/***********************************************************/
/********************* Get Chapters *********************/
/***********************************************************/

function getchapters(){
$response = array("error" => FALSE);
if(!isset($_POST["subject"]) || empty($_POST["subject"]) || !isset($_POST["class"]) || empty($_POST["class"])){
$response["error"] = TRUE;
    $response["error_msg"] = "Data Missing!";
}
else{
include 'dbconnect.php';

$chapter_name = $_POST["chapter_name"];
$subject = $_POST["subject"];
$class = $_POST["class"];
$response = array("error" => FALSE);

$sql = "SELECT id, chap FROM chapters where `subject` = '$subject' AND `class` = '$class'";
if ($result = mysqli_query($conn, $sql)) {
	$response["error"] = FALSE;
	$i=0;

	$response["data"]  = array();

while($data = mysqli_fetch_assoc($result)){
	
	
	 array_push($response["data"], "id" => $data["id"], "chapter" => $data["chap"]);
	//$response["data"] = array("chapter" => $data["chap"]);
	
	
	$i++;

}
$response["size"] = $i;

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "No Chapters Found!";
}

}
echo json_encode($response);

}

/***********************************************************/
/********************* Get Topics *********************/
/***********************************************************/

function gettopics(){
$response = array("error" => FALSE);
if(!isset($_POST["ch_id"]) || empty($_POST["ch_id"]) ){
$response["error"] = TRUE;
    $response["error_msg"] = "Data Missing!";
}
else{
include 'dbconnect.php';

$chapter_id = $_POST["ch_id"];
$response = array("error" => FALSE);

$sql = "SELECT * FROM topics where ch_id = $chapter_id";
if ($result = mysqli_query($conn, $sql)) {
	$response["error"] = FALSE;
	$i=0;

while($data = mysqli_fetch_assoc($result)){
	$response["error"] = FALSE;
	
	$response["data"][$i]["id"] = $data["id"];
	$response["data"][$i]["topic"] = $data["name"];
	
	
	$i++;

}
$response["data"]["size"] = $i;

} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "No Topics Found!";
}

}
echo json_encode($response);

}

/***********************************************************/
/********************* Delete Questions *********************/
/***********************************************************/

function deletequestion(){
$response = array("error" => FALSE);
if(!isset($_POST["qid"]) || empty($_POST["qid"])){
$response["error"] = TRUE;
    $response["error_msg"] = "Data Missing!";
}
else{
include 'dbconnect.php';

$qid = $_POST["qid"];

$response = array("error" => FALSE);

$sql = "UPDATE `questions` SET `status` = 0 WHERE `id` = $qid";
if ($result = mysqli_query($conn, $sql)) {
	$response["error"] = FALSE;
	$response["msg"] = "Question Deleted!";


} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Could not be deleted!";
}

}
echo json_encode($response);

}


/***********************************************************/
/********************* Delete Subjects *********************/
/***********************************************************/

function deletesubject(){
$response = array("error" => FALSE);
if(!isset($_POST["qid"]) || empty($_POST["qid"])){
$response["error"] = TRUE;
    $response["error_msg"] = "Data Missing!";
}
else{
include 'dbconnect.php';

$qid = $_POST["qid"];

$response = array("error" => FALSE);

$sql = "DELETE FROM `subjects` WHERE `id` = $qid";
if ($result = mysqli_query($conn, $sql)) {
	$response["error"] = FALSE;
	$response["msg"] = "Subject Deleted!";


} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Could not be deleted!";
}

}
echo json_encode($response);

}

/***********************************************************/
/********************* Add Questions *********************/
/***********************************************************/

function addquestions() {
$response = array("error" => FALSE);
if(!isset($_POST["ch_id"]) || empty($_POST["ch_id"]) || !isset($_POST["topic"]) || empty($_POST["topic"]) ){
$response["error"] = TRUE;
    $response["error_msg"] = "Insert data Missing!";
}
else{
include 'dbconnect.php';

$ch_id = $_POST["ch_id"];
$topic = $_POST["topic"];

$response = array("error" => FALSE);
$sql = "INSERT INTO topics (ch_id,name)
		VALUES ('$ch_id', '$topic')";

if (mysqli_query($conn, $sql)) {
	$response["error"] = FALSE;
	$response["msg"] = "Questions added successfully!";
} else {
    $response["error"] = TRUE;
    $response["error_msg"] = "Question could not be added!";
}
}
echo json_encode($response);

}




?>

