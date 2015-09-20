<?php

/**
 * @param unknown $date
 * @return string
 * 
 * Funksjon som tar inn en standard MySQL-dato og konverterer det til en standard norsk dato for 
 * bedre lesbarhet.
 *   
 */
function visNorskDato($date){
	$dag = substr($date, 8, 2);
	$ndag = $dag.".";
	$nmnd = "";

	$mnd = substr($date, 5, 2);
	switch ($mnd) {
		case 01:
			$nmnd = "januar";
			break;
		case 02:
			$nmnd = "februar";
			break;
		case 03:
			$nmnd = "mars";
			break;
		case 04:
			$nmnd = "april";
			break;
		case 05:
			$nmnd = "mai";
			break;
		case 06:
			$nmnd = "juni";
			break;
		case 07:
			$nmnd = "juli";
			break;
		case 08:
			$nmnd = "august";
			break;
		case 09:
			$nmnd = "september";
			break;
		case 10:
			$nmnd = "oktober";
			break;
		case 11:
			$nmnd = "november";
			break;
		case 12:
			$nmnd = "desember";
			break;
	}

	$aar = substr($date, 0, 4);
	$norskdato = $ndag . " " . $nmnd . " " . $aar;
	return $norskdato;

}







?>