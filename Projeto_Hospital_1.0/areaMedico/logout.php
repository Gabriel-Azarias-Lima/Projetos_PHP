<?php

    session_start();
    session_destroy();
    header("Location: medlogin.php");
    exit

?>