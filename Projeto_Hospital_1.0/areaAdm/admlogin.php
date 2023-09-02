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

     
     #QUERY DE BANCO DE DADOS
     $sql = "SELECT COUNT(adm_id) FROM administracao WHERE adm_nome = '$nome'
     AND adm_senha = '$senha'";
     
     $retorno = mysqli_query($link, $sql);

     

     #TODO RETORNO DO BANCO É RETORNADO EM ARRAY EM PHP
     while($tbl = mysqli_fetch_array($retorno)){
         $cont = $tbl[0];
     }
     
     #VERIFICA SE USUARIO EXISTE
     #SE $CONT == 1 ELE EXISTE E FAZ LOGIN
     #SE $CONT == 0 ELE NÃO EXISTE E USUARIO NÃO ESTÁ CADASTRADO
     if($cont == 1){
         $sql = "SELECT * FROM administracao WHERE adm_nome = '$nome' 
         AND adm_senha = '$senha'"; 

         $_SESSION['nomeadm'] = $nome;
         
         #DIRECIONA USUARIO PARA O ADM
         echo"<script>window.location.href='admhome.php';</script>";
     }
     else{
         echo"<script>window.alert('USUARIO OU SENHA INCORRETO');</script>";
     }
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
    <title>LOGIN</title>
</head>
<body class="pag_adm">
 <div class="wrapper">

<!----------------------------- Form box ----------------------------------->    
    <div class="form-box">
        
        <!------------------- login form -------------------------->
        <form action="admlogin.php" class="login-container" id="login" method="post"> <!-- Form é necessario para informar que o elemento representa um formulario que sera preenchido pelo php -->
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
                <input type="submit" class="submit" value="Entrar" name="login">
            </div>
            <div class="two-col">
                <div class="two">
                    <label><a href="RecuperaSenha.php">Esqueceu sua senha?</a></label>
                </div>
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