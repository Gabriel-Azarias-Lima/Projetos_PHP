<?php
 #AQUI VOCE FAZ O CODIGO DE LOGIN PHP RODAR NA MESMA PÁGINA

 #ABRE UMA VARIAVEL SESSÃO
 session_start();
 $nomemed = $_SESSION["nomemed"];

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
    <title>Home</title>
</head>
<body class="pag_med">
 <div class="wrapper-adm-home">
    <nav class="nav">
        <div class="nav-logo">
            <p>CLINICA VITACARE</p>
        </div>

        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="medhome.php" class="link active">Home</a></li>
                <li><a href="medlista.php" class="link">Lista de Pacientes</a></li>
                <li><a href="logout.php" class="link-sair">Sair</a></li>
            </ul>
        </div>

        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a class="link-sair"><?=strtoupper($nomemed)?></a></li>
                <li><a href="logout.php" class="link-sair">Sair</a></li>
                

                <?php
                    #ABERTO O PHP PARA VALIDAR SE A SESSÃO DO USUARIO ESTÁ ABERTA
                    #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
                    if($nomemed != null){
                        ?>
                        <!-- USO DO ELEMENTO HTML COM PHP INTERNO -->
                        
                        <li class="nav-menu-perfil">
                            <?=strtoupper($nomemed)?>
                        </li>
                        <?php
                        #ABERTURA DE OUTRO PHP PARA CASO FALSE
                    }
                    else{
                        echo($sql);
                        echo"<script>window.alert('USUARIO NÃO AUTENTICADO');
                        window.location.href='medlogin.php';</script>";
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


<!-- BUSCA OS FUNCIONARIOS REGISTRADOS -->


    <main>
        <section class="home_med">
            <div class="home-text_med">
                <h4 class="text-h4_med">Lista de Pacientes de Hoje</h4>
                <h1 class="text-h1_med">Veja a Lista de Pacientes para Hoje!</h1>


                <a href="listaPaciente.php"><button class="contrata-btn_med">Ver Lista</button></a>
            </div>
            <div class="home-img_med">
                <img src="../imagem/icon_medico.png">
            </div>
        </section>
    </main>



<!-- FIM Meio da Pagina -->


<!-- Footer -->

<!-- FIM Footer -->

<script>
   
   function myMenuFunction() {
    var i = document.getElementById("navMenu");
    if(i.className === "nav-menu") {
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