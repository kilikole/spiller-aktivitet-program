<html>

<head>

</head>
</head>
<body>
<?php 
include 'includes.php';
include_once 'includes/psl-config.php';


//Brukeren åpner denne, så få query om laget
//få ut info fra det.

//variabler for felt i database
$navn = "";
$email = "";
$alder = "";
$commentd = "";
$commenta = "";
$type = "";
$date = "";
$typevalg = "";
$alag = "";
$lagNavn = "";
$kjoenn = "";
$lagAlder = "";
$valgtLag = "";

echo "Lag:"; 
$lagid = $_GET['valgtLag'];
echo $lagid;
echo "<br>";


$commento = "kommentarer";

// create mysqli object
$spillerbase = new mysqli($host, $user, $pass, $db);


//basert på lagid, så skriv ut resten

$qrySelLag = "SELECT * FROM lag WHERE lagid='$lagid'";
$resSelLag = mysqli_query($spillerbase, $qrySelLag);
while($row = mysqli_fetch_assoc($resSelLag)) {
$lagnavn = $row["lagnavn"];
echo $lagnavn;
echo "<br>";

$kjoenn = $row["kjoenn"];
echo $kjoenn;
echo "<br>";

$alder = $row["alder"];
echo $alder;
echo "<br>";

//echo $commenta;
}


echo '<br /><a href="version.php">Tilbake</a>';
echo '<br>';


//Vis aktiviteter
$queryaktiv = "SELECT * FROM aktivitet WHERE alag='$lagid'";
if 	($resultaktiv = $spillerbase->query($queryaktiv)){

	if ($resultaktiv->num_rows > 0) {

echo '<h2><a id="aktiviteter">Aktiviteter</a></h2>';
echo "<table cellpadding=10 border=1>";
//session_start();
	while($row = $resultaktiv->fetch_array()) {

		echo "<tr>";
		//echo "<td>".$row[1]."</td>";
		echo '<td>'.visNorskDato($row[1]).'&nbsp'.substr($row[2], 0, 5).'</td>';
		echo '<td><a href="/brukeraktivitet.php?aktivid='.$row[0].'">'.$row[3].'</a></td>';
		echo "<td><a href=".$_SERVER['PHP_SELF']."?aktivid=".$row[0]." onClick=\"return confirm('Dette vil slette valgt aktivitet og deltagelse-historikk');\">Slett aktivitet</a></td>";
		echo "</tr>";
		
	}
	}
		
}	


	echo '<br>';
	echo '<br>';
	echo '<br>';
	echo '<br>';
	echo '<br>';

	

echo "Deltagere";

	$qrySelDeltagere = "SELECT * FROM deltagere WHERE lagid='$lagid'";
	$resSelDeltagere = mysqli_query($spillerbase, $qrySelDeltagere);
	echo '<h2><a id="deltagere">Deltagere</a></h2>';
	echo "<table cellpadding=10 border=1>";
	while($row = $resSelDeltagere->fetch_array()) {	
		echo "<tr>";
		echo '<td><a href="/brukerdeltager.php?id='.$row[0].'">'.$row[1].'&nbsp'.$row[2].'</a></td>';
		echo "<td>".$row[6]."</td>";
        echo "<td><a href=".$_SERVER['PHP_SELF']."?id=".$row[0]." onClick=\"return confirm('Dette vil slette valgt deltager');\">Slett deltager</a></td>";
		echo "</tr>";
	}

	
	


?>
</form>
</body>
</html>
