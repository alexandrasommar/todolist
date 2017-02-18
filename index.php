<?php
$pageTitle = "To Do List";
include "inc/header.php";
include "inc/checktasks.php";

?>
<main class="main">
	<h1>Mycket att göra? Svårt att hålla koll?</h1>
	<h2>Använd vår to do list!</h2>

	<?php 
	// If there is a message set in checktasks.php, error or success, display it here

	if (!empty($message)) {
	echo "<p class='message'>" . $message . "</p>";
	}
	?>
	<p class="button"><a href="index.php?sort=done">Visa färdiga uppgifter</a></p>

	<p class="button"><a href="index.php?sort=notdone">Visa ofärdiga uppgifter</a></p>
	<p>Sortera dina uppgifter:
		<a href="index.php?sort=name">Namn</a> |
		<a href="index.php?sort=desc">Mest brådskande</a> |
		<a href="index.php?sort=asc">Minst brådskande</a> |
		<a href="index.php?sort=none">Standardsortering</a>
	</p>
	<table>
		<tr>
	 		<th>Namn på uppgift</th>
	 		<th>Status</th>
	 		<th>Hur bråttom är det?</th>
	 		<th>Markera som klar</th>
	 		<th>Ta bort</th>
		</tr>
		<?php
		/*
		* This block of code runs through all the columns in the 
		* database and prints them out in the table
		*/

		if($stmt->prepare($query)) { 
			$stmt->execute();
			$stmt->bind_result($id, $taskName, $complete, $priority);
		?><?php
			
			while( mysqli_stmt_fetch($stmt) ) {

		 ?>
		 	 <?php
					$class = "";
					if ($priority == 3){
						$class = "prio";
					}
					if($complete == 1) {
						$class = "done";
					}
				?>
		<tr class="<?php echo $class;?>">
				
			<td><?php echo $taskName; ?></td>
			<td><?php 
			if( $complete == 1 ) {
				echo "Klart!";
			} else {
				echo "Inte klart";
			}?></td>
			<td><?php 
			
			if($priority == 1) {
				echo "Lite brådis";
			}
			if ($priority == 2) {
				echo "Mer brådis";
			}
			if ($priority == 3){
				echo "Jättebrådis!";
			} elseif ($priority == 0) {
				echo "Ingen prio alls";
			}
	 		?></td>
		 		<td><a href="index.php?complete=<?php echo $id;?>&sort=<?php echo $sort; ?>">Färdig</a></td>
		 		<td><a href="index.php?delete=<?php echo $id;?>">Radera</a></td>
		</tr>
		<?php } ?>	
	</table>

	<?php  } ?>
	<div class="form">
		<h3>Lägg till ny uppgift</h3>
		<form method="post" action="index.php">
			<label for="taskname">Namn på uppgiften:</label>
			<input type="text" name="taskname">
			<select name="prio">
				<<option value="0">Ingen prio</option>
				<option value="1">Lite brådis</option>
				<option value="2">Mer brådis</option>
				<option value="3">Jättebrådis!</option>
			</select>
			<input type="submit" name="addtask" value="Lägg till">
		</form>
	</div>
	<div class="statistics">
		<h3>Såhär ligger du till just nu:</h3>
		<p>Avklarade uppgifter: <?php echo $row_cnt; ?> stycken</p>
		<p>Uppgifter kvar att göra: <?php echo $row_not; ?> stycken</p>
	</div>
</main>
</body>
</html>