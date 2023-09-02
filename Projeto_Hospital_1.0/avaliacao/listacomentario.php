<?php
include("../conectadb.php"); // Certifique-se de ter um arquivo conectadb.php que realiza a conexão com o banco de dados.

$sql = "SELECT * FROM avaliacao"; // Consulta para selecionar todos os comentários.
$retorno = mysqli_query($link, $sql); // Executa a consulta.

// HTML da página.
?>
<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Avaliações</title>
    <link rel="stylesheet" href="../css/style_avaliacao.css"> <!-- Inclua os estilos que você está usando. -->
    <link rel="shortcut icon" href="../imagem/favicon.ico">

 <!-- ICON IMG -->
 <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        /* Estilo adicional para a célula de mensagem com quebras de linha */
        .comentarios-lista td.mensagem {
            white-space: pre-line;
        }
    </style>
</head>
<body class="pag_avaliacao">
    <a href="../areaAdm/admhome.php" class="btn-voltar"><i class="fa-solid fa-reply"></i></a>

    <div class="comentarios-lista">
        <h1>Lista de Avaliações</h1>

        <table>
            <tr>
                <th>Nome</th>
                <th>Telefone</th>
                <th>Mensagem</th>
                <th>Avaliação</th>
            </tr>
            <?php
            // Loop através dos resultados da consulta.
            while ($tbl = mysqli_fetch_array($retorno)) {
                ?>
                <tr>
                    <td><?= $tbl[1] ?></td>
                    <td><?= $tbl[2] ?></td>
                    <td class="mensagem"><textarea readonly><?= $tbl[3] ?></textarea></td>
                    <td class="estrelas">
                        <?php
                        // Exibir estrelas de acordo com a avaliação
                        for ($i = 0; $i < $tbl[4]; $i++) {
                            echo '<i class="fas fa-star"></i>'; // Ícone de estrela cheia
                        }
                        ?>
                    </td>
                </tr>
            <?php
            }
            ?>
        </table>
    </div>
</body>
</html>
