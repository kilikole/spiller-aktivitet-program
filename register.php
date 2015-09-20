<?php

include_once 'includes/register.inc.php';
include_once 'includes/functions.php';

sec_session_start();

if((login_check($mysqli) == true) && ($_SESSION['username'] == "admin")){


?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Registrer ny bruker</title>
        <script type="text/JavaScript" src="js/sha512.js"></script> 
        <script type="text/JavaScript" src="js/forms.js"></script>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <!-- Registration form to be output if the POST variables are not
        set or if the registration script caused an error. -->
        <h1>Registrer ny bruker</h1>
        <?php
        if (!empty($error_msg)) {
            echo $error_msg;
        }
        ?>
        <ul>
            <li>Passord med minst 6 karakterer</li>
            <li>Passord m&aring inneholde
                <ul>
                    <li>minst en stor bokstad (A..Z)</li>
                    <li>minst en liten bokstav (a..z)</li>
                    <li>minst et tall (0..9)</li>
                </ul>
            </li>
        </ul>
        <form method="post" name="registration_form" action="<?php echo esc_url($_SERVER['PHP_SELF']); ?>"><br>
        Brukernavn m&aring v&aeligre det samme som navn p&aring laget brukeren skal trene.<br>
            Brukernavn: <input type='text' name='username' id='username' /><br>
            Email: <input type="text" name="email" id="email" /><br>
            Passord: <input type="password"
                             name="password" 
                             id="password"/><br>
            Bekreft passord: <input type="password" 
                                     name="confirmpwd" 
                                     id="confirmpwd" /><br>
            <input type="button" 
                   value="Registrer" 
                   onclick="return regformhash(this.form,
                                   this.form.username,
                                   this.form.email,
                                   this.form.password,
                                   this.form.confirmpwd);" /> 
        </form>
        <p>Return to the <a href="admin.php">admin-meny</a>.</p>
      
      </form>
      
<?php        
}else{
?>

	</div> 
	            <p>
                <span class="error">Du er ikke autorisert for denne siden.</span> <a href="start.php">Logg inn</a>
            </p>
        <?php 




} ?>
       



    </body>
</html>
