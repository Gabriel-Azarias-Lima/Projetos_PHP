<?php
session_start();
include("../conectadb.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nome = $_POST["nome"];
    $telefone = $_POST["telefone"];
    $mensagem = $_POST["mensagem"];
    $avaliacaoEstrelas = $_POST["rating"];

    // Verifica a conexão
    if (!$link) {
        die("Falha na conexão: " . mysqli_connect_error());
    }

    // Prepara e executa o SQL para inserir os dados na tabela
    $sql = "INSERT INTO avaliacao (nome, telefone, mensagem, estrela) 
            VALUES ('$nome', '$telefone', '$mensagem', '$avaliacaoEstrelas')";

    if (mysqli_query($link, $sql)) {
        echo "<script>window.alert('Avaliação enviada com sucesso!');</script>";
        echo "<script>window.location.href='avaliacao_semLogin.php';</script>";
    } else {
        echo "<script>window.alert('Erro ao enviar avaliação: " . mysqli_error($link) . "');</script>";
    }

    // Fecha a conexão
    mysqli_close($link);
}
?>
