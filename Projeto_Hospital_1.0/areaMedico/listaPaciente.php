<?php
include("../conectadb.php");

session_start();
$nomemed = $_SESSION["nomemed"];

# Obter o ID do médico logado
$sql_medico_id = "SELECT med_id FROM Medico WHERE med_nome = '$nomemed'";
$result_medico_id = mysqli_query($link, $sql_medico_id);
$row_medico_id = mysqli_fetch_assoc($result_medico_id);
$medico_id = $row_medico_id['med_id'];

# Listar os agendamentos correspondentes ao médico logado
$currentDate = date('Y-m-d');
$sql = "SELECT ag.*, p.pac_nome
        FROM Agendamento ag
        INNER JOIN Paciente p ON ag.fk_pac_id = p.pac_id
        WHERE ag.fk_med_id = $medico_id 
        AND ag.agen_presente = 's'
        AND (ag.agen_finalizado = 'n' OR ag.agen_finalizado = '')
        AND DATE(ag.agen_data) = '$currentDate'
        ORDER BY ag.agen_hora"; // Ordena por agen_hora (hora do agendamento)



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

    <!-- ATUALIZA A PAGINA AUTOMATICAMENTE -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/socket.io/4.0.1/socket.io.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <link rel="stylesheet" href="../css/style_list_pac.css">
    <title>Lista de Chamada</title>

</head>
<body class="pag_pac">


<!-- BLOQUEIA A PÁGINA PARA USUÁRIOS NÃO CADASTRADOS -->

<?php
                    #ABERTO O PHP PARA VALIDAR SE A SESSÃO DO USUARIO ESTÁ ABERTA
                    #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
                    if($nomemed != null){
                        ?>

                        <?php

                    }
                    else{
                        echo($sql);
                        echo"<script>window.alert('USUARIO NÃO AUTENTICADO');
                        window.location.href='medlogin.php';</script>";
                    }
                    #FIM DO PHP PARA CONTINUAR MEU HTML
                ?>

<!-- FIM BLOQUEIA PAGINA -->


    <br>
    <h1>Lista de Chamada</h1>
    <br>

    <div class="container_btn_voltar">
        <a href="medlista.php"><button class="btn_voltar_aten">Voltar</button></a>
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
        

        <table class="table text-white table-bg">
            <thead>
                <tr>
                    <th>PACIENTE</th>
                    <th>MEDICO</th>
                    <th>ESPECIALIDADE</th>
                    <th>DATA</th>
                    <th>HORARIO</th>
                    <th>CHAMAR</th>
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

                    <td>
                        <a class='btn btn_altera_med btn-sm btn-primary' href='chamar.php?id=<?= $tbl['agen_id'] ?>' title='Chamar'>
                            <i class="fa-solid fa-bell"></i>
                        </a>    
                    </td>

                    <?php
                    }
                    ?>
            </tbody>
        </table>
    </div>

    <!-- ATUALIZA A PAGINA QUANDO TIVER MODIFICAÇÃO NO AGENDAMENTO -->

    <script>
        function checkForUpdates() {
            $.ajax({
                url: 'check_updates.php',
                method: 'GET',
                success: function(response) {
                    if (response === 'update') {
                        window.location.reload(); // Atualiza a página
                    }
                }
            });
        }

        // Chame a função a cada 10 segundos (10000 milissegundos)
        setInterval(checkForUpdates, 5000);
    </script>

    <!-- FIM ATUALIZA PAGINA -->


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
        
        window.location = 'listaPaciente.php?finalizado=' + ativoValue + '&search=' + encodeURIComponent(searchValue);
    }
</script>
</html>