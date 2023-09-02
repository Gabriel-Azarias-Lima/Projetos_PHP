<?php
include("../conectadb.php");

session_start();
$nomeadm = $_SESSION["nomeadm"];

#JÁ LISTA OS USUARIOS DO MEU BANCO
$sql = "SELECT * FROM medico WHERE med_ativo = 's'";
$retorno = mysqli_query($link, $sql);

#JÁ FORÇA TRAZER s NA VARIÁVEL ATIVO
$ativo = 's';

#COLETA O BOTÃO DE POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ativo = $_POST['ativo'];

    if ($ativo == 's') {
        $sql = "SELECT * FROM medico WHERE med_ativo = 's' ";
    } else {
        $sql = "SELECT * FROM medico WHERE med_ativo = 'n' ";
    }
} else {
    $ativo = isset($_GET['ativo']) ? $_GET['ativo'] : 's';  // Default to 's' if not provided
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $sql = "SELECT * FROM medico ";

    if ($ativo == 's') {
        $sql .= "WHERE med_ativo = 's' ";
    } elseif ($ativo == 'n') {
        $sql .= "WHERE med_ativo = 'n' ";
    }

    if (!empty($search)) {
        $sql .= "AND med_id LIKE '%$search%' OR med_nome LIKE '%$search%' OR med_senha LIKE '%$search%' OR med_email LIKE '%$search%' OR med_cpf LIKE '%$search%' OR med_especialidade LIKE '%$search%' OR med_horainicio LIKE '%$search%' OR med_horafim LIKE '%$search%' OR med_datanasc LIKE '%$search%' OR med_telefone LIKE '%$search%' OR med_cidade LIKE '%$search%' OR med_endereco LIKE '%$search%' OR med_numero LIKE '%$search%'";
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
    
    <link rel="stylesheet" href="../css/style_list.css">
    <title>Lista Médico</title>

</head>
<body>

<!-- BLOQUEIA A PÁGINA PARA USUÁRIOS NÃO CADASTRADOS -->

<?php
                    #ABERTO O PHP PARA VALIDAR SE A SESSÃO DO USUARIO ESTÁ ABERTA
                    #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
                    if($nomeadm != null){
                        ?>

                        <?php

                    }
                    else{
                        echo($sql);
                        echo"<script>window.alert('USUARIO NÃO AUTENTICADO');
                        window.location.href='admlogin.php';</script>";
                    }
                    #FIM DO PHP PARA CONTINUAR MEU HTML
                ?>

<!-- FIM BLOQUEIA PAGINA -->


    <br>
    <h1>Lista Médico</h1>
    <br>

    <div class="container_btn_voltar">
        <a href="admlista.php"><button class="btn_voltar_med">Voltar</button></a>
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
        <form action="listaMedico.php" method="post">

        <div class="container_radio_label">

        <label class="radio_label">ATIVOS <br>
            <input type="radio" name="ativo" class="radio" value="s" required
                onclick="submit()" <?= $ativo == 's' ? "checked" : "" ?>>
        </label>

        <label class="radio_label">INATIVOS <br>
            <input type="radio" name="ativo" class="radio" value="n" required
                onclick="submit()" <?= $ativo == 'n' ? "checked" : "" ?>>
        </label>

        </div>

        </form>

        <table class="table text-white table-bg">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Senha</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Data de Nascimento</th>
                    <th>Especialidade</th>
                    <th>Inicio Expediante</th>
                    <th>Fim Expediante</th>
                    <th>Telefone</th>
                    <th>Cidade</th>
                    <th>Endereço</th>
                    <th>Numero</th>
                    <th>Ativo?</th>
                    <th>Alterar</th>
                </tr>     
            </thead>
            <tbody>
            <?php
                    while($tbl = mysqli_fetch_array($retorno)){
                ?>
                    <tr>
                        <td><?= $tbl[0]?></td> <!-- ID -->
                        <td><?= $tbl[1]?></td> <!-- nome -->
                        <td><?= $tbl[2]?></td> <!-- senha -->
                        <td><?= $tbl[3]?></td> <!-- email -->
                        <td><?= $tbl[4]?></td> <!-- cpf -->
                        <td><?= date('d/m/Y', strtotime($tbl[8])) ?></td> <!-- datanasc -->
                        <td><?= $tbl[5]?></td> <!-- especialidade -->
                        <td><?= date('H:i', strtotime($tbl[6])) ?></td> <!-- horainicio -->
                        <td><?= date('H:i', strtotime($tbl[7])) ?></td> <!-- horafim -->
                        <td><?= $tbl[9]?></td> <!-- telefone -->
                        <td><?= $tbl[10]?></td> <!-- cidade -->
                        <td><?= $tbl[11]?></td> <!-- endereco -->
                        <td><?= $tbl[12]?></td> <!-- numero -->
                        <td><?=$check =($tbl[14] == 's')?"SIM":"NÃO"?></td> <!-- ativo -->
                        
                        <td><a class="btn btn_altera_med btn-sm btn-primary" href="EditMedico.php?id=<?= $tbl[0]?>" title="Editar">
    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
        class="bi bi-pencil" viewBox="0 0 16 16">
        <path
            d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
    </svg>
</a></td>
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
        var ativoValue = document.querySelector('input[name="ativo"]:checked').value;
        var searchValue = search.value;
        
        window.location = 'listaMedico.php?ativo=' + ativoValue + '&search=' + encodeURIComponent(searchValue);
    }
</script>
</html>