<html>

<head>

</head>
</head>

<body>

<?php 

include_once 'includes/psl-config.php';
$commento = "kommentarer";
$checked = "";

// create mysqli object
$spillerbase = new mysqli($host, $user, $pass, $db);

//echo "Aktivitet:"; 
$aktivid = $_GET['aktivid'];

//henter ut info om aktivitet med query

$qaktiv = "SELECT * FROM aktivitet WHERE aktivid='$aktivid'";
$qresult = mysqli_query($spillerbase, $qaktiv);
while($row = mysqli_fetch_assoc($qresult)) {
$typeaktiv = $row["atype"];
echo $typeaktiv;
echo "<br>";

$adato = $row["adato"];
echo "Dato: ";
echo $adato;
echo "<br>";

$alag = $row["alag"];
echo "Lag: ";
echo $alag;
echo "<br>";

$commenta = $row["commenta"];

//Ved trykk p� oppdater kommentar, s� oppdater databasen.
if (isset($_POST['oppdata'])) {
	$commenta = $_POST['commenta'];

	$qryUpdComment = "UPDATE aktivitet SET commenta = '$commenta' WHERE aktivid = '$aktivid'";
	$resUpdComment = mysqli_query($spillerbase, $qryUpdComment) or die ("Error in query: $qryUpdComment. ".mysql_error());

}


echo '<a href="lag.php?valgtLag='.$alag.'">Tilbake</a>';
?>

<div id="wrapper">
<form method="post" action="<?php echo 'aktivitet.php?aktivid='.$aktivid.'';?>">
Kommentar: <textarea name="commenta" rows="5" cols="40"><?php echo $commenta;?></textarea>  <br>
<br><br><br>
<input type="submit" name="oppdata" value="Lagre kommentar">
<br><br><br>
<input type="submit" name="velgalle" value="Velg alle">
<br><br><br>

</form>

<form method="post" action="<?php echo 'aktivitet.php?aktivid='.$aktivid.'';?>">


<?php

}

// Utf�rer query, henter ut deltager fra db
$querydeltagere = "SELECT * FROM deltagere WHERE lagid='$alag'";

if ($result = $spillerbase->query($querydeltagere)) {
	//echo "Alle deltagere";
	echo "<br>";
	if ($result->num_rows > 0) {
		echo "<table cellpadding=8 border=1>";
		echo "<tr>";
		echo "<td>Navn</td>";
		echo "<td>Type</td>";
		echo "<td>Tilgjengelig</td>";
		echo "</tr>";

		$i = 0;
		// print them one after another
		while($row = $result->fetch_array()) {
				
			//Skriver ut navn og type
			echo '<td><a href="/deltager.php?id='.$row[0].'">'.$row[1].'&nbsp'.$row[2].'</a></td>';
			echo "<td>".$row[6]."</td>";
			
			//oppm�teid er en unik sammenstilling av aktivitet og deltager
			$oppid = $aktivid . $row[0];
				
			//henter ut tilgjengelighet fra databasen p� deltager basert p� oppm�teid
			if ($qtilgjengelig = "SELECT tilgjengelig FROM opp WHERE oppid='$oppid'"){

				$i++;
				$rtilgjengelig = mysqli_query($spillerbase, $qtilgjengelig);
				$getID = mysqli_fetch_assoc($rtilgjengelig);
				$tilgjengelig = $getID['tilgjengelig'];

			}		
			
			//Basert p� hva som er lagret i databasen, s� sjekk av det.
			
			if($tilgjengelig == "Ja"){
				$checked="checked";
				}
			else{
				$checked="";
			}	

			
			if (isset($_POST['velgalle'])) {
				$tilgjengelig = "Ja";
				$checked="checked";
			}
			


			//hvis brukeren har trykket for endringer, s� skal det overskride db
			if (isset($_POST['endringer'])){

				if (isset($_POST['check'.$i.''])){
					$tilgjengelig = "Ja";
					$checked ="checked";
				}
				else{
					$tilgjengelig = "Nei";
					$checked="";
				}
						}
			
			//vis sjekkboksen
			echo '<td><input type="checkbox" name="check'.$i.'" value="'.$i.'" '.$checked.' /></td>';
			
				
			echo "</tr>";
			 

			$tilstede = "Ikkesatt";
			//Legg til ny person i oppm�teprotokollen. Hvis oppm�te allerede er reigstrert s� oppdater i stedet.
			$queryoppmoete = "INSERT INTO opp (oppid, aktivid, navnid, tilstede, tilgjengelig, kommentaro) VALUES ('$oppid', '$aktivid', '$row[0]', '$tilstede', '$tilgjengelig', '$commento') ON DUPLICATE KEY UPDATE tilstede='$tilstede', tilgjengelig='$tilgjengelig'";
			if($result2 = $spillerbase->query($queryoppmoete)){
			}
			else{
				echo "Noe gikk galt med queryen result2";
			}

		}
	}
}


?>

 <input type="submit" id="submit" name="endringer" value="Lagre endringer">
</form></body>



</html>
