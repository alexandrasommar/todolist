<?php
require_once "dbconnect.php";

mysqli_set_charset($conn,"utf8");
$stmt = $conn->stmt_init();


/**
*	This block of code checks if the user pressed delete or complete
*	If they pressed delete, the task is deleted from the database
*	If they pressed complete, the task is updated to 1, e g complete
*	Based on the action, a success message is displayed.
**/

$message = "";


if( isset($_GET["delete"]) ) {
	$taskToDelete = $_GET["delete"];
	$query = "DELETE FROM tasks WHERE id = '{$taskToDelete}'";

	if( $stmt->prepare($query) ) {
		$stmt->execute();
		$message = "Uppgiften raderades!";
	}
}

if( isset($_GET["complete"]) ) {
	$taskComplete = $_GET["complete"];
	$query = "UPDATE tasks SET complete = 1 WHERE id = '{$taskComplete}'";

	if($stmt->prepare($query)) {
		$stmt->execute();
		$message = "Uppgiften markerades som klar!";
	}
}
/*
*	This block of code checks if the user pressed sort
*	and will sort the tasks based on the selected view.
*/

$sort = "";

if(isset($_GET["sort"])) { 
	$sort = $_GET["sort"]; 
}

if($sort == "name") {
	$query = "SELECT * FROM tasks ORDER BY taskName";
} else if ($sort == "asc") {
	$query = "SELECT * FROM tasks ORDER BY priority ASC";
} else if ($sort == "desc") {
	$query = "SELECT * FROM tasks ORDER BY priority DESC";
} else if ($sort == "done") {
	$query = "SELECT * FROM tasks WHERE complete = 1";
} else if ($sort == "notdone") {
	$query = "SELECT * FROM tasks WHERE complete = 0";
} else {
	$query = "SELECT * FROM tasks";
}

/*
*	This block of code checks if the user pressed add task
*	and checks that they submitted a taskname.
*	
*	If they did, the task is added to the database.
* 	Else, an error message is displayed.
*/


if(isset($_POST["addtask"])) {
	if (!empty($_POST["taskname"])) {
		$stmt = $conn->stmt_init();
		$taskName = ucfirst($_POST["taskname"]);
		$prio = $_POST["prio"];
		$query = "INSERT INTO tasks 
				VALUES ('', '{$taskName}', 0, '{$prio}')";
	if($stmt->prepare($query)) {
		$stmt->execute();
		header("Location: index.php?taskadded");
	}
	$stmt->close();
	$conn->close();
} else {
	$message = "Du måste fylla i namn på uppgiften.";
}
}

	if (isset($_GET["taskadded"])) {
 	$message = "Uppgiften lades till!";
 }


/*
*	This block of code checks how many tasks that are complete (1) 
*	and incomplete (0). The results are stored in $row_cnt for 
*	completed tasks, and $row_not for incomplete tasks.
*	On index.php the numbers are displayed in the statistics div.
*/

if ($result = mysqli_query($conn, "SELECT * FROM tasks WHERE complete = 1")) {

    $row_cnt = mysqli_num_rows($result);

    mysqli_free_result($result);
} 

if ($result = mysqli_query($conn, "SELECT * FROM tasks WHERE complete = 0")) {

    $row_not = mysqli_num_rows($result);

    mysqli_free_result($result);
} 



?>