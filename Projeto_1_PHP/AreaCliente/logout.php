<?php

    session_start();
    session_destroy();
    header("Location: loja.php"); // quando eu logar ele vai enviar para loja.php
    exit

?>