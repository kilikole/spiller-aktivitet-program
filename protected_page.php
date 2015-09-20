<?php

include_once 'includes/db_connect.php';
include_once 'includes/functions.php';

sec_session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Secure Login: Protected Page</title>
        <link rel="stylesheet" href="styles/main.css" />
    </head>
    <body>
        <?php if (login_check($mysqli) == true) : ?>
        <p>Velkommen <?php echo htmlentities($_SESSION['username']); ?>!</p>
            <p>Return to <a href="indexs.php">login page</a></p>
        <?php else : ?>
            <p>
                <span class="error">You are not authorized to access this page.</span> Please <a href="indexs.php">login</a>.
            </p>
        <?php endif; ?>
    </body>
</html>
