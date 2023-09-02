<?php
 #AQUI VOCE FAZ O CODIGO DE LOGIN PHP RODAR NA MESMA PÁGINA

 #ABRE UMA VARIAVEL SESSÃO
 session_start();
 $nomeadm = $_SESSION["nomeadm"];

 #SOLICITA O ARQUIVO CONECTADB
 include("../conectadb.php");

#BUSCAR REGISTROS DE MÉDICOS E ATENDENTES

// Função para contar os atendentes ativos
function contarAtendentesAtivos() {
    global $servidor, $banco, $usuario, $senha;

    $link = mysqli_connect($servidor, $usuario, $senha, $banco);

    if (!$link) {
        die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
    }

    $sql = "SELECT COUNT(*) AS total FROM Atendente WHERE aten_ativo = 's'";

    $resultado = mysqli_query($link, $sql);

    if (!$resultado) {
        die("Erro ao executar a consulta: " . mysqli_error($link));
    }

    $row = mysqli_fetch_assoc($resultado);

    mysqli_close($link);

    return $row['total'];
}

// Função para contar os médicos ativos
function contarMedicosAtivos() {
    global $servidor, $banco, $usuario, $senha;

    $link = mysqli_connect($servidor, $usuario, $senha, $banco);

    if (!$link) {
        die("Erro ao conectar ao banco de dados: " . mysqli_connect_error());
    }

    $sql = "SELECT COUNT(*) AS total FROM Medico WHERE med_ativo = 's'";

    $resultado = mysqli_query($link, $sql);

    if (!$resultado) {
        die("Erro ao executar a consulta: " . mysqli_error($link));
    }

    $row = mysqli_fetch_assoc($resultado);

    mysqli_close($link);

    return $row['total'];
}



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
<body class="pag_adm">
 <div class="wrapper-adm-home">
    <nav class="nav">
        <div class="nav-logo">
            <p>CLINICA VITACARE</p>
        </div>

        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="admhome.php" class="link active">Home</a></li>
                <li><a href="contratar.php" class="link">Contratar</a></li>
                <li><a href="admlista.php" class="link">Lista de Funcionários</a></li>
                <li><a href="../avaliacao/listacomentario.php" class="link">Avaliações</a></li>
                <li><a href="logout.php" class="link-sair">Sair</a></li>
            </ul>
        </div>

        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a class="link-sair"><?=strtoupper($nomeadm)?></a></li>
                <li><a href="logout.php" class="link-sair">Sair</a></li>
                

                <?php
                    #ABERTO O PHP PARA VALIDAR SE A SESSÃO DO USUARIO ESTÁ ABERTA
                    #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
                    if($nomeadm != null){
                        ?>
                        <!-- USO DO ELEMENTO HTML COM PHP INTERNO -->
                        
                        <li class="nav-menu-perfil">

                            <?=strtoupper($nomeadm)?>

                        </li>
                        <?php
                        #ABERTURA DE OUTRO PHP PARA CASO FALSE
                    }
                    else{
                        echo"<script>window.alert('USUARIO NÃO AUTENTICADO');
                        window.location.href='admlogin.php';</script>";
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

 
    <!-- CARDS LISTA -->

    <div class="container-card">
    <main class="cards">
        <section class="card contact">
            <div class="icon">
                <img src="../imagem/medicos_icon.png" alt="Contact us.">
            </div>
            <h3>Médicos</h3>
            <span>Registrados</span>
            <p class="card-num"><?php echo contarMedicosAtivos(); ?></p>
            <a href="listaMedico.php"><button>Ver Lista</button></a>
            

        </section>
        <section class="card shop">
            <div class="icon">
                <img src="../imagem/atendentes_icon.png" alt="Shop here.">
            </div>
            <h3>Atendentes</h3>
            <span>Registrados</span>
            <p class="card-num"><?php echo contarAtendentesAtivos(); ?></p>
            <a href="listaAtendente.php"><button>Ver Lista</button></a>

        </section>
    </main>
    </div>

    <!-- FIM CARDS -->


    <main>
        <section class="home">
            <div class="home-text">
                <h4 class="text-h4">Acelere o crescimento da sua equipe</h4>
                <h1 class="text-h1">Contrate novos Funcionários aqui!</h1>


                <a href="contratar.php"><button class="contrata-btn">Contratar</button></a>
            </div>
            <div class="home-img">
                <img src="../imagem/contratacao_icon.png" alt="hamburguer">
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