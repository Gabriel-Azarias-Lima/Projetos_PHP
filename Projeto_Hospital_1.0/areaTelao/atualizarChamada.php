<?php
include("../conectadb.php");

function checkForUpdate($lastUpdateTime) {
    global $link;

    $query = "SELECT MAX(agen_id) AS latest_id FROM Agendamento WHERE agen_chamada = 's'";
    $result = mysqli_query($link, $query);
    $row = mysqli_fetch_assoc($result);
    $latestId = $row['latest_id'];

    if ($latestId > $lastUpdateTime) {
        return true;
    }

    return false;
}

$lastUpdateTime = isset($_GET['last_update']) ? $_GET['last_update'] : 0;

while (true) {
    if (checkForUpdate($lastUpdateTime)) {
        echo json_encode(array("update" => true));
        exit;
    }

    usleep(20000000); // Espera por 20 segundos (5000000 microssegundos) antes de verificar novamente
}
?>
