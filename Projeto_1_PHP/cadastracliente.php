<?php
#cli_id	
#cli_cpf	
#cli_nome	
#cli_senha	
#cli_datanasc	
#cli_telefone	
#cli_logradouro	
#cli_numero	
#cli_cidade	
#cli_ativo



include("conectadb.php");

if($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $cpf = $_POST['cpf'];
    $nome = $_POST['nome'];
    $senha = $_POST['senha'];
    $datanasc = $_POST['datanasc'];
    $telefone = $_POST['telefone'];
    $logradouro = $_POST['logradouro'];
    $numero = $_POST['numero'];
    $cidade = $_POST['cidade'];



    #VALIDAÇÃO DE USUARIO. VERIFICA DE USUARIO JÁ EXISTE
    $sql = "SELECT COUNT(cli_cpf) FROM clientes WHERE cli_cpf = '$cpf'";
    $retorno = mysqli_query($link, $sql);

    while ($tbl = mysqli_fetch_array($retorno))
    {
        $cont = $tbl[0];
    }

    #VALIDAÇÃO DE TRUE E FALSE
    if($cont == 1)
    {
        echo"<script>window.alert('CLIENTE JÁ EXISTE');</script>";
    }
    else
    {
        $sql = "INSERT INTO clientes (cli_cpf, cli_nome, cli_senha, cli_datanasc, cli_telefone, cli_logradouro, cli_numero, cli_cidade, cli_ativo) VALUES('$cpf','$nome','$senha','$datanasc','$telefone','$logradouro','$numero','$cidade','s')"; # 'n' representa usuario não ativo
                                                                                                        # posso colocar 's' para usuario ativo
        mysqli_query($link, $sql);
        #cadastra cliente e joga mensagem na tela e direciona para lista usuario
        echo"<script>window.alert('CLIENTE CADASTRADO');</script>";
        echo"<script>window.location.href='listacliente.php';</script>";

    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/estiloadm.css">
    <title>CADASTRO DE CLIENTE</title>
</head>
<body>
    <div>
        <ul class="menu">
            <li><a href="cadastrausuario.php">CADASTRA USUARIO</a></li>
            <li><a href="cadastracliente.php">CADASTRA CLIENTE</a></li>
            <li><a href="listausuario.php">LISTA USUARIO</a></li>
            <li><a href="cadastraproduto.php">CADASTRA PRODUTOS</a></li>
            <li><a href="listaproduto.php">LISTA PRODUTOS</a></li>
            <li><a href="listacliente.php">LISTA CLIENTE</a></li>
            <li class="menuloja"><a href="./areacliente/loja.php">LOJA</a></li>
        </ul>  
    </div>

    <div>
        <form action="cadastracliente.php" method="post">

            <input type="number" name="cpf" id="cpf" placeholder="CPF">
            <br>
            <input type="text" name="nome" id="nome" placeholder="NOME">
            <br>
            <input type="password" name="senha" id="senha" placeholder="SENHA">
            <br>
            <input type="date" name="datanasc" id="datanasc" placeholder="DATA NACIMENTO">
            <br>
            <input type="number" name="telefone" id="telefone" placeholder="TELEFONE">
            <br>
            <input type="text" name="logradouro" id="logradouro" placeholder="LOGRADOURO">
            <br>
            <input type="text" name="numero" id="numero" placeholder="NUMERO">
            <br>
            <input type="text" name="cidade" id="cidade" placeholder="CIDADE">
            <br>
            <input type="submit" name="cadastrar" id="cadastrar" value="CADASTRAR">

        </form>
    </div>

</body>
</html>