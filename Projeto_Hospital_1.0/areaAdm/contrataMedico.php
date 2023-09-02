<?php

session_start();
$nomeadm = $_SESSION["nomeadm"];

 #AQUI VOCE FAZ O CODIGO DE LOGIN PHP RODAR NA MESMA PÁGINA

 #SOLICITA O ARQUIVO CONECTADB
 include("../conectadb.php");
 if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $especialidade = $_POST['especialidade'];
    $horainicio = $_POST['horainicio'];
    $horafim = $_POST['horafim'];
    $datanasc = $_POST['datanasc'];
    $telefone = $_POST['telefone'];
    $cidade = $_POST['cidade'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];


    # GERAÇÃO DA SENHA DE 8 DÍGITOS ALEATÓRIOS
    $senha = '';
    $caracteres = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ@#$%';
    $tamanho_senha = 8;
    for ($i = 0; $i < $tamanho_senha; $i++) {
        $senha .= $caracteres[rand(0, strlen($caracteres) - 1)];
    }

    // Remove todos os não dígitos (pontos e traço)
    $cpf = preg_replace("/\D/", "", $cpf);

    // remove formatação do telefone
    $telefone = $_POST['telefone'];
    $telefoneNumerico = preg_replace("/\D/", "", $telefone); // Remove os caracteres não numéricos



    #VALIDAÇÃO DE USUARIO. VERIFICA DE USUARIO JÁ EXISTE
    $sql = "SELECT COUNT(med_cpf) FROM medico WHERE med_cpf = '$cpf'";
    $retorno = mysqli_query($link, $sql);

    while ($tbl = mysqli_fetch_array($retorno))
    {
        $cont = $tbl[0];
    }

    #VALIDAÇÃO DE TRUE E FALSE
    if($cont == 1)
    {
        echo"<script>window.alert('MÉDICO JÁ EXISTE');</script>";
    }
    else
    {
        $sql = "INSERT INTO medico (med_nome, med_senha, med_email, med_cpf, med_especialidade, med_horainicio, med_horafim, med_datanasc, med_telefone, med_cidade, med_endereco, med_numero, med_ativo) 
        VALUES('$nome','$senha','$email','$cpf','$especialidade','$horainicio','$horafim','$datanasc','$telefoneNumerico','$cidade','$endereco','$numero','s')"; # 'n' representa usuario não ativo
                                                                                                        # posso colocar 's' para usuario ativo
        mysqli_query($link, $sql);
        #cadastra cliente e joga mensagem na tela e direciona para lista usuario
        echo"<script>window.alert('MÉDICO CADASTRADO');</script>";
        echo"<script>window.location.href='contrataMedico.php';</script>";

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

    <link rel="stylesheet" href="../css/style_formulario_med.css">

    <!-- LINK DOS ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Contratar Médico</title>
</head>
<body class="pag_formulario">


<!-- BLOQUEIA A PÁGINA PARA USUÁRIOS NÃO CADASTRADOS -->

<?php
                    #ABERTO O PHP PARA VALIDAR SE A SESSÃO DO USUARIO ESTÁ ABERTA
                    #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
                    if($nomeadm != null){
                        ?>

                        <?php

                    }
                    else{
                        echo($sql);
                        echo"<script>window.alert('USUARIO NÃO AUTENTICADO');
                        window.location.href='admlogin.php';</script>";
                    }
                    #FIM DO PHP PARA CONTINUAR MEU HTML
                ?>

<!-- FIM BLOQUEIA PAGINA -->




<!-- MEIO DA PAGINA -->

<!-- INICIO FORMULARIO -->

<div class="form_box">
        <form action="contrataMedico.php" method="post">
            <fieldset>
                <legend><b>Contrata Médico</b></legend>
                <br>

                <div class="form_inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome completo</label>
                </div>

                <br><br>

                <div class="form_inputBox">
                    <input type="text" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">E-mail</label>
                </div>

                <br><br>


                <div class="form_inputBox">
                    <input type="text" name="cpf" id="cpf" class="inputUser" maxlength="14" oninput="formatarCPF()" required>
                    <label for="cpf" class="labelInput">CPF</label>
                </div>


                <br><br>

                <div class="form_inputBox">
                    <input type="text" name="especialidade" id="especialidade" class="inputUser" required>
                    <label for="especialidade" class="labelInput">Especialidade</label>
                </div>

                <br><br>

                <div class="conteiner_input">
                
                <div class="input_especial">
                    <p>Data de Nascimento</p>
                    <input type="date" name="datanasc" id="datanasc" required>
                </div>
                
                <div class="input_especial">
                    <p>Inicio Expediente</p>
                    <input type="time" name="horainicio" id="horainicio" required>
                </div>

                <div class="input_especial">
                    <p>Fim Expediente</p>
                    <input type="time" name="horafim" id="horafim" required>
                </div>

                </div>                         

                <br><br>

                <div class="form_inputBox">
                <input type="tel" name="telefone" id="telefone" class="inputUser" maxlength="14" required oninput="aplicarFormatacao()">
                    <label for="telefone" class="labelInput">Telefone</label>
                </div>

                <br><br>

                <div class="form_inputBox">
                    <input type="text" name="cidade" id="cidade" class="inputUser" required>
                    <label for="cidade" class="labelInput">Cidade</label>
                </div>

                <br><br>

                <div class="form_inputBox">
                    <input type="text" name="endereco" id="endereco" class="inputUser" required>
                    <label for="endereco" class="labelInput">Endereço</label>
                </div>

                <br><br>

                <div class="form_inputBox">
                    <input type="text" name="numero" id="numero" class="inputUser" required>
                    <label for="numero" class="labelInput">Numero</label>
                </div>

                <br><br>
                
                <input type="submit" name="submit" id="submit">

            </fieldset>
        </form>

        <div class="container_btn_voltar">
            <a href="contratar.php"><button class="btn_voltar">Voltar</button></a>
        </div>

</div>
    <br>

<!-- FIM FORMULARIO -->

<!-- FIM MEIO -->




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