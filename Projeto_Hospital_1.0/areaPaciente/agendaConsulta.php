<?php
session_start();
$nomepac = $_SESSION["nomepac"];
include("../conectadb.php");


// Verificar e atualizar agendamentos com data passada
$currentDate = date("Y-m-d"); // Obtém a data atual
$sql_update_expired = "UPDATE Agendamento SET agen_finalizado = 's' WHERE agen_data < '$currentDate' AND agen_finalizado != 's'";
mysqli_query($link, $sql_update_expired);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['agendamento_id'])) {
        $agendamento_id = $_POST['agendamento_id'];
        $paciente_nome = $_SESSION['nomepac'];

        // Obter o ID do paciente
        $sql = "SELECT pac_id FROM Paciente WHERE pac_nome = '$paciente_nome'";
        $result = mysqli_query($link, $sql);
        $row = mysqli_fetch_assoc($result);
        $paciente_id = $row['pac_id'];

        // Verificar se todos os agendamentos do paciente com o mesmo médico estão finalizados
        $sql_check_all_finalized = "SELECT COUNT(*) AS num_rows FROM Agendamento WHERE fk_pac_id = $paciente_id AND fk_med_id = (SELECT fk_med_id FROM Agendamento WHERE agen_id = $agendamento_id) AND agen_finalizado != 's'";
        $result_check_all_finalized = mysqli_query($link, $sql_check_all_finalized);
        $row_check_all_finalized = mysqli_fetch_assoc($result_check_all_finalized);
        $all_finalized = $row_check_all_finalized['num_rows'] == 0;

        if ($all_finalized) {
            // Atualizar o agendamento com o ID do paciente
            $sql_update = "UPDATE Agendamento SET fk_pac_id = $paciente_id WHERE agen_id = $agendamento_id";
            mysqli_query($link, $sql_update);

            // Exibir mensagem de confirmação
            echo "<script>window.alert('CONSULTA AGENDADA');</script>";
            echo "<script>window.location.href='agendaConsulta.php';</script>";
        } else {
            // Paciente não pode agendar devido a agendamentos pendentes
            echo "<script>window.alert('VOCÊ TEM CONSULTAS PENDENTES COM ESSE MÉDICO!');</script>";
            echo "<script>window.location.href='agendaConsulta.php';</script>";
        }
    }
}

// Restante do código permanece o mesmo
// Query para buscar todos os agendamentos ordenados por especialidade e data/hora
$sql = "SELECT ag.*, m.med_nome, m.med_especialidade
        FROM Agendamento ag
        LEFT JOIN Medico m ON ag.fk_med_id = m.med_id
        WHERE ag.fk_pac_id IS NULL AND ag.agen_finalizado != 's'
        ORDER BY m.med_especialidade, ag.agen_data ASC, ag.agen_hora ASC";
$result = mysqli_query($link, $sql);
?>




<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../imagem/favicon.ico">
    <link rel="stylesheet" href="../css/style_formulario_agen.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Menu Administração</title>
</head>
<body class="pag_pac">


    <!-- BLOQUEIA A PAGINA PARA USUÁRIO NÃO CADASTRADO -->
    <?php
                    #ABERTO O PHP PARA VALIDAR SE A SESSÃO DO USUARIO ESTÁ ABERTA
                    #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
                    if($nomepac != null){
                        ?>
                        <!-- USO DO ELEMENTO HTML COM PHP INTERNO -->
                        
                        
                        <?php
                        #ABERTURA DE OUTRO PHP PARA CASO FALSE
                    }
                    else{
                        echo($sql);
                        echo"<script>window.alert('USUARIO NÃO AUTENTICADO');
                        window.location.href='paclogin.php';</script>";
                    }
                    #FIM DO PHP PARA CONTINUAR MEU HTML
?>

<!-- FIM BLOQUEIA A PAGINA PARA NÃO USUÁRIO CADASTRADO -->



    <div class="form_box">
        <div class="container_btn_voltar">
            <a href="agendamentos.php"><button class="btn_voltar">Voltar</button></a>
        </div>
        <br>
        <legend><b>AGENDAMENTOS DISPONÍVEIS</b></legend>
        <br>
        <br>
        <br>
        <div class="content">
            <?php
            mysqli_data_seek($result, 0);

            while ($row = mysqli_fetch_assoc($result)) {
                $agendamento_id = $row['agen_id'];
                $med_nome = $row['med_nome'];
                $med_especialidade = $row['med_especialidade'];
                $agen_data = $row['agen_data'];
                $agen_hora = $row['agen_hora'];

                ?>
                <fieldset>
                    <legend><b><?php echo $med_especialidade; ?></b></legend>
                    <br>
                    <div id="agendamento_<?php echo $agendamento_id; ?>" class="agendamento-details">
                        <div class="form_inputBox">
                            <input type="text" value="<?php echo $med_nome; ?>" class="inputUser" readonly>
                            <label for="nome" class="labelInput">Médico</label>
                        </div>
                        <br><br>
                        <div class="form_inputBox">
                            <input type="text" value="<?php echo $med_especialidade; ?>" class="inputUser" readonly>
                            <label for="nome" class="labelInput">Especialidade</label>
                        </div>
                        <br>
                        <div class="conteiner_input">
                            <div class="input_especial">
                                <p>Data da Consulta</p>
                                <input type="date" value="<?php echo $agen_data; ?>"  id="datanasc" readonly>
                            </div>
                            <div class="input_especial">
                                <p>Hora da Consulta</p>
                                <input type="time" value="<?php echo $agen_hora; ?>" id="horainicio" readonly>
                            </div>
                        </div>
                        <br><br>
                        <form action="agendaConsulta.php" method="post">
                            <input type="hidden" name="agendamento_id" value="<?php echo $agendamento_id; ?>">
                            <input type="submit" name="submit" id="submit" value="Agendar">
                        </form>
                    </div>
                </fieldset>
                <br><br>
                <?php
            }
            ?>
        </div>
    </div>
</body>
</html>