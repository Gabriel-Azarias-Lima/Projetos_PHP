<?php
session_start();
require_once("../conectadb.php");

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["password"])) {
    $new_password = $_POST["password"];
    $email = $_SESSION['reset_email'];

    // Atualizar a senha do usuário no banco de dados (SEM CRIPTOGRAFIA)
    $stmt = $link->prepare("UPDATE paciente SET pac_senha = ? WHERE pac_email = ?");
    $stmt->bind_param("ss", $new_password, $email);

    if ($stmt->execute()) {
        echo "<script>window.alert('Senha redefinida com sucesso!');</script>";
        unset($_SESSION['reset_email']);
        echo "<script>window.location.href='paclogin.php';</script>";
    } else {
        echo "<script>window.alert('Ocorreu um erro ao atualizar a senha.');</script>";
    }

    $stmt->close();
}

$link->close();
?>


<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../imagem/favicon.ico">

    <!-- LINK DOS ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../css/style.css">
    <title>Redefinir Senha</title>
</head>

<body class="pag_pac_login">
<div class="wrapper">

    <div class="form-box_registra">
        
        <!-------------------RECUPERA SENHA -------------------------->
        <form class="login-container redefinir" id="login" action="" method="post">
        <div>
            
                <div class="top">
                    <header>Nova Senha</header>
                </div>

                <div class="input-box">
                    <input type="password" class="input-field" placeholder="Nova Senha" name="password" required><br>
                    <i class="bx bx-lock-alt"></i>
                </div>

                <div class="input-box">
                    <input type="submit" class="submit" value="Redefinir Senha" name="login">
                </div>


        </div>
        </form>
    </div>
</div>

</body>

</html>