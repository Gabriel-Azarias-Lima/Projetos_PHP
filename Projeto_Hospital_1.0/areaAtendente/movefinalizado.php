<?php
include("../conectadb.php");
session_start();
$nomeatendente = $_SESSION["nomeatendente"];

if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $agenda_id = $_GET['id'];

    // Exclua a agenda com o ID fornecido
    $deleteSql = "DELETE FROM agendamento WHERE agen_id = $agenda_id";
    $result = mysqli_query($link, $deleteSql);

    if ($result) {
        // Exclusão bem-sucedida, redirecione de volta para a lista
        header("Location: listaagendamento.php");
        exit();
    } else {
        // Trate o erro se a exclusão falhar
        echo "Erro ao excluir a agenda.";
    }
} else {
    // Trate a solicitação inválida
    echo "Solicitação inválida.";
}
?>
