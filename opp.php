<html>

<head>

</head>
</head>
<body>
<div id="wrapper">
<?php 
include_once 'includes/psl-config.php';

//Brukeren åpner denne, så få info-query om oppmøte
//få ut info fra det.

//echo "Deltager:"; 
$oppid = $_GET['oppid'];
echo "<br>";


$commentd = "kommentarer";

// create mysqli object
$spillerbase = new mysqli($host, $user, $pass, $db);

//basert på lagid, så skriv ut resten

$qrySelOpp = "SELECT * FROM opp WHERE oppid='$oppid'";
$resSelOpp = mysqli_query($spillerbase, $qrySelOpp);



while($row = mysqli_fetch_assoc($resSelOpp)) {

	$navnid = $row["navnid"];
	$kommentaro = $row["kommentaro"];
	$aktivid = $row["aktivid"];	
	
}

$deltager = mysqli_query($spillerbase, "SELECT * FROM deltagere WHERE id='$navnid'");
while($row = mysqli_fetch_assoc($deltager)) {
	$navn = $row["navn"];
	$etternavn = $row["etternavn"];
}
echo $navn;
echo " ";
echo $etternavn;

if (isset($_POST['oppdato'])) {
	$kommentaro = $_POST['kommentaro'];

	$qryUpdComment = "UPDATE opp SET kommentaro = '$kommentaro' WHERE oppid = '$oppid'";
	$resUpdComment = mysqli_query($spillerbase, $qryUpdComment) or die ("Error in query: $qryUpdComment. ".mysql_error());

}

?>
<form method="post" action="<?php echo 'opp.php?oppid='.$oppid.'';?>">
Kommentar: <textarea name="kommentaro" rows="5" cols="40"><?php echo $kommentaro;?></textarea>  <br>
   <input type="submit" name="oppdato" value="Lagre">
</form>



<?php 

//echo $commenta;


echo '</div>';


echo '<br /><a href="lag.php">Tilbake</a>';
echo '<td><a href="/brukeraktivitet.php?aktivid='.$aktivid.'">Tilbake</a></td>';


echo '<br>';




	

?>
</div>
</html>
