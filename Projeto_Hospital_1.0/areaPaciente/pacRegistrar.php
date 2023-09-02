<?php

include("../conectadb.php");

session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') 
{
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $email = $_POST['email'];
    $cpf = $_POST['cpf'];
    $datanasc = $_POST['datanasc'];
    $telefone = $_POST['telefone'];
    $cidade = $_POST['cidade'];
    $endereco = $_POST['endereco'];
    $numero = $_POST['numero'];
    $ativo = $_POST['ativo'];

    // Remove todos os não dígitos (pontos e traço)
    $cpf = preg_replace("/\D/", "", $cpf);

    // remove formatação do telefone
    $telefone = $_POST['telefone'];
    $telefoneNumerico = preg_replace("/\D/", "", $telefone); // Remove os caracteres não numéricos


    // QUERY DO BANCO
    $sql = "SELECT COUNT(pac_cpf) FROM paciente WHERE pac_cpf = '$cpf'";
    $retorno = mysqli_query($link, $sql);


    $tbl = mysqli_fetch_array($retorno);
    $cont = $tbl[0];

    while ($tbl = mysqli_fetch_array($retorno))
    {
        $cont = $tbl[0];
    }

    #VALIDAÇÃO DE TRUE E FALSE
    if($cont == 1)
    {
        echo"<script>window.alert('USUÁRIO JÁ EXISTE');</script>";
    }
    else
    {
        $sql = "INSERT INTO paciente (pac_nome, pac_senha, pac_email, pac_cpf, pac_datanasc, pac_telefone, pac_cidade, pac_endereco, pac_numero, pac_ativo) 
        VALUES('$nome','$senha','$email','$cpf','$datanasc','$telefoneNumerico','$cidade','$endereco','$numero','s')"; # 'n' representa usuario não ativo
                                                                                                        # posso colocar 's' para usuario ativo
        mysqli_query($link, $sql);
        #cadastra cliente e joga mensagem na tela e direciona para lista usuario
        echo"<script>window.alert('USUÁRIO CADASTRADO');</script>";
        echo"<script>window.location.href='paclogin.php';</script>";

    }
}

?>