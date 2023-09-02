<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <link rel="shortcut icon" href="../imagem/favicon.ico">

  <title>Avaliação</title>

  <link rel="stylesheet" href="../css/style_avaliacao.css">
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/custom.css">

  <!-- ICON IMG -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
  
  <script>
    $(document).ready(function() {
      $('#telefone').mask('(00) 00000-0000');
    });
  </script>
</head>
<body class="pag_avaliacao_pac">
  <a href="../areaPaciente/pachome.php" class="btn-voltar"><i class="fa-solid fa-reply"></i></a>
<body class="pag_avaliacao">
 

  <div class="text-form">
    <h1>Deixe a sua avaliação</h1>
    <form method="POST" action="processa_comLogin.php">
      <label for="nome">Nome:</label>
      <input type="text" id="nome" name="nome" required>
      
      <label for="telefone">Telefone:</label>
      <input type="tel" name="telefone" placeholder="Telefone" id="telefone" maxlength="15" required>
      
      <label for="mensagem">Mensagem:</label>
      <textarea id="mensagem" name="mensagem" rows="4" required></textarea>

      <fieldset class="rating">
        <input type="radio" id="star5" name="rating" value="5">
        <label class="full" for="star5" title="5 star"></label>
        
        <input type="radio" id="star4" name="rating" value="4">
        <label class="full" for="star4" title="4 stars"></label>
        
        <input type="radio" id="star3" name="rating" value="3">
        <label class="full" for="star3" title="3 stars"></label>
        
        <input type="radio" id="star2" name="rating" value="2">
        <label class="full" for="star2" title="2 stars"></label>
        
        <input type="radio" id="star1" name="rating" value="1">
        <label class="full" for="star1" title="1 star"></label>
      </fieldset>

      <input type="submit" value="Enviar">
    </form>
  </div>
</body>
</html>
