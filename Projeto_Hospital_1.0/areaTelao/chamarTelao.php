<?php
include("../conectadb.php");

$query = "SELECT * FROM Agendamento WHERE agen_chamada = 's' AND agen_finalizado = 'n' ORDER BY agen_id ASC";
$result = mysqli_query($link, $query);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $agendamento_id = $row['agen_id'];

    $query_update = "UPDATE Agendamento SET agen_chamada = 'n' WHERE agen_id = $agendamento_id";
    mysqli_query($link, $query_update);

    $paciente_id = $row['fk_pac_id'];
    $medico_id = $row['fk_med_id'];

    $query_paciente = "SELECT pac_nome FROM Paciente WHERE pac_id = $paciente_id";
    $result_paciente = mysqli_query($link, $query_paciente);
    $row_paciente = mysqli_fetch_assoc($result_paciente);
    $paciente_nome = $row_paciente['pac_nome'];

    $query_medico = "SELECT med_sala FROM Medico WHERE med_id = $medico_id";
    $result_medico = mysqli_query($link, $query_medico);
    $row_medico = mysqli_fetch_assoc($result_medico);
    $sala_medico = $row_medico['med_sala'];
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../imagem/favicon.ico">

    <!-- LINK DOS ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../css/style.css">
    <title>Telão de chamadas</title>
</head>
<body class="pag_pac_login">
 <div class="wrapper">
    <nav class="nav">
        <div class="nav-logo_telao">
            <p>CLINICA VITACARE</p>
        </div>
    </nav>

    <!-- MEIO DA PAGINA -->


   <div class="container_telao">
    <?php
        if (isset($paciente_nome) && isset($sala_medico)) {
            echo '<div class="cont_chamadas_passadas">';
            echo '<div class="primeira_chamada">';
            echo '<p class="paciente_telao">PACIENTE</p>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<p class="nome_paciente">' . $paciente_nome . '</p>';
            echo '<br>';
            echo '<br>';
            echo '<br>';
            echo '<p class="sala_informacao">Por favor dirigir-se para a</p>';
            echo '<p class="sala_medico">Sala:  ' . $sala_medico . '</p>';
            echo '</div>';
            echo '</div>';
        }
        ?>
    </div> 

    <!-- FIM MEIO DA PAGINA -->
</div>

<audio id="notificationSound">
    <source src="alarme_chamada.mp3" type="audio/mp3">
    Seu navegador não suporta o elemento de áudio.
</audio>

<script>
    const notificationSound = document.getElementById('notificationSound');
    let currentIndex = 0;
    let elements; // Declare a variável aqui para ser usada em todo o script

    function playNotificationSound(callback) {
        notificationSound.currentTime = 0;
        notificationSound.play();

        notificationSound.onended = callback;
    }

    function speakText(text) {
        const speechSynthesis = window.speechSynthesis;
        const utterance = new SpeechSynthesisUtterance(text);

        // Chama a função de leitura em voz alta após a leitura do áudio
        utterance.onend = () => {
            currentIndex++;
            if (currentIndex < elements.length) {
                speakText(elements[currentIndex].textContent); // Chama a função para o próximo elemento
            }
        };

        speechSynthesis.speak(utterance);
    }

    // Chame a função para ler o conteúdo da div assim que a página for carregada
    window.addEventListener('load', () => {
        const div = document.querySelector('.cont_chamadas_passadas');
        elements = div.querySelectorAll('p'); // Atribua os elementos para a variável

        if (elements.length > 0) {
            playNotificationSound(() => {
                speakText(elements[currentIndex].textContent); // Inicia a leitura do primeiro elemento após o áudio
            });
        }
    });
</script>

<script>
    function checkForUpdate(lastUpdateTime) {
        fetch(`atualizarChamada.php?last_update=${lastUpdateTime}`)
            .then(response => response.json())
            .then(data => {
                if (data.update) {
                    location.reload();
                } else {
                    checkForUpdate(lastUpdateTime);
                }
            })
            .catch(error => {
                console.error('Erro ao verificar atualização:', error);
                checkForUpdate(lastUpdateTime);
            });
    }

    checkForUpdate(0); // Inicia a verificação de atualização
</script>

</body>
</html>