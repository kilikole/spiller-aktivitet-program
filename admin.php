<html>

<head>
<meta charset="UTF-8">
<title>Administrator-meny</title>
<link rel="stylesheet" href="styles/main.css" />
</head>

<body>
<div id="wrapper">

<?php
include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/psl-config.php';

sec_session_start();

if((login_check($mysqli) == true) && ($_SESSION['username'] == "admin")){

 ?>
        <p><?php echo htmlentities($_SESSION['username']); ?></p>
            <p><a href="start.php">Tilbake</a></p><br>

Administrator-meny  <br><br>

<?php

	//variabler for felt i database
	$commentl = "";
	$type = "";
	$date = "";
	$typevalg = "";
	$alag = "";
	$lagNavn = "";
	$kjoenn = "";
	$lagAlder = "";
	$valgtLag = "";


	$check = "";
	$navnErr = $emailErr = $typeErr = $ageErr = "";

?>

<form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">

Legg til nytt lag:<br><br>

Navn: <input type="text" name="lagNavn" value="<?php if(isset($_POST["lagNavn"])) echo $_POST["lagNavn"]; ?>"> 

 <br><br>

<input type="radio" name="kjoenn"
<?php if (isset($kjoenn) && $kjoenn=="Gutter") echo "checked";?>
value="Gutter">Gutter
<input type="radio" name="kjoenn"
<?php if (isset($kjoenn) && $kjoenn=="Jenter") echo "checked";?>
value="Jenter">Jenter<br>
Alder: <input type="number" name="lagAlder" value="<?php if(isset($_POST["lagAlder"])) echo $_POST["lagAlder"]; ?>"> Kommentar: <textarea name="commentl" rows="5" cols="40"><?php if(isset($_POST["commentl"])) echo $_POST["commentl"]; ?></textarea> <br><br>

<input type="submit" name="leggTilLag" value="Legg til lag">
<br><br>

        <p><a href="register.php">Registrer ny bruker</a></p><br><br><br>
<?php

	//Connection med databasen
	$mysqli = new mysqli($host, $user, $pass, $db);

	// check for connection errors

	if (mysqli_connect_errno()) {

		die("Unable to connect!");

	}



	// if lagid is provided, then delete that record.

	if (isset($_GET['lagid'])) {
		$qryDelLag = "DELETE FROM lag WHERE lagid = ".$_GET['lagid'];

		if ($mysqli->query($qryDelLag)) {
		}else {
			// print error message
			echo "Error in query: $qdelaktiv. ".$mysqli->error;
		}
	}
	
	
	//Skriv ut alle lag

	echo "<table cellpadding=8 border=1>";
	//hent alle
	$qryLag = "SELECT * FROM lag ORDER BY lagnavn";
		 
	// Utfører query, henter ut deltagere med tilhørende lag

	if ($result = $mysqli->query($qryLag)) {
		 
	// see if any rows were returned
			 
		if ($result->num_rows > 0) {
			 
		// print them one after another
			while($row = $result->fetch_array()) {								
				echo "<tr>";
				echo '<td><a href="/lag.php?valgtLag='.$row[0].'">'.$row[1].'</a></td>';
				echo "<td>".$row[2]."</td>";
				echo "<td>".$row[3]."</td>";
				//echo '<td><a href="/lag.php?valgtLag='.$row[0].'#deltagere">Vis deltagere</a></td>';
				//echo '<td><a href="/lag.php?valgtLag='.$row[0].'#aktiviteter">Vis aktiviteter</a></td>';
				echo "<td><a href=".$_SERVER['PHP_SELF']."?lagid=".$row[0]." onClick=\"return confirm('Dette vil slette valgt lag, men ikke aktivitetene og deltagerne til dette laget.');\">Slett lag</a></td>";
				echo "</tr>";
			}
		}
	}

	//Hvis bruker har trykket på valgt lag, skriv ut deltagere på skjerm.		
	if (!empty($_GET['valgtLag'])) {
		echo "<table cellpadding=10 border=1>";
		$valgtLag = $_GET['valgtLag'];
		echo "Deltagere tilh&oslashrende lag nr. ";
		echo $valgtLag;
		$qrySelDeltagere = "SELECT * FROM deltagere WHERE lagid='$valgtLag'";
		$resSelDeltagere = mysqli_query($mysqli, $qrySelDeltagere);
		while($row = $resSelDeltagere->fetch_array()) {	
			echo "<tr>";
			echo "<td>".$row[1]."</td>";
			echo "<td>".$row[2]."</td>";
        	echo "<td><a href=".$_SERVER['PHP_SELF']."?id=".$row[0]." onClick=\"return confirm('Dette vil slette valgt deltager');\">Slett deltager</a></td>";
			echo "</tr>";
		}
	}			    

   
    //Trykk på knapp, legg til lag
    
    if (isset($_POST['leggTilLag']))
    {
    	do{
    		if (empty($_POST["lagNavn"])) {
    			$navnErr = "Navn m&aring; fylles inn!";
    			echo $navnErr;
    			echo "<br><br>";
    			break;
    		}    	
    	
    	
    		if (empty($_POST["kjoenn"])) {
    			//Sjekker om type er skrevet inn
    			$typerErr = "Kj&oslashnn m&aring; velges";
    			echo $typerErr;
    			echo "<br><br>";
    			break;
    		}
    	
   	
    		//Sjekker om det er skrevet inn tall
    		if (!is_numeric($_POST["lagAlder"])) {
    			$aldererr = "Skriv inn alder (kun tall)";
    			echo $aldererr;
    			echo "<br><br>";
    			break;
    		}
    	    			
    		$lagNavn = $_POST['lagNavn'];
    		$kjoenn = $_POST['kjoenn'];
    		$lagAlder = $_POST['lagAlder'];
    		$commentl = $_POST['commentl']; 

       
    		//legge til laget i databasen
    	
			$qryTestNavn = "SELECT * FROM lag WHERE lagnavn = '$lagNavn'";
    		$resTestNavn2 = mysqli_query($mysqli, $qryTestNavn);
    	
    		if (mysqli_num_rows($resTestNavn2) > 0) {
    			echo $lagNavn;
    			echo " er allerede registrert i databasen. Velg et annet navn p&aring laget.";
    		}else{
	    		$qryInsLag = "INSERT INTO lag (lagnavn, kjoenn, alder, commentl) VALUES ('$lagNavn', '$kjoenn', '$lagAlder', '$commentl')";   	
	    	
	    		$resInsLag = mysqli_query($mysqli, $qryInsLag) or die ("Error in query: $qryInsLag. ".mysql_error());
	    		$nyLagId = mysqli_insert_id($mysqli);
	    	
	    		echo "<tr>";
		    	echo '<td><a href="/lag.php?valgtLag='.$nyLagId.'">'.$lagNavn.'</a></td>';
		    	echo "<td>".$kjoenn."</td>";
	    		echo "<td>".$lagAlder."</td>";
				//echo '<td><a href="/lag.php?valgtLag='.$nyLagId.'#deltagere">Vis deltagere</a></td>';
				//echo '<td><a href="/lag.php?valgtLag='.$nyLagId.'#aktiviteter">Vis aktiviteter</a></td>';
	    		echo "<td><a href=".$_SERVER['PHP_SELF']."?lagid=".$nyLagId." onClick=\"return confirm('Dette vil slette valgt lag, men ikke aktivitetene og deltagerne til dette laget');\">Slett lag</a></td>";  	
	    		echo "</tr>";
    		}
    
    	} while(0);
    }
    
}else{
?>
</form>
	</div> 
	            <p>
                <span class="error">Du er ikke autorisert for denne siden.</span> <a href="start.php">Logg inn</a>
            </p>
        <?php 




} ?>
        
        
        
        
	
	</body>

</html>