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
     $sql = "SELECT COUNT(pac_id) FROM paciente WHERE pac_nome = '$nome'
     AND pac_senha = '$senha'";
     
     $retorno = mysqli_query($link, $sql);

    

     #TODO RETORNO DO BANCO É RETORNADO EM ARRAY EM PHP
     while($tbl = mysqli_fetch_array($retorno)){
         $cont = $tbl[0];
     }
     
     #VERIFICA SE USUARIO EXISTE
     #SE $CONT == 1 ELE EXISTE E FAZ LOGIN
     #SE $CONT == 0 ELE NÃO EXISTE E USUARIO NÃO ESTÁ CADASTRADO
     if($cont == 1){
        $sql = "SELECT * FROM paciente WHERE pac_nome = '$nome' 
        AND pac_senha = '$senha'"; 
        $retorno = mysqli_query($link, $sql);

        while($tbl = mysqli_fetch_array($retorno)){

            $_SESSION['nomepac'] = $tbl[1];
            $_SESSION['idpac'] = $tbl[0];
            #DIRECIONA USUARIO PARA O ADM
            echo"<script>window.location.href='pachome.php';</script>";
        }

        
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

    <!-- LINK DOS ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../css/style.css">
    <title>LOGIN</title>
</head>

<body class="pag_pac_login">
 <div class="wrapper">
    <nav class="nav">
        <div class="nav-logo">
            <p>CLINICA VITACARE</p>
        </div>
        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="pachomeSemLogin.php" class="link active">Home</a></li>
                <li><a href="agendamentos.php" class="link">Agendamentos</a></li>
                <li><a href="trabalheconosco.php" class="link">Trabalher Conosco</a></li>
                <li><a href="../avaliacao/avaliacao_semLogin.php" class="link">Avaliação</a></li>
            </ul>
        </div>
        <div class="nav-button">
            <button class="btn white-btn" id="loginBtn" onclick="login()">Entrar</button>
            <button class="btn" id="registerBtn" onclick="register()">Registrar</button>
        </div>
        <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav>
<!----------------------------- Form box ----------------------------------->    
    <div class="form-box_registra">
        
        <!------------------- login form -------------------------->
        <form action="paclogin.php" class="login-container" id="login" method="post"> <!-- Form é necessario para informar que o elemento representa um formulario que sera preenchido pelo php -->
        <div>
            <div class="top">
                <span> Não tem uma conta? <a href="#" onclick="register()">Registre-se</a></span>
                <header>Login</header>
            </div>
            <div class="input-box">
                <input type="text" class="input-field" placeholder="Nome" name="nome">
                <i class="bx bx-user"></i>
            </div>
            <div class="input-box">
                <input type="password" class="input-field" placeholder="Senha" name="senha">
                <i class="bx bx-lock-alt"></i>
            </div>
            <div class="input-box">
                <input type="submit" class="submit" value="Entrar" name="login">
            </div>
            <div class="two-col">
                <div class="two">
                    <label><a href="esqueci_minhasenha.php">Esqueceu sua senha?</a></label>
                </div>
            </div>
        </div>
        </form>

        <!------------------- registration form -------------------------->
        <form action="pacRegistrar.php" class="register-container" id="register" method="post"> <!-- Form é necessario para informar que o elemento representa um formulario que sera preenchido pelo php -->
        <div>
            <div class="top">
                <header>Registre-se</header>
            </div>

            <div class="two-forms">

            </div>

            <div class="input-box">
                <input type="text" class="input-field" placeholder="Nome" name="nome">
                <i class="bx bx-user"></i>
            </div>

            <div class="input-box">
                <input type="password" class="input-field" placeholder="Senha" name="senha">
                <i class="bx bx-lock-alt"></i>
            </div>

            <div class="input-box">
                <input type="text" class="input-field" placeholder="E-mail" name="email">
                <i class="fa-solid fa-envelope"></i>
            </div>

            
            <div class="input-box">
            <input type="text" class="input-field" placeholder="CPF" name="cpf" id="cpf"  maxlength="14" oninput="formatarCPF()" required>
                <i class="fa-solid fa-address-card"></i>
            </div>

            <div class="two-forms">
            <div class="input-box">
                <input type="date" class="input-field" placeholder="Data de Nascimento" name="datanasc">
                <i class="fa-regular fa-calendar-days"></i>
            </div>
            

            <div class="input-box">
            <input type="tel" name="telefone" placeholder="Telefone" id="telefone" class="input-field" maxlength="14" required oninput="aplicarFormatacao()">
                <i class="fa-solid fa-square-phone"></i>
            </div>
            </div>

            <div class="input-box">
                <input type="text" class="input-field" placeholder="Cidade" name="cidade">
                <i class="fa-regular fa-building"></i>
            </div>

            <div class="input-box">
                <input type="text" class="input-field" placeholder="Endereco" name="endereco">
                <i class="fa-solid fa-location-dot"></i>
            </div>

            <div class="input-box">
                <input type="text" class="input-field" placeholder="Numero" name="numero">
                <i class="fa-solid fa-house-chimney"></i>
            </div>

            <div class="input-box">
                <input type="submit" class="submit" value="Resgistrar" name="registrar">
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


 <!-- VALIDA CPF  -->

 <script>
        function formatarCPF() {
            const cpfInput = document.getElementsByName("cpf")[0];
            let cpf = cpfInput.value.replace(/\D/g, ''); // Remove todos os não dígitos
            cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4'); // Formatação do CPF
            cpfInput.value = cpf;
        }

        function validarFormatoCPF(cpf) {
            return /^\d{3}\.\d{3}\.\d{3}-\d{2}$/.test(cpf);
        }
    </script>

    <!-- FIM VALIDA CPF -->


    <!-- VALIDA TELEFONE -->

    <script>
function formatarTelefone(telefone) {
    telefone = telefone.replace(/\D/g, ''); // Remove todos os não dígitos
    if (telefone.length === 11) {
        return '(' + telefone.substring(0, 2) + ')' + telefone.substring(2, 7) + '-' + telefone.substring(7);
    } else {
        return telefone;
    }
}

function aplicarFormatacao() {
    const telefoneInput = document.getElementById("telefone");
    telefoneInput.value = formatarTelefone(telefoneInput.value);
}
</script>

<!-- VALIDA TELEFONE -->
</body>
</html>