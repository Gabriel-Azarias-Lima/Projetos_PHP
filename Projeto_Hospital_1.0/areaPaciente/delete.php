<?php
include("../conectadb.php");

if (isset($_GET['id'])) {
    $agendamento_id = $_GET['id'];

    // Consulta para verificar se o agendamento está finalizado
    $sql_check_finalizado = "SELECT agen_finalizado FROM Agendamento WHERE agen_id = $agendamento_id";
    $result_check_finalizado = mysqli_query($link, $sql_check_finalizado);
    
    if ($result_check_finalizado) {
        $row_finalizado = mysqli_fetch_assoc($result_check_finalizado);
        $agen_finalizado = $row_finalizado['agen_finalizado'];

        if ($agen_finalizado == 'n') {
            // Consulta para remover o paciente da tabela de agendamento
            $sql_delete_agendamento = "UPDATE Agendamento SET fk_pac_id = NULL WHERE agen_id = $agendamento_id";
            $result_delete_agendamento = mysqli_query($link, $sql_delete_agendamento);

            if ($result_delete_agendamento) {
                // Redirecionar de volta para a página onde o botão "Deletar" foi clicado
                header("Location: {$_SERVER['HTTP_REFERER']}");
                exit;
            } else {
                echo "Erro ao remover o paciente do agendamento: " . mysqli_error($link);
            }
        } else {
            echo "<script>
                    window.alert('NÃO É POSSÍVEL EXCLUIR UMA CONSULTA FINALIZADA!');
                    window.location.href='listaConsulta.php';
                  </script>";
        }
    } else {
        echo "Erro ao verificar o status do agendamento: " . mysqli_error($link);
    }
} else {
    echo "ID do agendamento não fornecido.";
}
?>