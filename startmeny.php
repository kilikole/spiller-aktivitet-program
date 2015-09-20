<html>

<head>
<link rel="stylesheet" href="stil.css" />
</head>

<body>

<?php

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


// server access

$host = "localhost";
$user = "root";
$pass = "phoong8e";
$db = "spillerbase";


$check = "";
$navnErr = $emailErr = $typeErr = $ageErr = "";

//Connection med databasen
$mysqli = new mysqli($host, $user, $pass, $db);

// check for connection errors

if (mysqli_connect_errno()) {

	die("Unable to connect!");

}

//Hvis bruker trykker på knappen
//Skriv ut alle lag.

echo "Lag:";
echo "<table cellpadding=10 border=1>";
//hent alle
$qryLag = "SELECT * FROM lag ORDER by lagnavn";
		 
// Utfører query, henter ut deltagere med tilhørende lag
		 
if ($result = $mysqli->query($qryLag)) {
		 
	// see if any rows were returned
			 
	if ($result->num_rows > 0) {
			 
		// print them one after another
		while($row = $result->fetch_array()) {								
		echo "<tr>";
		//echo "<td><a href=".$_SERVER['PHP_SELF']."?valgtLag=".$row[0].">$row[1]</a></td>";
		echo '<td><a href="/brukerlag.php?valgtLag='.$row[0].'">'.$row[1].'</a></td>';
		echo "<td>".$row[2]."</td>";
		echo "<td>".$row[3]."</td>";
		echo "</tr>";
		}
	}


//Hvis bruker valgt lag, skriv ut deltagere på skjerm.		
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
        echo "</tr>";
		}
	}
}		
			    

if (isset($_POST['visDeltagere'])){
// Hent ut alle deltagere
 // query to get records.
$querydel = "SELECT * FROM deltagere";

// execute query
if ($result = $mysqli->query($querydel)) {

    // see if any rows were returned

    if ($result->num_rows > 0) {

        // print them one after another   

        echo "<table cellpadding=10 border=1>";
       
        while($row = $result->fetch_array()) {
        	
        	$lagquery = "SELECT lagnavn FROM lag WHERE lagid= ".$row[3];
        	$objektlag =  mysqli_query($mysqli, $lagquery) or die ("Error in query: $lagquery. ".mysql_error());
        	$arraylag = mysqli_fetch_assoc($objektlag);
        	$navnlag = $arraylag['lagnavn'];
            echo "<tr>";
            echo '<td><a href="/deltager.php?id='.$row[0].'">'.$row[1].'</a></td>';
            echo "<td>".$row[2]."</td>";
            echo "<td>".$navnlag."</td>";
            echo "</tr>";
        }

    }    
                    
        //free result set memory
    	//$result->close();

}

else {

    // print error message
    echo "Error in query: $querydel. ".$mysqli->error;

}
	}

// close connection
//$mysqli->close();

    
    


?>
	
	</body>

</html>