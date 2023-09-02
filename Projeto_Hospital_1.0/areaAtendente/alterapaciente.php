<?php
include("../conectadb.php");

session_start();
$nomeadm = $_SESSION["nomeatendente"]; // FAZ SEU NOME VIR NA CESSÃO

# TRAZ DADOS DO BANCO PARA COMPLETAR OS CAMPOS
$id = $_GET['id'];
$sql = "SELECT * FROM paciente WHERE pac_id = '$id'";
$retorno = mysqli_query($link, $sql);

# PREENCHENDO O ARRAY SEMPRE



while($tbl = mysqli_fetch_array($retorno)){
    $id = $tbl [0];
    $nome = $tbl[1];
    $email = $tbl[3];
    $cpf = $tbl[4];
    $datanasc = $tbl[5];
    $telefone = $tbl[6];
    $cidade = $tbl[7];
    $endereco = $tbl[8];
    $numero = $tbl[9];
    $ativo = $tbl[11];
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $id = $_POST['id'];
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $datanasc = $_POST['datanasc'];
    $telefone = preg_replace('/\D/', '', $_POST['telefone']); // Remove caracteres não dígitos
    $cidade = $_POST['cidade'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $ativo = $_POST['ativo'];
    

    $sql = "UPDATE paciente SET pac_nome='$nome', pac_email='$email', pac_cpf='$cpf' , pac_datanasc='$datanasc', pac_telefone='$telefone', pac_cidade='$cidade', pac_endereco='$endereco', pac_numero='$numero', pac_ativo='$ativo' WHERE pac_id= $id";
    mysqli_query($link, $sql);

    echo"<script>window.alert('PACIENTE ALTERADO COM SUCESSO!');</script>";
    echo"<script>window.location.href='listapaciente.php';</script>";
}

?>
<!-----------------------daqui pra baixo edita------------------------------------>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../imagem/favicon.ico">

    <link rel="stylesheet" href="../css/style_formulario_aten.css">

    <!-- LINK DOS ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Menu Atendente</title>
</head>
<body class="pag_formulario">

<!-- MEIO DA PAGINA -->

<!-- INICIO FORMULARIO -->

<div class="form_box">

        <form action="alterapaciente.php" method="post" onsubmit="removerFormatacaoCPF()">
            <fieldset>
                <legend><b>Altera Paciente</b></legend>
                <br>

                <input type="hidden" name="id" value="<?=$id?>">

                <div class="form_inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" value="<?=$nome?>" required>
                    <label for="nome" class="labelInput">Nome completo</label>
                </div>

                <br><br>

                
                <div class="form_inputBox">
                    <input type="text" name="cpf" id="cpf" class="inputUser" maxlength="14" oninput="formatarCPF()" value="<?=$cpf?>" required>
                    <label for="cpf" class="labelInput">CPF</label>
                </div> 

                <br><br>

                <div class="form_inputBox">
                    <input type="text" name="email" id="email" class="inputUser" value="<?=$email?>" required>
                    <label for="email" class="labelInput">E-mail</label>
                </div>

                <br><br>


                <br><br>

                <div class="conteiner_input">
                
                <div class="input_especial">
                    <p>Data de Nascimento</p>
                    <input type="date" name="datanasc" id="datanasc" value="<?=$datanasc?>" required>
                </div>
                

                </div>                         

                <br><br>

                <div class="form_inputBox">
                    <input type="tel" name="telefone" id="telefone" class="inputUser" maxlength="14" value="<?=$telefone?>" oninput="formatarTelefone(this)" required>
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>

                <br><br>

                <div class="form_inputBox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" value="<?=$cidade?>" required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>

                <br><br>

                <div class="form_inputBox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" value="<?=$endereco?>" required>
                    <label for="endereco" class="labelInput">Endereço</label>
                </div>

                <br><br>

                <div class="form_inputBox">
                    <input type="text" name="numero" id="numero" class="inputUser" value="<?=$numero?>" required>
                    <label for="numero" class="labelInput">Numero</label>
                </div>

                <br><br>

                <div class="container_radio_label">
                    <div class="form_inputBox">
                        <label class="radio_label">
                            ATIVO<br>
                            <input type="radio" name="ativo" value="s" <?=$ativo == "s" ? "checked" : ""?>>
                        </label>
                    </div>

                    <div class="form_inputBox">
                        <label class="radio_label">
                        INATIVO<br>
                        <input type="radio" name="ativo" value="n" <?=$ativo == "n" ? "checked" : ""?>>
                        </label>
                    </div>
                </div>

                <br><br>
                
                <input type="submit" name="submit" id="submit" value="Salvar">

            </fieldset>
        </form>

        <div class="container_btn_voltar">
            <a href="listapaciente.php"><button class="btn_voltar">Voltar</button></a>
        </div>

</div>

<!-- VALIDA CPF  -->

<script>
    function formatarCPF() {
        const cpfInput = document.getElementsByName("cpf")[0];
        let cpf = cpfInput.value.replace(/\D/g, ''); // Remove todos os não dígitos
        cpf = cpf.replace(/(\d{3})(\d{3})(\d{3})(\d{2})/, '$1.$2.$3-$4'); // Formatação do CPF
        cpfInput.value = cpf; // Formata visualmente para exibição
    }
    
    function removerFormatacaoCPF() {
        const cpfInput = document.getElementsByName("cpf")[0];
        cpfInput.value = cpfInput.value.replace(/\D/g, ''); // Remove todos os não dígitos
    }
</script>

    <!-- FIM VALIDA CPF -->



    <!-- VALIDA TELEFONE -->

<script>
function formatarTelefone(input) {
    const numeroTelefone = input.value.replace(/\D/g, ''); // Remove caracteres não dígitos
    if (numeroTelefone.length <= 10) {
        input.value = numeroTelefone.replace(/(\d{2})(\d{4})(\d{4})/, '($1)$2-$3');
    } else {
        input.value = numeroTelefone.replace(/(\d{2})(\d{5})(\d{4})/, '($1)$2-$3');
    }
}
</script>

    <!-- FIM VALIDA TELEFONE -->



<!-- GERAR SENHA -->

    <script>
document.addEventListener("DOMContentLoaded", function() {
    const generatePasswordButton = document.getElementById("generatePassword");
    const senhaInput = document.getElementById("senha");

    generatePasswordButton.addEventListener("click", function() {
        const randomPassword = generateRandomPassword(8); // Change the length as needed
        senhaInput.value = randomPassword;
    });

    function generateRandomPassword(length) {
        const charset = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$%";
        let password = "";
        for (let i = 0; i < length; i++) {
            const randomIndex = Math.floor(Math.random() * charset.length);
            password += charset.charAt(randomIndex);
        }
        return password;
    }
});
</script>

<!-- FIM GERAR SENHA -->

</body>
</html>
