<?php
include("../conectadb.php");

session_start();
$nomemed = $_SESSION["nomemed"];

if (isset($_GET['id'])) {
    $agendamento_id = $_GET['id'];

    // Obter o ID do médico logado (com base no nome)
    $sql_medico_id = "SELECT med_id FROM Medico WHERE med_nome = '$nomemed'";
    $result_medico_id = mysqli_query($link, $sql_medico_id);
    $row_medico_id = mysqli_fetch_assoc($result_medico_id);
    $medico_id = $row_medico_id['med_id'];

    // Verificar se o médico já tem outro agendamento marcado como chamado
    $check_chamada_query = "SELECT agen_id FROM Agendamento WHERE fk_med_id = $medico_id AND agen_chamada = 's'";
    $check_chamada_result = mysqli_query($link, $check_chamada_query);

    if (mysqli_num_rows($check_chamada_result) > 0) {
        // Mensagem de erro se o médico já tiver um agendamento marcado como chamado
        echo "<script>alert('VOCÊ JÁ ESTÁ CHAMANDO UM PACIENTE!'); window.location.href='listaPaciente.php';</script>";
    } else {
        // Atualizar o campo agen_chamada para 's'
        $update_query = "UPDATE Agendamento SET agen_chamada = 's' WHERE agen_id = $agendamento_id";
        mysqli_query($link, $update_query);

        // Exibir mensagem de sucesso usando um alerta JavaScript
        echo "<script>alert('PACIENTE CHAMADO COM SUCESSO!'); window.location.href='listaPaciente.php';</script>";
    }
} else {
    echo "<script>alert('ID de agendamento não especificado.'); window.location.href='listaPaciente.php';</script>";
}
?>
