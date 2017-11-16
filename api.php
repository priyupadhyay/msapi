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

		case 'addquestions':

		addquestions();
		break;
		case 'deletetopic':

		deletetopic();
		break;
		case 'deletechapter':

		deletechapter();
		break;

		case 'getchapterbyid':
		getchapterbyid();
		break;

		case 'editchapter':
		editchapter();
		break;

		case 'gettopicbyid':
		gettopicbyid();
		break;

		case 'edittopic':
		edittopic();
		break;
		case 'getquestionbyid':
		getquestionbyid();
		break;
		case 'sendcartdata':
		sendcartdata();
		break;
		case 'viewquestionpaper':
			viewquestionpaper();
			break;
		case 'getquestionpaperbyid':
				getquestionpaperbyid();
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


				$response["data"][] = array("id" => $data["id"], "chapter" => $data["chap"]);
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
// if(!isset($_POST["ch_id"]) || empty($_POST["ch_id"]) || !isset($_POST["topic"]) || empty($_POST["topic"]) ){
// $response["error"] = TRUE;
//     $response["error_msg"] = "Insert data Missing!";
// }
// else{
	include 'dbconnect.php';

	$question = $_POST['question'];
	$answer = $_POST['answer'];
	$group = $_POST['group'];
	$mcq1 = $_POST['mcq1'];
	$mcq2 = $_POST['mcq1'];
	$mcq3 = $_POST['mcq3'];
	$mcq4 = $_POST['mcq4'];
	$class = $_POST['class'];
	$subject = $_POST['subject'];
	$type = $_POST['type'];
	$tag = $_POST['tag'];
	$chapter = $_POST['chapter'];
	$topic  = $_POST['topic'];
	$level = $_POST['level'];
	$marks = $_POST['marks'];
	$link = $_POST['link'];
	$file = $_POST['file'];


	$chapter = getchaptersbyidlocal($chapter);



	$response = array("error" => FALSE);
	$sql = "INSERT INTO `questions` (`class`, `type`, `subject`, `chapter`, `level`, `topic`, `marks`, `ques_txt`, `ques_img`, `option1`, `option2`, `option3`, `option4`, `option5`, `answer`, `date`, `by`, `youtube`)
	VALUES ('$class', '$type', '$subject', '$chapter', '$level', '$topic', $marks, '$question', '$file', '$mcq1', '$mcq2', '$mcq3', '$mcq4', 'null', '$answer', NOW(), 'admin', '$link');";

	if (mysqli_query($conn, $sql)) {
		$response["error"] = FALSE;
		$response["msg"] = "Questions added successfully!";
	} else {
		$response["error"] = TRUE;
		$response["error_msg"] = "Question could not be added!";
	}
//}
	echo json_encode($response);

}



/***********************************************************/
/********************* Get Chapters By Id local*********************/
/***********************************************************/


function getchaptersbyidlocal($ch_id){

	if($ch_id == ""){
		return "error";
	}
	else{
		include 'dbconnect.php';
		$sql = "SELECT * FROM chapters where id = $ch_id";
		if ($result = mysqli_query($conn, $sql)) {
			$data = mysqli_fetch_assoc($result);
			return $data['chap'];

		} 
		else {
			return "error";
		}
	}


}

/***********************************************************/
/********************* Get Chapters By Id *********************/
/***********************************************************/
function getchapterbyid(){
	$ch_id = $_POST['ch_id'];
	if($ch_id == ""){
		$response = array("error" => TRUE);
		$response['error_msg'] = "some error"; 
	}
	else{
		include 'dbconnect.php';
		$sql = "SELECT * FROM chapters where id = $ch_id";
		if ($result = mysqli_query($conn, $sql)) {
			$data = mysqli_fetch_assoc($result);
			$response = array("error" => FALSE);
			
			$response["data"]  = array();
			$response["data"][] = array("id" => $data["id"], "chapter" => $data["chap"], "subject" => $data["subject"], "class" => $data["class"]);



			

		} 
		else {
			$response = array("error" => TRUE);
			$response['error_msg'] = "some error"; 
		}
		echo json_encode($response);
	}


}


/***********************************************************/
/********************* Delete Topic *********************/
/***********************************************************/

function deletetopic(){
	$response = array("error" => FALSE);
	if(!isset($_POST["topicid"]) || empty($_POST["topicid"])){
		$response["error"] = TRUE;
		$response["error_msg"] = "Data Missing!";
	}
	else{
		include 'dbconnect.php';

		$topicid = $_POST["topicid"];

		$response = array("error" => FALSE);

		$sql = "DELETE FROM `topics` WHERE `id` = $topicid";
		if ($result = mysqli_query($conn, $sql)) {
			$response["error"] = FALSE;
			$response["msg"] = "Topic Deleted!";


		} else {
			$response["error"] = TRUE;
			$response["error_msg"] = "Could not be deleted!";
		}

	}
	echo json_encode($response);

}

/***********************************************************/
/********************* Delete Chapter*********************/
/***********************************************************/

function deletechapter(){
	$response = array("error" => FALSE);
	if(!isset($_POST["ch_id"]) || empty($_POST["ch_id"])){
		$response["error"] = TRUE;
		$response["error_msg"] = "Data Missing!";
	}
	else{
		include 'dbconnect.php';

		$ch_id= $_POST["ch_id"];

		$response = array("error" => FALSE);

		$sql = "DELETE FROM `chapters` WHERE `id` = $ch_id";
		if ($result = mysqli_query($conn, $sql)) {
			$response["error"] = FALSE;
			$response["msg"] = "Chapter Deleted!";


		} else {
			$response["error"] = TRUE;
			$response["error_msg"] = "Could not be deleted!";
		}

	}
	echo json_encode($response);

}
/***********************************************************/
/********************* Edit Chapter *********************/
/***********************************************************/

function editchapter(){
	$response = array("error" => FALSE);
	if(!isset($_POST["chapter_name"]) || empty($_POST["chapter_name"]) || !isset($_POST["subject"]) || empty($_POST["subject"]) || !isset($_POST["class"]) || empty($_POST["class"])
		|| !isset($_POST["ch_id"]) || empty($_POST["ch_id"])){
		$response["error"] = TRUE;
	$response["error_msg"] = "Insert data Missing!";
}
else{
	include 'dbconnect.php';

	$chapter_name = $_POST["chapter_name"];
	$subject = $_POST["subject"];
	$class = $_POST["class"];
	$ch_id = $_POST["ch_id"];
	$response = array("error" => FALSE);
	$sql = "UPDATE chapters SET chap ='$chapter_name',
	class='$class',
	subject='$subject'
	WHERE id = $ch_id";

	if (mysqli_query($conn, $sql)) {
		$response["error"] = FALSE;
		$response["msg"] = "Chapter updated successfully!";
	} else {
		$response["error"] = TRUE;
		$response["error_msg"] = "Chapter could not be updated!";
	}
}
echo json_encode($response);


}

/***********************************************************/
/********************* Get Topic By Id *********************/
/***********************************************************/
function gettopicbyid(){

	if(!isset($_POST['topic_id']) || empty($_POST['topic_id'])){
		
		$response = array("error" => TRUE);
		$response['error_msg'] = "id not set"; 
	}
	else{
		$topic_id = $_POST['topic_id'];
		include 'dbconnect.php';
		$sql = "SELECT * FROM topics where id = $topic_id";
		if ($result = mysqli_query($conn, $sql)) {
			$data = mysqli_fetch_assoc($result);
			$response = array("error" => FALSE);
			
			$response["data"]  = array();
			$response["data"][] = array("id" => $data["id"], "topic" => $data["name"], "ch_id" => $data["ch_id"]);



			

		} 
		else {
			$response = array("error" => TRUE);
			$response['error_msg'] = "query failed ".$sql; 
		}
		echo json_encode($response);
	}


}

/***********************************************************/
/********************* Edit Topic By Id *********************/
/***********************************************************/
function edittopic(){
	$response = array("error" => FALSE);
	if(!isset($_POST["topic_name"]) || empty($_POST["topic_name"]) || !isset($_POST["topic_id"]) || empty($_POST["topic_id"]) || !isset($_POST["ch_id"]) || empty($_POST["ch_id"])){
		$response["error"] = TRUE;
		$response["error_msg"] = "Insert data Missing!";
	}
	else{
		include 'dbconnect.php';


		$ch_id = $_POST["ch_id"];
		$topic_name = $_POST['topic_name'];
		$topic_id = $_POST['topic_id'];
		$response = array("error" => FALSE);
		$sql = "UPDATE topics SET name ='$topic_name',
		ch_id = $ch_id
		WHERE id = $topic_id";

		if (mysqli_query($conn, $sql)) {
			$response["error"] = FALSE;
			$response["msg"] = "topic updated successfully!";
		} else {
			$response["error"] = TRUE;
			$response["error_msg"] = "topic could not be updated!";
		}
	}
	echo json_encode($response);


}


/***********************************************************/
/********************** View Question By Id *********************/
/***********************************************************/

function getquestionbyid(){

	include 'dbconnect.php';

	$id = $_POST['qid'];

	$response = array("error" => FALSE);
	$sql = "SELECT * FROM questions WHERE `status`= 1 AND id = $id";
	$result = mysqli_query($conn, $sql);
	$i=0;

	$data = mysqli_fetch_assoc($result);
	$response["error"] = FALSE;
	$response["data"]  = array();
	$response["data"][] = array("id" => $data["id"], 
		"topic" => $data["name"], 
		"id" => $data["id"],
		"class" => $data["class"],
		"type" => $data["type"],
		"subject" => $data["subject"],
		"chapter" => $data["chapter"],
		"level" => $data["level"],
		"topic" => $data["topic"],
		"marks" => $data["marks"],
		"ques_txt" => $data["ques_txt"],
		"ques_img" => $data["ques_img"],
		"qr" => $data["qr"],
		"answer" => $data["answer"],
		"youtube" => $data["youtube"]);


	echo json_encode($response);

}	

/***********************************************************/
/********************** View Question By Id Local*********************/
/***********************************************************/

function getquestionbyidlocal($qid){

	include 'dbconnect.php';

	$id = $qid;

	$response = array("error" => FALSE);
	$sql = "SELECT * FROM questions WHERE `status`= 1 AND id = $id";
	$result = mysqli_query($conn, $sql);
	$i=0;

	$data = mysqli_fetch_assoc($result);
	$response["error"] = FALSE;
	$response["data"]  = array();
	$response["data"][] = array("id" => $data["id"], 
		"topic" => $data["name"],
		"class" => $data["class"],
		"type" => $data["type"],
		"subject" => $data["subject"],
		"chapter" => $data["chapter"],
		"level" => $data["level"],
		"topic" => $data["topic"],
		"marks" => $data["marks"],
		"ques_txt" => $data["ques_txt"],
		"ques_img" => $data["ques_img"],
		"qr" => $data["qr"],
		"answer" => $data["answer"],
		"youtube" => $data["youtube"]);


	return $response ;

}	


function sendcartdata(){
	include 'dbconnect.php';
	$response = array("error" => FALSE);
	if(!isset($_POST['qpname']) || empty($_POST['qpname']) ||
		!isset($_POST['qpclass']) || empty($_POST['qpclass']) ||
		!isset($_POST['qpsubject']) || empty($_POST['qpsubject']) ||
		!isset($_POST['qptime']) || empty($_POST['qptime']) ||
		!isset($_POST['qlist']) || empty($_POST['qlist']) ){
		$response["error"] = TRUE;
	$response["error_msg"] = "Insert data Missing!";

}
else{

	$qpname = $_POST['qpname'];
	$qpclass = $_POST['qpclass'];
	$qpsubject = $_POST['qpsubject'];
	$qptime = $_POST['qptime'];
	$qlist = explode(",",$_POST['qlist']);
	$response["error"] = FALSE;
	$response['questions_added'] = count($qlist);

	$sql = "INSERT INTO quest_list (qname,qclass,qsubject,qtime,qdate,qmarks)
		VALUES ('$qpname', '$qpclass', '$qpsubject','$qptime',NOW(),0)"; 
		mysqli_query($conn, $sql);

		$qpid = mysqli_insert_id($conn);
		$marks=0;
	foreach ($qlist as $key => $value) {
		$qdetails = getquestionbyidlocal($value);
		$qid = $qdetails['data'][0]['id'];
		$type = $qdetails['data'][0]['type'];
		$marks += $qdetails['data'][0]['marks'];
		$seca = 0;
		$secb = 0;
		$secc = 0;
		if($type < 3){
			$seca = 1;
		}
		elseif($type < 4){
			$secb = 1;
		}
		else{
			$secc = 1;
		}

		$sql2 = "INSERT INTO quest_paper (quesid,quesa,quesb,quesc,qpid)
					VALUES($qid,$seca,$secb,$secc,$qpid)";
					mysqli_query($conn, $sql2);
					
}
	$sql3 = "UPDATE quest_list SET qmarks=$marks WHERE qid = $qpid";
	mysqli_query($conn, $sql3);
$response['question_paper_id'] = $qpid;
$response['marks'] = $marks;



}
	echo json_encode($response);

}
function viewquestionpaper(){
	include 'dbconnect.php';


	$response = array("error" => FALSE);
	$sql = "SELECT * FROM quest_list";
	$result = mysqli_query($conn, $sql);
	$i=0;

	while($data = mysqli_fetch_assoc($result)){
		$response["error"] = FALSE;
		$response["data"][] = array(
		"id" => $data["qid"], 
		"name" => $data["qname"],
		"class" => $data["qclass"],
		"time" => $data["qtime"],
		"subject" => $data["qsubject"],
		"marks" => $data["qmarks"],
		"date" => $data["qdate"]);
		

		$i++;

	}
	$response["size"] = $i;

	echo json_encode($response);
}

function getquestionpaperbyid(){
	$qpid=$_POST['qpid'];
	$response = array("error" => FALSE);
	$response['msg'] = "will be done soon.";

	$sql = "SELECT quesid FROM quest_list WHERE qpid=$qpid";
	$result = mysqli_query($conn, $sql);
	$qids=array();
	while($data = mysqli_fetch_assoc($result)){
		qids[$data['quesid']]=$data['quesid'];
	}

	$sql = "SELECT quesid FROM quest_list WHERE qpid=$qpid";
	$result = mysqli_query($conn, $sql);
	while($data = mysqli_fetch_assoc($result)){
		$response['data']['qname']=$data['qname'];
		$response['data']['qclass']=$data['qclass'];
		$response['data']['subject']=$data['subject'];
		$response['data']['time']=$data['time'];
		$response['data']['date']=$data['date'];
		$response['data']['marks']=$data['marks'];

	}


	$i=0;
	foreach($qids as $key=>$value){
		$sql = "SELECT ques_txt,subject,marks,option1,option2,option3,option4,option5 FROM questions WHERE id=$key";
		$result = mysqli_query($conn, $sql);
		
		while($quesdata = mysqli_fetch_assoc($result)){
			$response['data']['questions'][]=array(
		
			"ques_txt" => $data["ques_txt"],
			"subject" => $data["subject"],
			"options" => array(
				"option1"=>$data["option1"],
				"option2"=>$data["option2"],
				"option3"=>$data["option3"],
				"option4"=>$data["option4"],
				"option5"=>$data["option5"]),
			"marks" => $data["marks"]
			);
		}
	}
	
	


	echo json_encode($response);


}
?>

