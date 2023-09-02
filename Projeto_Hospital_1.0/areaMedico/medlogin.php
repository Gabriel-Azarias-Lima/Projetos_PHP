<?php
 #AQUI VOCE FAZ O CODIGO DE LOGIN PHP RODAR NA MESMA PÁGINA

 #ABRE UMA VARIAVEL SESSÃO
 session_start();
 #SOLICITA O ARQUIVO CONECTADB
 include("../conectadb.php");
 #EVENTO APÓS O CLICK NO BOTÃO LOGAR
 if($_SERVER['REQUEST_METHOD'] == 'POST'){
     $nome = $_POST['nome'];
     $senha = $_POST['senha'];
     $sala = $_POST['sala'];

     
     #QUERY DE BANCO DE DADOS
     $sql = "SELECT COUNT(med_id) FROM medico WHERE med_nome = '$nome'
     AND med_senha = '$senha' AND med_ativo = 's'";
     
     $retorno = mysqli_query($link, $sql);

     #TODO RETORNO DO BANCO É RETORNADO EM ARRAY EM PHP
     while($tbl = mysqli_fetch_array($retorno)){
         $cont = $tbl[0];
     }
     
     #VERIFICA SE USUARIO EXISTE
     #SE $CONT == 1 ELE EXISTE E FAZ LOGIN
     #SE $CONT == 0 ELE NÃO EXISTE E USUARIO NÃO ESTÁ CADASTRADO
     if ($cont == 1) {
        $sql = "SELECT * FROM medico WHERE med_nome = '$nome' AND med_senha = '$senha'";
        $_SESSION['nomemed'] = $nome;
        
        // Realiza a consulta SQL para atualizar a coluna med_sala na tabela Medico
        $update_sql = "UPDATE medico SET med_sala = '$sala' WHERE med_nome = '$nome' AND med_senha = '$senha'";
        if (mysqli_query($link, $update_sql)) {
            
        } else {
            echo "Erro na atualização: " . mysqli_error($link);
        }

        echo "<script>window.location.href='medhome.php';</script>";
    } else {
        echo "<script>window.alert('USUARIO OU SENHA INCORRETO');</script>";
    }
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- LINK DOS ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="shortcut icon" href="../imagem/favicon.ico">
    <link rel="stylesheet" href="../css/style.css">
    <title>LOGIN</title>
</head>
<body class="pag_med">
 <div class="wrapper">

<!----------------------------- Form box ----------------------------------->    
    <div class="form-box">
        
        <!------------------- login form -------------------------->
        <form action="medlogin.php" class="login-container" id="login" method="post"> <!-- Form é necessario para informar que o elemento representa um formulario que sera preenchido pelo php -->
        <div>
            <div class="top">
                <!-- <span> Não tem uma conta? <a href="#" onclick="register()">Registre-se</a></span> -->
                <header>Login</header>
            </div>
            <div class="input-box">
                <input type="text" class="input-field" placeholder="Nome" name="nome" required><!-- name conecta html com php -->
                <i class="bx bx-user"></i>
            </div>
            <div class="input-box">
                <input type="password" class="input-field" placeholder="Senha" name="senha" required>
                <i class="bx bx-lock-alt"></i>
            </div>
            <div class="input-box">
                <input type="text" class="input-field" placeholder="Sala" name="sala" required>
                <i class="fa-solid fa-door-open"></i>
            </div>
            <div class="input-box">
                <input type="submit" class="submit" value="Entrar" name="login">
            </div>
        </div>
        </form>
    </div>
</div> 

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