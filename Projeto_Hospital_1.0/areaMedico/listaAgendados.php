<?php
include("../conectadb.php");

session_start();
$nomemed = $_SESSION["nomemed"];

$searchValue = isset($_GET['search']) ? $_GET['search'] : '';

$query = "
    SELECT
        Agendamento.fk_med_id,
        Medico.med_nome AS medico_nome,
        Paciente.pac_nome AS paciente_nome,
        Agendamento.agen_data,
        Agendamento.agen_hora,
        Agendamento.agen_chamada
    FROM Agendamento
    INNER JOIN Medico ON Agendamento.fk_med_id = Medico.med_id
    INNER JOIN Paciente ON Agendamento.fk_pac_id = Paciente.pac_id
    WHERE (Medico.med_nome LIKE '%$searchValue%'
        OR Paciente.pac_nome LIKE '%$searchValue%'
        OR Agendamento.agen_data LIKE '%$searchValue%'
        OR Agendamento.agen_hora LIKE '%$searchValue%'
        OR Medico.med_nome LIKE '%$searchValue%'
        OR Paciente.pac_nome LIKE '%$searchValue%')
    AND (Agendamento.agen_finalizado IS NULL OR Agendamento.agen_finalizado = 'n' OR Agendamento.agen_finalizado = '')
    AND Medico.med_nome = '$nomemed' -- Filtra pelo nome do médico logado
    AND CONCAT(Agendamento.agen_data, ' ', Agendamento.agen_hora) >= NOW() -- Filtro para agendamentos futuros
    ORDER BY Agendamento.agen_data, Agendamento.agen_hora;
";

$result = mysqli_query($link, $query);

if (!$result) {
    die("Erro na consulta: " . mysqli_error($link));
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="../imagem/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    
    <link rel="stylesheet" href="../css/style_list.css">
    <title>Lista Agendados</title>

</head>
<body class="pag_pac">

<!-- BLOQUEIA A PÁGINA PARA USUÁRIOS NÃO CADASTRADOS -->

<?php
                    #ABERTO O PHP PARA VALIDAR SE A SESSÃO DO USUARIO ESTÁ ABERTA
                    #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
                    if($nomemed != null){
                        ?>
                        <!-- USO DO ELEMENTO HTML COM PHP INTERNO -->
                        

                        <?php
                        #ABERTURA DE OUTRO PHP PARA CASO FALSE
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
    <h1>Agendados do Mês</h1>
    <br>

    <div class="container_btn_voltar">
        <a href="medlista.php"><button class="btn_voltar_med">Voltar</button></a>
    </div>

    <br>
    
    <div class="box-search">
        <input type="search" class="form-control w-25" placeholder="Pesquisar" id="pesquisar">
        <button onclick="searchData()" class="btn_med btn-primary">
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
                <th>MÉDICO</th>
                <th>PACIENTE</th>
                <th>DATA</th>
                <th>HORARIO</th>
            </tr>
        </thead>
        <tbody>
            <?php
            while ($tbl = mysqli_fetch_array($result)) {
                ?>
                <tr>
                    <td><?= $tbl["medico_nome"] ?></td>
                    <td><?= $tbl["paciente_nome"] ?></td>
                    <td><?= date('d/m/Y', strtotime($tbl["agen_data"])) ?></td>
                    <td><?= date('H:i', strtotime($tbl["agen_hora"])) ?></td>
                </tr>
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
        var searchValue = search.value;
        window.location.href = 'listaAgendados.php?search=' + encodeURIComponent(searchValue);
    }
</script>
</html>