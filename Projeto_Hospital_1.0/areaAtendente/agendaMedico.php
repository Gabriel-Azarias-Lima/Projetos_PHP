<?php
# AQUI VOCE FAZ O CODIGO DE LOGIN PHP RODAR NA MESMA PÁGINA

# SOLICITA O ARQUIVO CONECTADB
include("../conectadb.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $medico = $_POST['medico'];
    $data = $_POST['data'];
    $hora = $_POST['hora'];

    # VALIDAÇÃO DE USUARIO. VERIFICA SE MÉDICO JÁ FOI AGENDADO PARA ESSE HORÁRIO
    $sql = "SELECT * FROM agendamento WHERE fk_med_id = '$medico' AND agen_data = '$data' AND agen_hora = '$hora'";
    $retorno = mysqli_query($link, $sql);

    if (mysqli_num_rows($retorno) > 0) {
        echo "<script>window.alert('O MÉDICO JÁ FOI AGENDADO PARA ESSE HORÁRIO');</script>";
    } else {
        // Inserir o agendamento
        $sql = "INSERT INTO agendamento (fk_med_id, agen_data, agen_hora, agen_presente, agen_finalizado) 
        VALUES ('$medico','$data','$hora','n','n')";

        mysqli_query($link, $sql);

        echo "<script>window.alert('MÉDICO AGENDADO');</script>";
        echo "<script>window.location.href='agendaMedico.php';</script>";
    }
}
?>


<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../imagem/favicon.ico">

    <link rel="stylesheet" href="../css/style_formulario_med.css">

    <!-- LINK DOS ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Agenda Médica</title>
</head>

<body class="pag_atendente">


    <div class="form_box">
        <form action="agendaMedico.php" method="post">
            <fieldset>
                <legend><b>Agenda do Médico</b></legend>
                <br>

                <div class="form_inputBox">

                    <select name="medico" id="medico" class="inputUser">
                    <?php
                        include '../conectadb.php';

                        $query = "SELECT med_id, med_nome, med_especialidade FROM Medico";
                        $result = mysqli_query($link, $query);

                        while ($row = mysqli_fetch_assoc($result)) {
                        echo '<option value="' . $row['med_id'] . '" style="color: black;">' . $row['med_nome'] . ' - ' . $row['med_especialidade'] . '</option>';
                        }

                        mysqli_close($link);
                    ?>
                    </select>
                    <label for="medico" class="labelInput">Médico</label>

                </div>

                <br>

                <div class="conteiner_input">
                
                <div class="input_especial">
                    <p>Data de Agendamento</p>
                    <input type="date" name="data" id="datanasc" required>
                </div>
                
                <div class="input_especial">
                    <p>Hora do Agendamento</p>
                    <input type="time" name="hora" id="horainicio" required>
                </div>

                </div>                   

                <br><br>
                
                <input type="submit" name="submit" id="submit" value="Agendar">

            </fieldset>
        </form>

        <div class="container_btn_voltar">
            <a href="agendamento.php"><button class="btn_voltar">Voltar</button></a>
        </div>

</div>


</body>
</html>