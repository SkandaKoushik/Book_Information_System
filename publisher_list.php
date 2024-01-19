<?php
	session_start();
	require_once "./functions/database_functions.php";
	$conn = db_connect();

	$query = "SELECT * FROM publisher ORDER BY publisherid";
	$result = mysqli_query($conn, $query);
	if(!$result){
		echo "Can't retrieve data " . mysqli_error($conn);
		exit;
	}
	if(mysqli_num_rows($result) == 0){
		echo "Empty publisher ! Something wrong! check again";
		exit;
	}

	$title = "List Of Publishers";
	require "./template/header.php";
?>
	<h2 class="lead">List of Publisher</h2>
	<br>
	<table>
	<?php 
		while($row = mysqli_fetch_assoc($result)){
			$count = 0; 
			$query = "SELECT publisherid FROM books";
			$result2 = mysqli_query($conn, $query);
			if(!$result2){
				echo "Can't retrieve data " . mysqli_error($conn);
				exit;
			}
			while ($pubInBook = mysqli_fetch_assoc($result2)){
				if($pubInBook['publisherid'] == $row['publisherid']){
					$count++;
				}
			}
	?>
		<tr>
			<td>
		    <a href="bookPerPub.php?pubid=<?php echo $row['publisherid']; ?>"><h4><?php echo $row['publisher_name']; ?></h4></a>
			<hr>
		</td>
		</tr>
	<?php } ?>
	</table>
	<br><br>
	<a href="books.php" class="btn btn-default">List All Books</a>
	
<?php
	mysqli_close($conn);
	require "./template/footer.php";
?>