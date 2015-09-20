<html>

<head>

</head>
<script language="javascript" src="calendar/calendar.js"></script>
</head>
<body>

<br>
<div id="wrapper">

<?php
//variabler for felt i database
$navn = "";
$etternavn = "";
$email = "";
$adresse = "";
$telefon = "";
$alder = "";
$commentd = "";
$commenta = "";
$commentl = "";
$type = "";
$date = "";
$typevalg = "";
$alag = "";
$lagNavn = "";
$kjoenn = "";
$lagAlder = "";
$valgtLag = "";
$commento = "kommentarer";



//Sikkerhetsanstaltning på hver side

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';
include_once 'includes/psl-config.php';
include 'includes.php';

sec_session_start();

if(login_check($mysqli) == true) {
	$brukerNavn = $_SESSION['username'];
	//echo "Lag:";
	if(isset($_GET['valgtLag'])){
		$lagid = $_GET['valgtLag'];
		$qrySelLag = "SELECT * FROM lag WHERE lagid='$lagid'";
		$resSelLag = mysqli_query($mysqli, $qrySelLag);
		while($row = mysqli_fetch_assoc($resSelLag)) {
			$lagNavn = $row["lagnavn"];
			$kjoenn = $row["kjoenn"];
			$alder = $row["alder"];
			$commentl = $row["commentl"];
		}

	}else{
		//Hvis ikke valgtLag er gyldig betyr det at brukeren har kommet dit automatisk med sin bruker.
		$lagNavn = $brukerNavn;
		$qrySelLag = "SELECT * FROM lag WHERE lagnavn='$lagNavn'";
		$resSelLag = mysqli_query($mysqli, $qrySelLag);
		while($row = mysqli_fetch_assoc($resSelLag)) {
			$lagid = $row["lagid"];	
			$kjoenn = $row["kjoenn"];
			$alder = $row["alder"];
			$commentl = $row["commentl"];
		}
	}
	if (($brukerNavn === $lagNavn) OR ($brukerNavn == "admin")){
?>           
		<p>Velkommen <?php echo htmlentities($_SESSION['username']); ?>!</p>
       
<?php 

		if (($_SESSION['username']) == "admin"){
			echo '<a href="admin.php">Tilbake</a>';
		}else{
			echo '<a href="version.php">Tilbake</a>';
		}

		//Brukeren åpner denne, så få query om laget
		//få ut info fra det.

		echo $lagid;
		echo "<br>";
		echo $kjoenn;
		echo "<br>";
		echo $alder;
		echo "<br>";
	
		echo '<br /><a href="export.php?lagid='.$lagid.'">Eksporter m&oslashtehistorikk</a>';
		
		if (isset($_POST['oppdatc'])) {
			$commentl = $_POST['commentl'];
		
			$qryUpdComment = "UPDATE lag SET commentl = '$commentl' WHERE lagid = '$lagid'";
			$resUpdComment = mysqli_query($mysqli, $qryUpdComment) or die ("Error in query: $qryUpdComment. ".mysql_error());
		
		}
		
		
		?>
		<form action="<?php echo 'lag.php?valgtLag='.$lagid.'';?>" method="post" enctype="multipart/form-data">
			<div>
				<input id="import" name="myFile" type="file" accept=".txt, .csv">
				<input value="Importer deltagere fra fil" type="submit">
			</div>
		</form>
		
		<?php 
		//Legg til spillere fra fil hvis bruker trykker på knapp.
		//if (isset($_POST['import'])){
		
			if (!empty($_FILES["myFile"])) {
				$line = 0;
		   	 foreach($_FILES["myFile"] as $file) {
		
		   	 	$line++;
				if($line==1){
				$filename = $file;
				}
		   	 	 	 	
		   	 	if($line==3){   	 	
		 	 	$filepath = $file;
		   	 	}
		 	 	
		   	 }  	
		   	  
		   	 //må fikse ordentlig filepath som korresponderer med hvor filen faktisk ligger på serveren?
			$f = fopen($filepath, "r");	
		//$f = fopen("inndata2.txt", "r");
		$i = 0;
		while(!feof($f)) {
			$data = explode("\t", fgets($f));
			$i++;
			if(!empty($data[0])){
			$inavn = rtrim($data[0]);
			$ietternavn = rtrim($data[1]);
			$itype = rtrim($data[2]);
			
			$qryTestNavnFil = mysqli_query($mysqli, "SELECT * FROM deltagere WHERE navn = '$inavn' AND etternavn = '$ietternavn'");
			
			if (mysqli_num_rows($qryTestNavnFil) > 0) {
				echo "Deltager i rad nr. $i er allerede registrert i databasen.";
				echo "<br>";
			}
			else{
			mysqli_query($mysqli, "INSERT INTO `deltagere` (navn, etternavn, type, lagid)
			VALUES ('$inavn', '$ietternavn', '$itype', '$lagid')") or die(mysql_error());
			echo "Deltager i rad nr. $i lagt til fra fil ";
			echo $filename;
			echo "<br>";
			}
		
			}
			
		}
		
		
		fclose($f);
				}
					
	
		?>
		
		<form method="post" action="<?php echo 'lag.php?valgtLag='.$lagid.'';?>">
		Kommentar: <textarea name="commentl" rows="5" cols="40"><?php echo $commentl;?></textarea>  <br>
		   <input type="submit" name="oppdatc" value="Lagre">
		</form>
		
		
		
		<form method="post" action="<?php echo 'lag.php?valgtLag='.$lagid.'';?>">
		<br><br><br>Legg til ny aktivitet:<br>
		
		Type: <select name="typevalg">
		  <option value="Kamp">Kamp</option>
		  <option value="M&oslash;te">M&oslash;te</option>
		  <option value="Trening">Trening</option>
		</select>
		<br>
		<?php
		
		//get class into the page
		require_once('calendar/classes/tc_calendar.php');
		
		//instantiate klasse og properties
		$myCalendar = new tc_calendar("date1", true, false);
		$myCalendar->setIcon("calendar/images/iconCalendar.gif");
		$myCalendar->setDate(date('d'), date('m'), date('Y'));
		$myCalendar->setPath("calendar/");
		$myCalendar->setYearInterval(2000, 2016);
		$myCalendar->dateAllow('2008-05-13', '2016-03-01');
		$myCalendar->setDateFormat('j F Y');
		$myCalendar->setAlignment('left', 'bottom');
		$myCalendar->startMonday (True);
		$myCalendar->showWeeks (True);
		//$myCalendar->setSpecificDate(array("2011-04-01", "2011-04-04", "2011-12-25"), 0, 'year');
		
		//output calendar
		$myCalendar->writeScript();
		echo '<select name="klokke">';
		for($hours=0; $hours<24; $hours++) // the interval for hours is '1'
			for($mins=0; $mins<60; $mins+=30) // the interval for mins is '30'
		
			echo '<option>'.str_pad($hours,2,'0',STR_PAD_LEFT).':'
					.str_pad($mins,2,'0',STR_PAD_LEFT).'</option>';
		echo '</select>';
		?><br>   
		    <br>
		
		Kommentar: <textarea name="commenta" rows="5" cols="40"><?php echo $commenta;?></textarea>  <br>
		<input type="submit" name="button1" value="Legg til aktivitet"><br><br><br>
		</form>
		
		
		<?php
		
		
		// if id provided, then slett deltagere og oppmøte for de deltagerne
		
		if (isset($_GET['id'])) {
			//Sjekk om bruker har lov å slette id?	
		
				//Hvis bruker trykker slett deltager, så få en tekstboks først.
		
				$querydel = "DELETE FROM deltagere WHERE id = ".$_GET['id'];
				$querydel2 = "DELETE FROM opp WHERE navnid = ".$_GET['id'];
		
				if ($mysqli->query($querydel)) {
					$mysqli->query($querydel2);
					// execute query. if condition kjøres som et vanlig statement.
				} else {
		
					// print error message
					echo "Error in query: $querydel. ".$mysqli->error;
				}
			
		
		}
		
		// if aktvid provided, then slett aktiviteten og oppmøte på de aktivitetene
		
		if (isset($_GET['aktivid'])) {
			$qdelaktiv = "DELETE FROM aktivitet WHERE aktivid = ".$_GET['aktivid'];
			$qdelopp = "DELETE FROM opp WHERE aktivid = ".$_GET['aktivid'];
		
			if ($mysqli->query($qdelaktiv)) {
				// execute query.
				$mysqli->query($qdelopp);
			}else {
		
				// print error message
		
				echo "Error in query: $qdelaktiv. ".$mysqli->error;
			}
		}
		
		
		//Vis aktiviteter
		//echo "Aktiviteter";
		$queryaktiv = "SELECT * FROM aktivitet WHERE alag='$lagid' ORDER BY adato";
		if 	($resultaktiv = $mysqli->query($queryaktiv)){
		
			if ($resultaktiv->num_rows > 0) {
		
		//echo '<h2><a id="aktiviteter">Aktiviteter</a></h2>';
		echo "<table cellpadding=8 border=1>";
		echo "<caption>Aktiviteter</caption>";
		//session_start();
			while($row = $resultaktiv->fetch_array()) {
		
				echo "<tr>";
				//echo "<td>".$row[1]."</td>";
				echo '<td>'.visNorskDato($row[1]).'&nbsp'.substr($row[2], 0, 5).'</td>';
				echo '<td><a href="/aktivitet.php?aktivid='.$row[0].'">'.$row[3].'</a></td>';
				echo '<td><a href="lag.php?valgtLag='.$lagid.'&aktivid='.$row[0].'" onClick=\'return confirm("Dette vil slette valgt aktivitet og deltagelse-historikk.");\'>Slett aktivitet</a></td>';
				echo "</tr>";
				
			}
			}
				
		}	
		
		?>
		
		<form method="post" action="<?php echo 'lag.php?valgtLag='.$lagid.'';?>">
		
		Legg til ny deltager:<br><br>
		
		Fornavn: <input type="text" name="navn" value="<?php if(isset($_POST["navn"])) echo $_POST["navn"]; ?>">  <br> Etternavn: <input type="text" name="etternavn" value="<?php if(isset($_POST["etternavn"])) echo $_POST["etternavn"]; ?>">  <br>
		
		E-post: <input type="text" name="email" value="<?php if(isset($_POST["email"])) echo $_POST["email"]; ?>">  <br>  <br>
		
		Adresse: <input type="text" name="adresse" value="<?php if(isset($_POST["adresse"])) echo $_POST["adresse"]; ?>">  <br>  <br>
		
		Telefon: <input type="text" name="telefon" value="<?php if(isset($_POST["telefon"])) echo $_POST["telefon"]; ?>">  <br>  <br>
		
		Kommentar: <textarea name="commentd" rows="5" cols="40"><?php if(isset($_POST["commentd"])) echo $_POST["commentd"]; ?></textarea>  <br>
		
		Type: 
		<input type="radio" name="type"
		<?php if (isset($type) && $type=="spiller") echo "checked";?>
		value="Spiller">Spiller
		<input type="radio" name="type"
		<?php if (isset($type) && $type=="Trener") echo "checked";?>
		value="Trener">Trener
		   <br><br>
		   <input type="submit" name="submit" value="Legg til deltager">
		   <br><br><br>
		  
		<?php 
		
		//Trykk på knapp, legg til aktivitet
		
		if (isset($_POST['button1']))
		{
			$typevalg = $_POST['typevalg'];
			$commenta = $_POST['commenta'];
		
			//hent dato fra kalender
			$date = isset($_REQUEST["date1"]) ? $_REQUEST["date1"] : "";
			
			$klokke =  $_POST["klokke"];
			echo $klokke;
			
		
			//legge til aktiviteten i databasen
			$queryakt = "INSERT INTO aktivitet (adato, klokke, atype, commenta, alag) VALUES ('$date', '$klokke', '$typevalg', '$commenta', '$lagid')";
			$resultakt = mysqli_query($mysqli, $queryakt) or die ("Error in query: $queryakt. ".mysql_error());
			$aktivid = 	mysqli_insert_id($mysqli);
			echo "<tr>";
			echo '<td>'.visNorskDato($date).'&nbsp'.$klokke.'</td>';	
			echo '<td><a href="/aktivitet.php?aktivid='.$aktivid.'">'.$typevalg.'</a></td>';
			echo '<td><a href="lag.php?valgtLag='.$lagid.'&aktivid='.$aktivid.'" onClick=\'return confirm("Dette vil slette valgt aktivitet og deltagelse-historikk.");\'>Slett aktivitet</a></td>';
			echo "</tr>";
		
		}
			?>
			</form>
		
			<form method="post" action="<?php echo 'lag.php?valgtLag='.$lagid.'';?>">		
			
			<?php 
		
		//Vis deltagere
		
		
			echo '<br>';
		
		
			
			$qrySelDeltagere = "SELECT * FROM deltagere WHERE lagid='$lagid' ORDER by navn";
			$resSelDeltagere = mysqli_query($mysqli, $qrySelDeltagere);
			echo "<table cellpadding=8 border=1>";
			echo "<caption>Deltagere</caption>";
			while($row = $resSelDeltagere->fetch_array()) {	
				echo "<tr>";
				echo '<td><a href="deltager.php?id='.$row[0].'">'.$row[1].'&nbsp;'.$row[2].'</a></td>';
				echo "<td>".$row[6]."</td>";
				echo '<td><a href="lag.php?valgtLag='.$lagid.'&id='.$row[0].'" onClick=\'return confirm("Dette vil slette valgt deltager og deltagelse-historikk.");\'>Slett deltager</a></td>';
		  		echo "</tr>";
			}
		
			
		
		
				
				//Ved trykk på "legg til deltager", så sjekk om input er gyldig og legg til
			
			if (isset($_POST['submit'])) {
				do {
					//Sjekker om navn er skrevet inn
					if (empty($_POST["navn"])) {
						$navnErr = "Navn m&aring; fylles inn!";
						echo $navnErr;
						echo "<br><br>";
						break;
					}
					
					if (empty($_POST["etternavn"])) {
						$navnErr = "Etternavn m&aring; fylles inn!";
						echo $navnErr;
						echo "<br><br>";
						break;
					}
			
					$navn = $_POST["navn"];
					$etternavn = $_POST["etternavn"];
					$email = $_POST["email"];
					$adresse = $_POST["adresse"];
					$telefon = $_POST["telefon"];
			
			
					if (empty($_POST["type"])) {
						//Sjekker om type er skrevet inn
						$typerErr = "Type m&aring; velges!";
						echo $typerErr;
						echo "<br><br>";
						break;
					}
			
					$type = $_POST["type"];
					
					//$alder = $_POST["alder"];
			
					/*
					//Sjekker om det er skrevet inn tall
					if (!is_numeric($alder)) {
						$aldererr = "Skriv inn alder (kun tall)";
						echo $aldererr;
						echo "<br><br>";
						break;
					}*/
						
					$commentd = $_POST["commentd"];
					
					
					//Sjekk om navnet allerede er tatt
					
					$qryTestNavn = "SELECT * FROM deltagere WHERE navn = '$navn' AND etternavn = '$etternavn'";
					$resTestNavn2 = mysqli_query($mysqli, $qryTestNavn);
					 
					if (mysqli_num_rows($resTestNavn2) > 0) {
						echo $navn;
						echo " er allerede registrert i databasen.";
						break;
					}
		
				
					//Legg til ny deltager i databasen og vis på siden
			
					// open connection
					$connection = mysqli_connect($host, $user, $pass) or die ("Unable to connect!");
			
					// select database
					mysqli_select_db($connection, $db) or die ("Unable to select database!");
			
					// create query
					$querylag = "SELECT lagnavn FROM lag WHERE lagid='$lagid'";
		
					echo $type;
					$query = "INSERT INTO deltagere (navn, etternavn, email, adresse, telefon, type, lagid, commentd) VALUES ('$navn', '$etternavn', '$email', '$adresse', '$telefon', '$type', '$lagid', '$commentd')";
		
					// execute query
					$result = mysqli_query($connection, $query) or die ("Error in query: $query. ".mysql_error());
					$id = mysqli_insert_id($connection);
			
					//henter ut et objekt fra mysql, fetcher det til et array, henter ut lagnavn derfra
					$lagobjekt =  mysqli_query($connection, $querylag) or die ("Error in query: $query. ".mysql_error());
					$lagarray = mysqli_fetch_assoc($lagobjekt);
					$lagNavn = $lagarray['lagnavn'];
			
		
					// close connection
					//mysqli_close($connection);
			
					echo "<tr>";
					echo '<td><a href="deltager.php?id='.$id.'">'.$navn.'&nbsp;'.$etternavn.'</a></td>';
					echo "<td>".$type."</td>";
					echo '<td><a href="lag.php?valgtLag='.$lagid.'&id='.$id.'" onClick=\'return confirm("Dette vil slette valgt deltager og deltagelse-historikk.");\'>Slett deltager</a></td>';	
					echo "</tr>";
			
				} while (0);
			
			}
			
			echo '<br>';
			echo '<br>';

	}else{
	?>
			</div> 
			<p>
			<span class="error">Du er ikke autorisert for denne siden.</span> <a href="start.php">Logg inn</a>
			 </p>
	<?php 
	}

}	
	
	
?>
</form>
</body>
</html>
