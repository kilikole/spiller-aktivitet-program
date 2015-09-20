<html>

<head>

</head>
</head>
<body>
<div id="wrapper">
<?php 
include_once 'includes/psl-config.php';

//Brukeren åpner denne, så få info-query om deltageren
//få ut info fra det.

//echo "Deltager:"; 
$id = $_GET['id'];
//echo $id;
echo "<br>";

//Åpne database connecton


$commentd = "kommentarer";

// create mysqli object
$spillerbase = new mysqli($host, $user, $pass, $db);

//basert på lagid, så skriv ut resten

$qrySelDeltager = "SELECT * FROM deltagere WHERE id='$id'";
$resSelDeltager = mysqli_query($spillerbase, $qrySelDeltager);

while($row = mysqli_fetch_assoc($resSelDeltager)) {
$navn = $row["navn"];
echo $navn;
echo "<br>";

$type = $row["type"];
echo $type;
echo "<br>";

$lagid = $row["lagid"];
echo $lagid;
echo "<br>";

$commentd = $row["commentd"];
//echo $commentd;
echo "<br>";


if (isset($_POST['oppdatd'])) {
	$commentd = $_POST['commentd'];

	$qryUpdComment = "UPDATE deltagere SET commentd = '$commentd' WHERE id = '$id'";
	$resUpdComment = mysqli_query($spillerbase, $qryUpdComment) or die ("Error in query: $qryUpdComment. ".mysql_error());

}


?>
<form method="post" action="<?php echo 'deltager.php?id='.$id.'';?>">
Kommentar: <textarea name="commentd" rows="5" cols="40"><?php echo $commentd;?></textarea>  <br>
   <input type="submit" name="oppdatd" value="Lagre">
</form>



<?php 

//echo $commenta;
}

echo '</div>';


echo '<td><a href="/brukerlag.php?valgtLag='.$lagid.'">Tilbake</a></td>';


echo '<br>';


	

?>

</html>
