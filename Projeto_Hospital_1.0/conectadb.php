<?php //CODIGO DE ABERTURA DO PHP

    #ARQUIVO DE ACESSO AO BANCO DE DADOS

    ## ALERTA!!  ALERTA!!  ALERTA!!  ALERTA!!  ALERTA!!  ALERTA!!  ALERTA!!
    ## EM MODO PROFICIONAL O AQUIVO DEVE-SE MANTER OCULTO E PROTEGIDO ##

    ## LOCALIZAR O PC OU SERVIDOR COM O BANCO (NOME DO COMPUTADOR)

    $servidor = "localhost:3307"; // CASO NÃO SEJA SUA MAQUINA LOCAL VOCE VAI COLOCAR O IP DA MAQUINA DESEJADA
    ## NOME DO BANCO
    $banco = "projeto_hospital"; // NOME DO BANCO DE DADOS CRIADOS NO PHP
    #USUARIO DE ACESSO
    $usuario = "root";
    #SENHA DE ACESSO
    $senha = "";

    #LINK DE CONEXÃO
    $link = mysqli_connect($servidor, $usuario, $senha, $banco);



?>