<?php
include("../conectadb.php");

session_start();
$nomeatendente = $_SESSION['nomeatendente'];

$id = 0;
$cpf = '';
$data = '';
$hora = '';
$presente = '';
$finalizado = '';

$cpf_paciente = isset($_GET['cpf_paciente']) ? $_GET['cpf_paciente'] : '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $cpf = $_POST['cpf'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];
    $presente = isset($_POST['presente']) ? $_POST['presente'] : '';
    $finalizado = $_POST['finalizado'];

    if (!empty($cpf) || ($data !== '' && $hora !== '' && $presente !== '')) {
        if ($cpf !== 'Horario Livre') {
            $cpfQuery = "SELECT pac_id FROM paciente WHERE pac_cpf = '$cpf'";
            $cpfResult = mysqli_query($link, $cpfQuery);

            if (mysqli_num_rows($cpfResult) > 0) {
                $row = mysqli_fetch_assoc($cpfResult);
                $fk_pac_id = $row['pac_id'];

                $sql = "UPDATE agendamento SET fk_pac_id='$fk_pac_id', agen_data='$data', agen_hora='$hora', agen_presente='$presente', agen_finalizado='$finalizado' WHERE agen_id = $id";

                if (mysqli_query($link, $sql)) {
                    echo "<script>alert('AGENDAMENTO ALTERADO COM SUCESSO!');</script>";
                    echo "<script>window.location.href='listaagendamento.php';</script>";
                } else {
                    echo "<script>alert('Erro ao alterar o agendamento: " . mysqli_error($link) . "');</script>";
                }
            } else {
                echo "<script>alert('CPF do paciente não encontrado no banco de dados.');</script>";
            }
        } else {
            $sql = "UPDATE agendamento SET agen_data='$data', agen_hora='$hora', agen_presente='$presente', agen_finalizado='$finalizado' WHERE agen_id = $id";

            if (mysqli_query($link, $sql)) {
                echo "<script>alert('AGENDAMENTO ALTERADO COM SUCESSO!');</script>";
                echo "<script>window.location.href='listaagendamento.php';</script>";
            } else {
                echo "<script>alert('Erro ao alterar o agendamento: " . mysqli_error($link) . "');</script>";
            }
        }
    } else {
        echo "<script>alert('Por favor, preencha todos os campos obrigatórios.');</script>";
    }
} else {
    $id = $_GET['id'];
    $sql = "SELECT ag.*, m.med_nome FROM agendamento ag
            LEFT JOIN Medico m ON ag.fk_med_id = m.med_id
            WHERE ag.agen_id = '$id'";
    $retorno = mysqli_query($link, $sql);

    if ($tbl = mysqli_fetch_array($retorno)) {
        $id = $tbl['agen_id'];
        $cpf = '';
        $data = $tbl['agen_data'];
        $hora = substr($tbl['agen_hora'], 0, 5);
        $presente = $tbl['agen_presente'];
        $finalizado = $tbl['agen_finalizado'];
        $medico_nome = $tbl['med_nome']; // Defina o nome do médico aqui
    }
}
?>

<!DOCTYPE html>
<html lang="pt br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../imagem/favicon.ico">

    <link rel="stylesheet" href="../css/style_formulario_aten.css">

    <!-- Teste CPF -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <!-- LINK DOS ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>ALTERA AGENDAMENTO</title>
</head>

<body class="pag_atendente">
    <div class="form_box">
        <form action="alteraagendamento.php" method="post">
            <fieldset>
                <legend><b>Altera Agendamento</b></legend>
                <br>
                <input type="hidden" name="id" value="<?= $id ?>">
                <br>
                <br><br>
                <br>
                <div class="form_inputBox">
                    <input type="text" name="cpf" id="cpf" class="inputUser" placeholder="Digite o CPF" value="<?= $cpf_paciente ?>">
                    <label for="cpf" class="labelInput_alt">CPF do Paciente</label>






                    <div class="form_inputBox" style="margin-top: 40px; margin-left: 1px;">
                    <input type="text" class="inputUser" value="<?= $medico_nome ?>" readonly>
                    <label for="medico" class="labelInput_alt">Médico</label>
                    </div>





                    <br>
                    <div class="conteiner_input">
                        <div class="input_especial">
                            <p>Data de Agendamento</p>
                            <?php
                            $dataField = $cpf_paciente === 'Horario Livre' ? '<input type="date" name="data" id="data" value="' . $data . '">' : '<input type="date" name="data" id="data" value="' . $data . '" readonly>';
                            echo $dataField;
                            ?>
                        </div>
                        <div class="input_especial">
                            <p>Hora do Agendamento</p>
                            <input type="time" name="hora" id="hora" value="<?= $hora ?>">
                        </div>
                    </div>
                    <br><br>
                    <br><br>
                    <div class="container_radio_label">
    <div class="form_inputBox">
        <label class="radio_label">
            PRESENTE<br>
            <input type="radio" name="presente" value="s" <?= $presente == "s" ? "checked" : "" ?>>
        </label>
    </div>
    <div class="form_inputBox">
        <label class="radio_label">
            AUSENTE<br>
            <input type="radio" name="presente" value="n" <?= $presente == "n" ? "checked" : "" ?>>
        </label>
    </div>
</div>

<br><br>

<div class="container_radio_label">
    <div class="form_inputBox">
        <label class="radio_label">
            FINALIZADO<br>
            <input type="radio" name="finalizado" value="s" <?= $finalizado == "s" ? "checked" : "" ?>>
        </label>
    </div>
    <div class="form_inputBox">
        <label class="radio_label">
            PENDENTE<br>
            <input type="radio" name="finalizado" value="n" <?= $finalizado == "n" ? "checked" : "" ?>>
        </label>
    </div>
</div>
                    <br><br>
                    <input type="submit" name="submit" id="submit" value="Salvar">
            </fieldset>
        </form>
        <div class="container_btn_voltar">
            <a href="listaagendamento.php"><button class="btn_voltar">Voltar</button></a>
        </div>
    </div>
</body>


</html>