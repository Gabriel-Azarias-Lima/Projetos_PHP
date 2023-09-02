<?php
#AQUI VOCE FAZ O CODIGO DE LOGIN PHP RODAR NA MESMA PÁGINA

#ABRE UMA VARIAVEL SESSÃO
session_start();
$nomeatendente = $_SESSION["nomeatendente"];

#SOLICITA O ARQUIVO CONECTADB
include("../conectadb.php");



?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../imagem/favicon.ico">
    <link rel="stylesheet" href="../css/style.css">
    <title>Menu Atendente</title>
</head>

<body class="pag_atendente">
    <div class="wrapper-adm-home">
        <nav class="nav">
            <div class="nav-logo">
                <p>CLINICA VITACARE</p>
            </div>

            <div class="nav-menu" id="navMenu">
                <ul>
                    <li><a href="atendentehome.php" class="link active">Home</a></li>
                    <li><a href="listapaciente.php" class="link">Lista Paciente</a></li>
                    <li><a href="agendamento.php" class="link">Agendamento</a></li>
                    <li><a href="logout.php" class="link-sair">Sair</a></li>
                </ul>
            </div>

            <div class="nav-menu" id="navMenu">
                <ul>
                    <li><a class="link-sair"><?= strtoupper($nomeatendente) ?></a></li>
                    <li><a href="logout.php" class="link-sair">Sair</a></li>


                    <?php
                    #ABERTO O PHP PARA VALIDAR SE A SESSÃO DO USUARIO ESTÁ ABERTA
                    #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
                    if ($nomeatendente != null) {
                    ?>
                        <!-- USO DO ELEMENTO HTML COM PHP INTERNO -->

                        <li class="nav-menu-perfil">

                            <a href="AlteraPerfil.php"></a><?= strtoupper($nomeatendente) ?>

                        </li>
                    <?php
                        #ABERTURA DE OUTRO PHP PARA CASO FALSE
                    } else {
                        echo "<script>window.alert('USUARIO NÃO AUTENTICADO');
                        window.location.href='atendentelogin.php';</script>";
                    }
                    #FIM DO PHP PARA CONTINUAR MEU HTML
                    ?>
                </ul>


            </div>


            <div class="nav-button">
                <a href="logout.php" class="nav-button"><button class="btn white-btn" id="loginBtn" onclick="login()">Sair</button></a>
            </div>

            <div class="nav-menu-btn">
                <i class="bx bx-menu" onclick="myMenuFunction()"></i>
            </div>
        </nav>
    </div>

    <!-- Meio da pagina -->





    <main>
        <section class="home_med">
            <div class="home-text">
                <h1 class="text-h1">Bem-vindo</h1>
                <h4 class="text-h4">Realize suas tarefas de atendimento de forma rápida e eficiente.</h4>


                <a href="agendamento.php"><button class="contrata-btn">Agendamento</button></a>
                <a href="listapaciente.php"><button class="contrata-btn">Lista de Pacientes</button></a>
                <a href="listaagendamento.php"><button class="contrata-btn">Lista de agendamento</button></a>
            </div>
        </section>
    </main>



    <!-- FIM Meio da Pagina -->


    <!-- Footer -->

    <!-- FIM Footer -->

    <script>
        function myMenuFunction() {
            var i = document.getElementById("navMenu");
            if (i.className === "nav-menu") {
                i.className += " responsive";
            } else {
                i.className = "nav-menu";
            }
        }
    </script>
    <script>
        var a = document.getElementById("loginBtn");
        var b = document.getElementById("registerBtn");
        var x = document.getElementById("login");
        var y = document.getElementById("register");

        function login() {
            x.style.left = "4px";
            y.style.right = "-520px";
            a.className += " white-btn";
            b.className = "btn";
            x.style.opacity = 1;
            y.style.opacity = 0;
        }

        function register() {
            x.style.left = "-510px";
            y.style.right = "5px";
            a.className = "btn";
            b.className += " white-btn";
            x.style.opacity = 0;
            y.style.opacity = 1;
        }
    </script>





</body>

</html>