<?php
include("../conectadb.php");

session_start();
$nomepac = $_SESSION["nomepac"];

# Obter o ID do paciente logado
$sql_paciente_id = "SELECT pac_id FROM Paciente WHERE pac_nome = '$nomepac'";
$result_paciente_id = mysqli_query($link, $sql_paciente_id);
$row_paciente_id = mysqli_fetch_assoc($result_paciente_id);
$paciente_id = $row_paciente_id['pac_id'];

$currentDate = date('Y-m-d');
$sql_update_expired = "UPDATE Agendamento SET agen_finalizado = 's' WHERE agen_finalizado = 'n' AND agen_data < '$currentDate'";
mysqli_query($link, $sql_update_expired);

# JÁ LISTA OS USUARIOS DO MEU BANCO
$sql = "SELECT * FROM agendamento WHERE agen_finalizado = 'n' AND fk_pac_id = $paciente_id";

# FORÇA TRAZER 'n' NA VARIÁVEL FINALIZADO
$finalizado = 'n';

# COLETA O BOTÃO DE POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $finalizado = $_POST['finalizado'];

    if ($finalizado == 'n') {
        $sql = "SELECT * FROM agendamento WHERE agen_finalizado = 'n' AND fk_pac_id = $paciente_id";
    } else {
        $sql = "SELECT * FROM agendamento WHERE agen_finalizado = 's' AND fk_pac_id = $paciente_id";
    }
} else {
    $finalizado = isset($_GET['finalizado']) ? $_GET['finalizado'] : 'n';  // Default to 's' if not provided
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $sql = "SELECT ag.*, p.pac_nome, m.med_nome
            FROM Agendamento ag
            LEFT JOIN Paciente p ON ag.fk_pac_id = p.pac_id
            LEFT JOIN Medico m ON ag.fk_med_id = m.med_id 
            WHERE ag.fk_pac_id = $paciente_id ";
    
    if ($finalizado == 'n') {
        $sql .= "AND ag.agen_finalizado = 'n' ";
    } elseif ($finalizado == 's') {
        $sql .= "AND ag.agen_finalizado = 's' ";
    }
    
    if (!empty($search)) {
        $sql .= "AND (ag.agen_id LIKE '%$search%' OR p.pac_nome LIKE '%$search%' OR m.med_nome LIKE '%$search%' OR ag.agen_data LIKE '%$search%' OR ag.agen_hora LIKE '%$search%' OR ag.agen_finalizado LIKE '%$search%')";
    }
}

$retorno = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagem/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <!-- LINK DOS ICONS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <link rel="stylesheet" href="../css/style_list_pac.css">
    <title>Lista de Consultas</title>

</head>
<body class="pag_pac">

<!-- BLOQUEIA A PÁGINA PARA USUÁRIOS NÃO CADASTRADOS -->

<?php
                    #ABERTO O PHP PARA VALIDAR SE A SESSÃO DO USUARIO ESTÁ ABERTA
                    #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
                    if($nomepac != null){
                        ?>

                        <?php

                    }
                    else{
                        echo($sql);
                        echo"<script>window.alert('USUARIO NÃO AUTENTICADO');
                        window.location.href='paclogin.php';</script>";
                    }
                    #FIM DO PHP PARA CONTINUAR MEU HTML
                ?>

<!-- FIM BLOQUEIA PAGINA -->

    <br>
    <h1>Lista de Consultas</h1>
    <br>

    <div class="container_btn_voltar">
        <a href="agendamentos.php"><button class="btn_voltar_aten">Voltar</button></a>
    </div>

    <br>
    
    <div class="box-search">
        <input type="search" class="form-control w-25" placeholder="Pesquisar" id="pesquisar">
        <button onclick="searchData()" class="btn_aten btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                class="bi bi-search" viewBox="0 0 16 16">
                <path
                    d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
        </button>
    </div>
    


    <div class="m-5">
        <form action="listaConsulta.php" method="post">

        <div class="container_radio_label">

        <label class="radio_label">PENDENTE <br>
            <input type="radio" name="finalizado" class="radio" value="n" required
                onclick="submit()" <?= $finalizado == 'n' ? "checked" : "" ?>>
        </label>

        <label class="radio_label">FINALIZADOS <br>
            <input type="radio" name="finalizado" class="radio" value="s" required
                onclick="submit()" <?= $finalizado == 's' ? "checked" : "" ?>>
        </label>

        </div>

        </form>

        <table class="table text-white table-bg">
            <thead>
                <tr>
                    <th>NOME</th>
                    <th>MEDICO</th>
                    <th>ESPECIALIDADE</th>
                    <th>DATA</th>
                    <th>HORARIO</th>
                    <th>EXCLUIR</th>
                </tr>     
            </thead>
            <tbody>
            <?php
                    while ($tbl = mysqli_fetch_array($retorno)) {
                        // Realize um novo SELECT para obter o nome do paciente
                        $sql_paciente = "SELECT pac_nome FROM paciente WHERE pac_id = " . $tbl['fk_pac_id'];
                        $result_paciente = mysqli_query($link, $sql_paciente);
                    
                        if ($result_paciente) {
                            $row_paciente = mysqli_fetch_assoc($result_paciente);
                            $nome_paciente = $row_paciente['pac_nome'];
                        } else {
                            $nome_paciente = "Nome não encontrado"; // Defina uma mensagem padrão
                        }

                        // Realize um novo SELECT para obter o nome e a especialidade do médico
                    $sql_medico = "SELECT med_nome, med_especialidade FROM medico WHERE med_id = " . $tbl['fk_med_id'];
                    $result_medico = mysqli_query($link, $sql_medico);

                    if ($result_medico) {
                        $row_medico = mysqli_fetch_assoc($result_medico);
                        $nome_medico = $row_medico['med_nome'];
                        $especialidade_medico = $row_medico['med_especialidade'];
                    } else {
                        $nome_medico = "Nome não encontrado"; // Defina uma mensagem padrão
                        $especialidade_medico = "Especialidade não encontrada"; // Defina uma mensagem padrão
                    }
                    
                        // Realize um novo SELECT para obter o nome do médico
                        $sql_medico = "SELECT med_nome FROM medico WHERE med_id = " . $tbl['fk_med_id'];
                        $result_medico = mysqli_query($link, $sql_medico);
                    
                        if ($result_medico) {
                            $row_medico = mysqli_fetch_assoc($result_medico);
                            $nome_medico = $row_medico['med_nome'];
                        } else {
                            $nome_medico = "Nome não encontrado"; // Defina uma mensagem padrão
                        }
                        
                ?>
                    <tr>
                    <td><?= $nome_paciente ?></td>
                    <td><?= $nome_medico ?></td> <!-- Aqui exibe o nome do médico -->
                    <td><?= $especialidade_medico ?></td> <!-- Especialidade do médico -->
                    <td><?= date('d/m/Y', strtotime($tbl[3])) ?></td>
                    <td><?= date('H:i', strtotime($tbl[4])) ?></td>
                    
                    <td class="excluir">
    <a class='btn btn-sm btn-danger' href='delete.php?id=<?= $tbl['agen_id'] ?>' title='Deletar'>
        <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
            <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
        </svg>
    </a>
</td>

                    <?php
                    }
                    ?>
            </tbody>
        </table>
    </div>
</body>
<script>
    var search = document.getElementById('pesquisar');

    search.addEventListener("keydown", function(event) {
        if (event.key === "Enter") {
            searchData();
        }
    });

    function searchData() {
        var ativoValue = document.querySelector('input[name="finalizado"]:checked').value;
        var searchValue = search.value;
        
        window.location = 'listaConsulta.php?finalizado=' + ativoValue + '&search=' + encodeURIComponent(searchValue);
    }
</script>
</html>