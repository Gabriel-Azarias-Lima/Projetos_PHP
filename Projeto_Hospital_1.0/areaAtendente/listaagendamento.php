    <?php
    include("../conectadb.php");
    session_start();
    $nomeatendente = $_SESSION["nomeatendente"];

    $sql = "SELECT agen.*, pac.pac_nome, pac.pac_cpf, med.med_nome, med.med_especialidade
            FROM agendamento AS agen
            LEFT JOIN paciente AS pac ON agen.fk_pac_id = pac.pac_id
            LEFT JOIN medico AS med ON agen.fk_med_id = med.med_id
            WHERE agen_finalizado = 's'";

    $retorno = mysqli_query($link, $sql);

    $finalizado = 's';

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $finalizado = $_POST['finalizado'];

        if ($finalizado == 's') {
            $sql = "SELECT agen.*, pac.pac_nome, pac.pac_cpf, med.med_nome, med.med_especialidade
                    FROM agendamento AS agen
                    LEFT JOIN paciente AS pac ON agen.fk_pac_id = pac.pac_id
                    LEFT JOIN medico AS med ON agen.fk_med_id = med.med_id
                    WHERE agen_finalizado = 's'";
        } elseif ($finalizado == 'n') {
            $sql = "SELECT agen.*, pac.pac_nome, pac.pac_cpf, med.med_nome, med.med_especialidade
                    FROM agendamento AS agen
                    LEFT JOIN paciente AS pac ON agen.fk_pac_id = pac.pac_id
                    LEFT JOIN medico AS med ON agen.fk_med_id = med.med_id
                    WHERE agen_finalizado = 'n' AND (fk_pac_id IS NOT NULL OR fk_med_id IS NOT NULL)";
        } elseif ($finalizado == 'empty') {
            $sql = "SELECT agen.*, pac.pac_nome, pac.pac_cpf, med.med_nome, med.med_especialidade
                    FROM agendamento AS agen
                    LEFT JOIN paciente AS pac ON agen.fk_pac_id = pac.pac_id
                    LEFT JOIN medico AS med ON agen.fk_med_id = med.med_id
                    WHERE (fk_pac_id IS NULL OR fk_med_id IS NULL)";
        }
    } else {
        $finalizado = isset($_GET['finalizado']) ? $_GET['finalizado'] : 's';
        $search = isset($_GET['search']) ? $_GET['search'] : '';

        $sql = "SELECT agen.*, pac.pac_nome, pac.pac_cpf, med.med_nome, med.med_especialidade
                FROM agendamento AS agen
                LEFT JOIN paciente AS pac ON agen.fk_pac_id = pac.pac_id
                LEFT JOIN medico AS med ON agen.fk_med_id = med.med_id";

        if ($finalizado == 's') {
            $sql .= " WHERE agen_finalizado = 's' ";
        } elseif ($finalizado == 'n') {
            $sql .= " WHERE agen_finalizado = 'n' ";
        }

        if (!empty($search)) {
            $sql .= "AND (agen_id LIKE '%$search%' OR fk_pac_id LIKE '%$search%' OR fk_med_id LIKE '%$search%' OR agen_data LIKE '%$search%' OR agen_hora LIKE '%$search%' OR pac_datanasc LIKE '%$search%' OR pac_telefone LIKE '%$search%' OR pac_cidade LIKE '%$search%')";
        }
    }



    $retorno = mysqli_query($link, $sql);
    ?>

    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <!-- ... (head content remains the same) ... -->
    </head>

    <body class="pag_atendente">
        <!-- ... (body content remains the same) ... -->
    </body>

    </html>


    <!DOCTYPE html>
    <html lang="pt-br">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="shortcut icon" href="../imagem/favicon.ico">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        
        <link rel="stylesheet" href="../css/style_listAten.css">
        <title>Lista Agendamento</title>
        
    </head>

    <body class="pag_atendente">
        <br>
        <h1>Lista Agendamento</h1>
        <br>

        <!-- Botão de voltar -->
        <div class="container_btn_voltar">
        <a href="agendamento.php"><button class="btn_voltar_aten">Voltar</button></a>
        </div>

        <br>

        <div class="box-search">
            <input type="search" class="form-control w-25" placeholder="Pesquisar" id="pesquisar">
            <button class="btn_aten btn-primary" id="pesquisarBtn">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
        </svg>
    </button>
        </div>

        <div class="m-5">
            <form action="listaagendamento.php" method="post">
                <div class="container_radio_label d-flex justify-content-between">
                    <label class="radio_label">
                        <input type="radio" name="finalizado" class="radio" value="empty" required onclick="submit()" <?= $finalizado == 'empty' ? "checked" : "" ?>>
                        HORÁRIOS LIVRES
                    </label>

                    <label class="radio_label">
                        <input type="radio" name="finalizado" class="radio" value="n" required onclick="submit()" <?= $finalizado == 'n' ? "checked" : "" ?>>
                        HORÁRIOS PREENCHIDOS
                    </label>

                    <label class="radio_label">
                        <input type="radio" name="finalizado" class="radio" value="s" required onclick="submit()" <?= $finalizado == 's' ? "checked" : "" ?>>
                        FINALIZADOS
                    </label>
                </div>
            </form>
        </div>

        <br>

        <table class="table text-white table-bg">
    <thead>
        <tr>
            <th>#</th>
            <?php if ($finalizado !== 'empty') { ?>
                <th>CPF</th>
                <th>NOME PACIENTE</th>
            <?php } ?>
            <th>NOME MÉDICO</th> <!-- Display doctor's name first -->
            <th>MODALIDADE DO MÉDICO</th> <!-- Display doctor's specialty next -->
            <th>DATA</th>
            <th>HORÁRIO</th>
            <th>PRESENTE?</th>
            <th>FINALIZADO?</th>
            <th>EDITAR</th>
        </tr>
    </thead>

    <tbody>
        <?php
        while ($tbl = mysqli_fetch_array($retorno)) {
            if ($finalizado !== 'empty' && $tbl['fk_pac_id'] === null) {
                continue;
            }
        ?>
            <tr>
            <td><?= $tbl[0] ?></td>
                <?php if ($finalizado !== 'empty') { ?>
                    <td><?= $tbl['pac_cpf'] ?></td>
                    <td><?= $tbl['pac_nome'] ?></td>
                <?php } ?>
                <td><?= $tbl['med_nome'] ?></td> <!-- Display doctor's name -->
                <td><?= $tbl['med_especialidade'] ?></td> <!-- Display doctor's specialty -->
                <td><?= $tbl[3] ?></td>
                <td><?= $tbl[4] ?></td>
                <td><?= $check = ($tbl[6] == 's') ? "SIM" : "NÃO" ?></td>
                <td><?= $check = ($tbl[7] == 's') ? "SIM" : "NÃO" ?></td>
                <td>
    <?php if ($tbl[6] !== 'Horario Livre') { ?>
        <a class="btn btn_altera_pac btn-sm btn-primary" href="alteraagendamento.php?id=<?= $tbl[0] ?>&cpf_paciente=<?= $tbl['pac_cpf'] ?>" title="Editar">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
            </svg>
        </a>
        
        <?php if ($tbl['fk_pac_id'] === null) { ?>
            <a class="btn btn_move_finalizado btn-sm btn-success" href="javascript:void(0)" title="Deletar" onclick="confirmDelete(<?= $tbl[0] ?>)">

            <svg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='currentColor' class='bi bi-trash-fill' viewBox='0 0 16 16'>
            <path d='M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z'/>
        </svg>
</a>


        <?php } ?>
    <?php } ?>
</td>

            </tr>
        <?php
        }
        ?>
    </tbody>
    </table>

        </div>


        
        <script>
            console.log("Script carregado");

            document.addEventListener("DOMContentLoaded", function() {
        const searchButton = document.querySelector("#pesquisarBtn");
        searchButton.addEventListener("click", searchData);

        const searchInput = document.getElementById("pesquisar");
        searchInput.addEventListener("keyup", function(event) {
            if (event.key === "Enter") {
                searchData();
            }
        });
    });


            function searchData() {
                const searchTerm = document.getElementById("pesquisar").value.trim().toLowerCase();

                const rows = document.querySelectorAll("tbody tr");
                rows.forEach(row => {
                    const rowText = row.innerText.toLowerCase();
                    if (rowText.includes(searchTerm)) {
                        row.style.display = "table-row";
                    } else {
                        row.style.display = "none";
                    }
                });
            }
        </script>
        
        <script>
    function confirmDelete(agenId) {
        const confirmation = confirm("Tem certeza que deseja deletar este agendamento?");
        if (confirmation) {
            window.location.href = `movefinalizado.php?id=${agenId}`;
        }
    }
</script>

    </body>
    </html>