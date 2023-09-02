<?php
#ABRE UMA VARIAVEL SESSÃO
session_start();
#SOLICITA O ARQUIVO CONECTADB
include("../conectadb.php");

#EVENTO APÓS O CLICK NO BOTÃO LOGAR
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];


    #QUERY DE BANCO DE DADOS
    $sql = "SELECT COUNT(pac_id) FROM paciente WHERE pac_email = '$email'
     AND pac_telefone = '$telefone' AND pac_cpf = '$cpf'";

    $retorno = mysqli_query($link, $sql);



    #TODO RETORNO DO BANCO É RETORNADO EM ARRAY EM PHP
    while ($tbl = mysqli_fetch_array($retorno)) {
        $cont = $tbl[0];
    }

    #VERIFICA SE USUARIO EXISTE
    #SE $CONT == 1 ELE EXISTE E FAZ LOGIN
    #SE $CONT == 0 ELE NÃO EXISTE E USUARIO NÃO ESTÁ CADASTRADO
    if ($cont == 1) {
        $sql = "SELECT * FROM paciente WHERE pac_email = '$email'
        AND pac_telefone = '$telefone' AND pac_cpf = '$cpf'";
        $retorno = mysqli_query($link, $sql);

        while ($tbl = mysqli_fetch_array($retorno)) {

            $_SESSION['nomepac'] = $tbl[1];
            $_SESSION['idpac'] = $tbl[0];
            #DIRECIONA USUARIO PARA O ADM
            echo "<script>window.location.href='esqueci_minhasenha.php';</script>";
        }
    } else {
        echo "<script>window.alert('Informações incorretas. Verifique seu e-mail, número de telefone e CPF.');</script>";
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
    <title>Esqueci minha Senha</title>
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
            </ul>
        </div>
        <div class="nav-button">
            <a href="paclogin.php"><button class="btn white-btn" id="loginBtn" onclick="login()">Entrar</button></a>
        </div>
        <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav>
<!----------------------------- Form box ----------------------------------->    
    <div class="form-box_registra">
        
        <!-------------------RECUPERA SENHA -------------------------->
        <form class="login-container" id="login" action="reseta_senha.php" method="post" onsubmit="return validarFormulario();"> <!-- Form é necessario para informar que o elemento representa um formulario que sera preenchido pelo php -->
        <div>
            
                <div class="top">
                    <header>Recuperar Senha</header>
                </div>

                <div class="input-box">
                    <input type="email" class="input-field" placeholder="E-mail" name="email" required><br>
                    <i class="fa-solid fa-envelope"></i>
                </div>

                <div class="input-box">
                    <input type="text" class="input-field" placeholder="Telefone/Celular" id="telefone" name="telefone" maxlength="14" oninput="aplicarFormatacao()" required><br>
                    <i class="fa-solid fa-square-phone"></i>
                </div>

                <div class="input-box">
                    <input type="text" class="input-field" placeholder="CPF" id="cpf" name="cpf" maxlength="14" oninput="formatarCPF()" required> <br>
                    <i class="fa-solid fa-address-card"></i>
                </div>

                <div class="input-box">
                    <input type="submit" class="submit" value="Recuperar Senha" name="login">
                </div>


        </div>
        </form>
    </div>
</div>

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



<script>
        function formatarCPF() {
            const cpfInput = document.getElementsByName("cpf")[0];
            let cpf = cpfInput.value.replace(/\D/g, ''); // Remove todos os não dígitos
            cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4'); // Formatação do CPF
            cpfInput.value = cpf;
        }

        function formatarTelefone(telefone) {
        return telefone.replace(/\D/g, '') // Remove todos os não dígitos
                       .replace(/^(\d{2})(\d{5})(\d{4})$/, '($1) $2-$3'); // Formatação do telefone
    }

        function aplicarFormatacao() {
            const telefoneInput = document.getElementById("telefone");
            telefoneInput.value = formatarTelefone(telefoneInput.value);
        }

        function validarFormulario() {
            // Remover não dígitos do CPF e do telefone antes de enviar o formulário
            const cpfInput = document.getElementsByName("cpf")[0];
            const telefoneInput = document.getElementById("telefone");
            
            cpfInput.value = cpfInput.value.replace(/\D/g, '');
            telefoneInput.value = telefoneInput.value.replace(/\D/g, '');

            // Continuar com o envio do formulário
            return true;
        }
    </script>


</body>

</html>