<?php
include("../conectadb.php");
#A SESSÃO DO USUARIO DO ADMINISTRADOR

session_start();
$nomeatendente = $_SESSION["nomeatendente"];

#JÁ LISTA OS USUARIOS DO MEU BANCO
$sql = "SELECT * FROM paciente WHERE pac_ativo = 's'";
$retorno = mysqli_query($link, $sql);

#JÁ FORÇA TRAZER s NA VARIÁVEL ATIVO
$ativo = 's';

#COLETA O BOTÃO DE POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ativo = $_POST['ativo'];

    #VERIFICA SE USUARIO ESTÁ ATIVO PARA LISTAR
    if ($ativo == 's') {
        $sql = "SELECT * FROM paciente WHERE pac_ativo = 's' ";
    } else {
        $sql = "SELECT * FROM paciente WHERE pac_ativo = 'n' ";
    }
} else {
    $ativo = isset($_GET['ativo']) ? $_GET['ativo'] : 's';  // Default to 's' if not provided
    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $sql = "SELECT * FROM paciente ";

    if ($ativo == 's') {
        $sql .= "WHERE pac_ativo = 's' ";
    } elseif ($ativo == 'n') {
        $sql .= "WHERE pac_ativo = 'n' ";
    }

    if (!empty($search)) {
        $sql .= "AND pac_id LIKE '%$search%' OR pac_nome LIKE '%$search%' OR pac_senha LIKE '%$search%' OR  pac_email LIKE '%$search%' OR pac_cpf LIKE '%$search%' OR  pac_datanasc LIKE '%$search%' OR pac_telefone LIKE '%$search%' OR pac_cidade LIKE '%$search%' OR pac_endereco LIKE '%$search%' OR pac_numero LIKE '%$search%'OR pac_sexo LIKE '%$search%'";
    }
}

$retorno = mysqli_query($link, $sql);
?>

<!DOCTYPE html>
<html lang="pt br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="shortcut icon" href="../imagem/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="../css/style_list.css">
    <title>LISTA PACIENTES</title>
</head>

<body class="pag_atendente">

  


<br>
    <h1>Lista Paciente</h1>
    <br>

    <div class="container_btn_voltar">
        <a href="atendentehome.php"><button class="btn_voltar_aten">Voltar</button></a>
    </div>

    <br>




    <div class="box-search">
        <input type="search" class="form-control w-25" placeholder="Pesquisar" id="pesquisar">
        <button onclick="searchData()" class="btn_aten btn-primary">
            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
            </svg>
        </button>
    </div>



    <div class="m-5">
        <form action="listapaciente.php" method="post">

            <div class="container_radio_label">

                <label class="radio_label">ATIVOS <br>
                    <input type="radio" name="ativo" class="radio" value="s" required onclick="submit()" <?= $ativo == 's' ? "checked" : "" ?>>
                </label>

                <label class="radio_label">INATIVOS <br>
                    <input type="radio" name="ativo" class="radio" value="n" required onclick="submit()" <?= $ativo == 'n' ? "checked" : "" ?>>
                </label>

            </div>
            <br>
        </form>

        <table class="table text-white table-bg">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nome</th>
                    <th>Email</th>
                    <th>CPF</th>
                    <th>Data de Nascimento</th>
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
                while ($tbl = mysqli_fetch_array($retorno)) {
                ?>
                    <tr>
                        <td><?= $tbl[0] ?></td> <!-- ID -->
                        <td><?= $tbl[1] ?></td> <!-- nome -->
 
                        <td><?= $tbl[3] ?></td> <!-- email -->
                        <td><?= $tbl[4] ?></td> <!-- cpf -->
                        <td><?= $tbl[5] ?></td> <!-- datanasc -->
                        <td><?= $tbl[6] ?></td> <!-- telefone -->
                        <td><?= $tbl[7] ?></td> <!-- cidade -->
                        <td><?= $tbl[8] ?></td> <!-- endereco -->
                        <td><?= $tbl[9] ?></td> <!-- numero -->
    
                        <td><?= $check = ($tbl[11] == 's') ? "SIM" : "NÃO" ?></td> <!-- ativo -->

                        <td><a class="btn btn_altera_pac btn-sm btn-primary" href="alterapaciente.php?id=<?= $tbl[0] ?>" title="Editar">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil" viewBox="0 0 16 16">
                                    <path d="M12.146.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1 0 .708l-10 10a.5.5 0 0 1-.168.11l-5 2a.5.5 0 0 1-.65-.65l2-5a.5.5 0 0 1 .11-.168l10-10zM11.207 2.5 13.5 4.793 14.793 3.5 12.5 1.207 11.207 2.5zm1.586 3L10.5 3.207 4 9.707V10h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.293l6.5-6.5zm-9.761 5.175-.106.106-1.528 3.821 3.821-1.528.106-.106A.5.5 0 0 1 5 12.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.468-.325z" />
                                </svg>
                            </a></td>
                    <?php
                }
                    ?>
            </tbody>
        </table>
    </div>











    <!-- FIM Meio da Pagina -->


    <!-- Footer -->

    <!-- FIM Footer -->






</body>
<script>
    function myMenuFunction() {
        var i = document.getElementById("navMenu");
        if (i.className === "nav-menu") {
            i.className += " responsive";
        } else {
            i.className = "nav-menu";
        }
    }
</script>
<script>
    var a = document.getElementById("loginBtn");
    var b = document.getElementById("registerBtn");
    var x = document.getElementById("login");
    var y = document.getElementById("register");

    function login() {
        x.style.left = "4px";
        y.style.right = "-520px";
        a.className += " white-btn";
        b.className = "btn";
        x.style.opacity = 1;
        y.style.opacity = 0;
    }

    function register() {
        x.style.left = "-510px";
        y.style.right = "5px";
        a.className = "btn";
        b.className += " white-btn";
        x.style.opacity = 0;
        y.style.opacity = 1;
    }
</script>



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

        window.location = 'listapaciente.php?ativo=' + ativoValue + '&search=' + encodeURIComponent(searchValue);
    }
</script>

</html>