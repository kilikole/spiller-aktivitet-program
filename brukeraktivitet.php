<html>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">

</head>
</head>


<body>
<?php 

// DENNE OPPDATERER tilstede
$aktivid = $_GET['aktivid'];
//echo $aktivid;
include 'includes.php';
include_once 'includes/psl-config.php';
?>


<form method="post" action="<?php echo 'brukeraktivitet.php?aktivid='.$aktivid.'';?>">
 <input type="submit" name="tilgjengelig" value="Tilgjengelig" id="submit">
 <input type="submit" name="ikkemoett" value="Ikke moett" id="submit">
 <input type="submit" name="tilstede" value="Til stede" id="submit">
 <input type="submit" name="helelaget" value="Alle" id="submit">



<?php
$commento = "kommentarer";

// create mysqli object
$spillerbase = new mysqli($host, $user, $pass, $db);


//basert på aktivitetsnr. så skriv ut resten av info

$qaktiv = "SELECT * FROM aktivitet WHERE aktivid='$aktivid' ORDER BY adato";
$qresult = mysqli_query($spillerbase, $qaktiv);
while($row = mysqli_fetch_assoc($qresult)) {
$typeaktiv = $row["atype"];
echo $typeaktiv;
echo "&nbsp";

$adato = $row["adato"];
echo "Dato: ";
echo $adato;
echo "&nbsp";

$alag = $row["alag"];
echo "Lag: ";
echo $alag;
echo "&nbsp";

$commenta = $row["commenta"];
echo $commenta;
}

//vis alle tilgjengelige først.
getTilgjengelig($aktivid, $spillerbase, $aktivid);


//Hvis bruker trykker tilgjengelig
if (isset($_POST['tilgjengelig'])){
	//getTilgjengelig($aktivid, $spillerbase);
	
	
}

//Hvis bruker trykker ikke møtt
if (isset($_POST['ikkemoett'])){
$querydeltagere = "SELECT * FROM opp WHERE aktivid = '$aktivid' AND tilgjengelig = 'Ja' AND tilstede = 'Nei'";

	if ($result = $spillerbase->query($querydeltagere)) {
		visDeltagere($result, $spillerbase, $aktivid);
	}

}

//Hvis bruker trykker på tilstede
if (isset($_POST['tilstede'])){
	$querydeltagere = "SELECT * FROM opp WHERE aktivid = '$aktivid' AND tilstede = 'Ja'";
	if ($result = $spillerbase->query($querydeltagere)) {
		visDeltagere($result, $spillerbase, $aktivid);
		}
	
	}	
	

	
//Hvis bruker trykker på hele laget.
if (isset($_POST['helelaget'])){
	$querydeltagere = "SELECT * FROM opp WHERE aktivid = '$aktivid'";
	if ($result = $spillerbase->query($querydeltagere)) {
	visDeltagere($result, $spillerbase, $aktivid);
		}
	}
	
	//skriv ut basert på qrydeltagere:
	
function visDeltagere($result, $spillerbase, $aktivid){	

	
		if ($result->num_rows > 0) {
			echo "<table cellpadding=10 border=1>";
			echo "<tr>";
			echo "<td>Navn</td>";
			echo "<td>Type</td>";
			echo "<td>Kommentar</td>";
			echo "</tr>";
	
			$i = 0;
			// print them one after another
			while($row = $result->fetch_array()) {
		
				$qrySelNavn = "SELECT * FROM deltagere WHERE id= ".$row[2];
				$resSelNavn =  mysqli_query($spillerbase, $qrySelNavn) or die ("Error in query: $qrySelNavn. ".mysql_error());
				$fetchNavn = mysqli_fetch_assoc($resSelNavn);
				$deltagerNavn = $fetchNavn['navn'];
				$deltEtternavn = $fetchNavn['etternavn'];
				$navnid =  $fetchNavn['id'];
				$deltagerType = $fetchNavn['type'];
				
				$oppid = $aktivid.$navnid;
					
				echo '<td><a href="/brukerdeltager.php?id='.$row[2].'">'.$deltagerNavn.'&nbsp;'.$deltEtternavn.'</a></td>';
				echo "<td>$deltagerType</td>";
				echo '<td><a href="/opp.php?oppid='.$oppid.'">Notat</a></td>';
	
				echo "</tr>";
	
			}
		}
	
}	
	
	


function getTilgjengelig($aktivid, $spillerbase){
	$tilstede = "Ikkesatt";
	$commento = "testkommentar";
	
	
	
	if (isset($_POST['oppdater'])){
		header("Refresh:0; url=brukeraktivitet.php?aktivid=$aktivid");
	}

//Henter deltager som er tilgjengelig og tilstede er ikke satt
$querydeltagere = "SELECT * FROM opp WHERE aktivid = '$aktivid' AND tilgjengelig = 'Ja' AND tilstede = 'Ikkesatt'";
 
if ($result = $spillerbase->query($querydeltagere)) {
			echo "<br>";
	if ($result->num_rows > 0) {
		echo "<table cellpadding=10 border=1>"; 
		echo "<tr>";
		echo "<td>Navn</td>";
		echo "<td>Type</td>";
			echo "<td>Oppm&oslashte</td>";			
			echo "<td>Kommentar</td>";
			echo "</tr>";
		
			$i = 0;
		// print them one after another
		while($row = $result->fetch_array()) {
			$i++;
			//$tilstede = "";
			
			$qrySelNavn = "SELECT * FROM deltagere WHERE id= ".$row[2];
			$resSelNavn =  mysqli_query($spillerbase, $qrySelNavn) or die ("Error in query: $qrySelNavn. ".mysql_error());
			$fetchNavn = mysqli_fetch_assoc($resSelNavn);
			$deltagerNavn = $fetchNavn['navn'];
			$deltetternavn = $fetchNavn['etternavn'];
			$navnid =  $fetchNavn['id'];
			$deltagerType = $fetchNavn['type'];
			
			//oppmøteid er en unik sammenstilling av aktivitet og deltager
			$oppid = $aktivid . $navnid;				

		
			//Skriv ut deltager med link og type
			echo '<td><a href="/brukerdeltager.php?id='.$row[2].'">'.$deltagerNavn.'</a></td>';
			echo "<td>$deltagerType</td>";

		   //Hvis trykket oppdater, så blir tilstede forandret. 
		   // if (isset($_POST['oppdater'])){
		    	
		    	if (isset($_POST['tilstede'.$i.''])){
		    	$tilstede = $_POST['tilstede'.$i.''];
		    	}
		    	else{
		    		$tilstede = "Ikkesatt";
		    	}
		   // }
		    
		   	 //Legg til ny person i oppmøteprotokollen. Hvis oppmøte allerede er reigstrert så oppdater i stedet.
		    $queryoppmoete = "INSERT INTO opp (oppid, aktivid, navnid, tilstede, kommentaro) VALUES ('$oppid', '$aktivid', '$row[0]', '$tilstede', '$commento') ON DUPLICATE KEY UPDATE tilstede='$tilstede'";
		    	if($result2 = $spillerbase->query($queryoppmoete)){
		    	}
		    	else{
		    	echo "Noe gikk galt med queryen result2";
		    	}		
		    	
		    	echo "&nbsp";
		    	//Viser radiobokser på skjerm
		    	echo '<td><input type="radio" name="tilstede'.$i.'"';
		    	if (isset($tilstede) && $tilstede=="Ja") echo "checked";
		    	echo 'value="Ja">Til stede';
		    	echo '<input type="radio" name="tilstede'.$i.'"';
		    	if (isset($tilstede) && $tilstede=="Nei") echo "checked";
		    	echo 'value="Nei">Ikke m&oslashtt</td>';
		    	
		    	echo "<td>Notat</td>";
		    		
		    	echo "</tr>";

		}
	}
}	else{
	echo "noe gikk galt med queryen";
}


}

?>



 <input type="submit" name="oppdater" value="Oppdater" id="submit">
</form>


<br /><a href="startmeny.php">Tilbake</a>

</html>
