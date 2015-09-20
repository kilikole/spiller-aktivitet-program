<?php
header("Content-Type: text/csv");
header("Content-Disposition: attachment; filename=aktivitetsdata.csv");
// Disable caching
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1
header("Pragma: no-cache"); // HTTP 1.0
header("Expires: 0"); // Proxies

// fetch the data
mysql_connect('localhost', 'root', 'phoong8e');
mysql_select_db('spillerbase');



//Skriver ut data fra link i lag.php
if(isset($_GET["lagid"])){
$lagid = $_GET['lagid'];
$tekst = "Oppmøte for lag nr. ";

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

$overskrift = array($tekst, $lagid);

// output the column headings
fputcsv($output, $overskrift);
fputcsv($output, array('Fornavn', 'Etternavn', 'Dato', 'Tilstede'));

$rows = mysql_query("SELECT navn,etternavn, adato, tilstede FROM deltagere, aktivitet, opp WHERE deltagere.id=opp.navnid AND aktivitet.aktivid=opp.aktivid AND lagid = '$lagid'");


//$qrySelDeltager = "SELECT * FROM deltagere WHERE id='$id'";

// loop over the rows, outputting them
while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
}

//Skriver ut data fra link i deltager.php
if(isset($_GET["id"])){
	
$id = $_GET['id'];
$tekst = "Oppmøte for deltager nr. ";

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

$overskrift = array($tekst, $id);

// output the column headings
fputcsv($output, $overskrift);
fputcsv($output, array('Fornavn', 'Etternavn', 'Dato', 'Tilstede'));

$rows = mysql_query("SELECT navn,etternavn, adato, tilstede FROM deltagere, aktivitet, opp WHERE deltagere.id=opp.navnid AND aktivitet.aktivid=opp.aktivid AND id = '$id'");


//$qrySelDeltager = "SELECT * FROM deltagere WHERE id='$id'";

// loop over the rows, outputting them
while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);
}
	