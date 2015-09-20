<html>

<head>

</head>
</head>
<body>
<div id="wrapper">
<?php 
include_once 'includes/psl-config.php';
include_once 'includes/functions.php';
include_once 'includes/db_connect.php';

//Brukeren åpner denne, så få info-query om deltageren
//få ut info fra det.

//echo "Deltager:"; 
$id = $_GET['id'];
//echo $id;
echo "<br>";

sec_session_start();

$lagBruker = $_SESSION['username'];

$qryBrukerId = mysqli_query($mysqli, "SELECT lagid FROM lag WHERE lagnavn='$lagBruker'");
while($rad = mysqli_fetch_assoc($qryBrukerId)) {
	$brukerId = $rad["lagid"];
}

//Henter ut deltager basert på ID. Sjekker også om brukeren har tilgang til nevnte spiller, dvs. er på laget til brukeren.
$qrySelDeltager = mysqli_query($mysqli, "SELECT * FROM deltagere WHERE id='$id' AND lagid='$brukerId'");

if((login_check($mysqli) == true) AND (mysqli_num_rows($qrySelDeltager) > 0)) {

while($row = mysqli_fetch_assoc($qrySelDeltager)) {
$navn = $row["navn"];
echo $navn;
echo "&nbsp";

$etternavn = $row["etternavn"];
echo $etternavn;
echo "<br>";

$type = $row["type"];
echo $type;
echo "<br>";

$lagid = $row["lagid"];
//echo $lagid;
echo "<br>";

echo '<br /><a href="export.php?id='.$id.'">Eksporter m&oslashtehistorikk</a>';


$commentd = $row["commentd"];
echo "<br>";

$lagnavn = mysqli_query($mysqli, "SELECT lagnavn FROM lag WHERE lagid='$lagid'");
while($row = mysqli_fetch_assoc($lagnavn)) {
	$navnlag = $row["lagnavn"];
	echo $navnlag;
}


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


//echo '<br /><a href="lag.php">Tilbake</a>';
echo '<td><a href="/lag.php?valgtLag='.$lagid.'">Tilbake</a></td>';


echo '<br>';

}else{
?>

	</div> 
	            <p>
                <span class="error">Du er ikke autorisert for denne siden.</span> <a href="start.php">Logg inn</a>
            </p>
<?php 
} 
?>



</html>
