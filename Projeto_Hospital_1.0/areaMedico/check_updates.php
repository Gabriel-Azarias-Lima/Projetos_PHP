<?php
include("../conectadb.php");

// VERIFICA SE DENTRO DE AGENDAMENTO TEVE UM ALGUMA ALTERAÇÃO NO AGEN_FINALIZADO OU AGEN_PRESENTE, SE SIM FAZ UMA ATUALIZAÇÃO NA PAGINA

$sql_check_updates = "SELECT COUNT(*) AS num_updates FROM Agendamento WHERE agen_finalizado = 's' OR agen_presente = 's'";
$result_check_updates = mysqli_query($link, $sql_check_updates);

if ($result_check_updates) {
    $row_check_updates = mysqli_fetch_assoc($result_check_updates);
    $num_updates = $row_check_updates['num_updates'];

    if ($num_updates > 0) {
        echo 'update'; // Há atualizações, envie 'update'
    }
} else {
    // Tratar erro, se necessário
}

mysqli_close($link);
?>
