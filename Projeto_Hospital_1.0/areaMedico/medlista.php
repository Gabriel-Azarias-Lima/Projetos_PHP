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
    <!-- LINK DOS ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Listas</title>
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


<!-- MEIO DA PAGINA -->
<div class="container-contrata">
 <div class="card-container">
    <a href="listaAgendados.php">
    <div class="box-contratar" style="--clr:#3E8AFF;">
        <div class="content-contratar">
            <div class="icon-contratar"><i class="fa-solid fa-clipboard-list"></i></div>
            <div class="text-contratar">
                <h3>Agendados do Mês</h3>
                <p>Veja os Pacientes do Mês</p>
            </div>
        </div>
    </div>
    </a>


    <a href="listaPaciente.php">
    <div class="box-contratar" style="--clr:#fc5f64;">
        <div class="content-contratar">
            <div class="icon-contratar"><i class="fa-solid fa-tv"></i></div>
            <div class="text-contratar">
                <h3>Chamar Pacientes</h3>
                <p>Chame os Pacientes presentes</p>
            </div>     
        </div>
    </div>
    </a>
    
 </div>
 </div>

<!-- FIM MEIO -->



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