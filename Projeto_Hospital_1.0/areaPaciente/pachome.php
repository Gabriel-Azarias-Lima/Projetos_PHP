<?php
 #AQUI VOCE FAZ O CODIGO DE LOGIN PHP RODAR NA MESMA PÁGINA

 #ABRE UMA VARIAVEL SESSÃO
 session_start();
 $nomepac = $_SESSION["nomepac"];
 $idpac = $_SESSION['idpac'];
 #SOLICITA O ARQUIVO CONECTADB
 include("../conectadb.php");



?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- ICON IMAGENS -->
    <link rel="shortcut icon" href="../imagem/favicon.ico">
    <link rel="stylesheet" href="../css/style.css">
    <!-- CSS font-awesome--> <!-- CSS Icones -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css" integrity="sha512-SzlrxWUlpfuzQ+pcUCosxcglQRNAq/DZjVsC0lE40xsADsfeQoEypE+enwcOiGjk/bSuGGKHEyjSoQ1zVisanQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- CSS CAROUSEL -->
    <link rel="stylesheet" href="https://unpkg.com/flickity@2/dist/flickity.min.css">
    <script src="https://unpkg.com/flickity@2/dist/flickity.pkgd.min.js"></script>

    <title>Clinica Vitacare</title>
</head>
<body class="pag_pac_home">
 <div class="wrapper-pac-home">
    <nav class="nav_pac">
        <div class="nav-logo">
            <p>CLINICA VITACARE</p>
        </div>

        <div class="nav-menu" id="navMenu">
            <ul>
                <li><a href="alteraCadastro.php?idpac=<?=$idpac?>" class="link-usuario"><?=strtoupper($nomepac)?></a></li>
                <li><a href="pachome.php" class="link active">Home</a></li>
                <li><a href="agendamentos.php" class="link">Agendamentos</a></li>
                <li><a href="trabalheconosco.php" class="link">Trabalher Conosco</a></li>
                <li><a href="../avaliacao/avaliacao_comLogin.php" class="link">Avaliação</a></li>
                <li><a href="logout.php" class="link-sair">Sair</a></li>
            </ul>
        </div>

        <div class="nav-menu" id="navMenu">
            <ul>
                
                <li><a href="logout.php" class="link-sair">Sair</a></li>
                

                <?php
                    #ABERTO O PHP PARA VALIDAR SE A SESSÃO DO USUARIO ESTÁ ABERTA
                    #SE SESSÃO ABERTA, FECHA O PHP PARA USAR ELEMENTOS HTML
                    if($nomepac != null){
                        ?>
                        <!-- USO DO ELEMENTO HTML COM PHP INTERNO -->
                        
                        <li class="nav-menu-perfil">
                            <a href="alteraCadastro.php?idpac=<?=$idpac?>"><?=strtoupper($nomepac)?></a>
                        </li>
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

            </ul>

            

        </div>



        <div class="nav-button">
            <a href="logout.php" class="nav-button"><button class="btn white-btn" id="loginBtn" onclick="login()">Sair</button></a>
        </div>
        
        <div class="nav-menu-btn">
            <i class="bx bx-menu" onclick="myMenuFunction()"></i>
        </div>
    </nav>  
</div>

<!-- Meio da pagina -->


<!-- BUSCA OS FUNCIONARIOS REGISTRADOS -->

<!-- IMAGEM DO MEIO DA PAGINA -->
        <section class="banner">
        
        </section>
<!-- FIM -->


<div class="container_pac">

    <div class="container_texto">
        <div class="pac_texto">
        <h1>Sobre nós</h1>
        <p>Na Clínica Vitacare, a sua saúde e bem-estar são a nossa principal prioridade. Somos 
            uma instituição dedicada a fornecer cuidados de saúde abrangentes e de alta qualidade, visando promover a 
            vitalidade e a qualidade de vida de nossos pacientes. Nossa missão é ser um parceiro confiável em sua jornada em 
            direção a uma vida saudável e plena.</p>
        </div>    
    </div>

</div>

<div class="carousel">
        <!-- Flickity HTML init -->
        <div class="gallery js-flickity" data-flickity-options='{ "wrapAround": true }'>
            <a href="agendaConsulta.php" class="gallery-cell1"><div></div></a>
            <a href="trabalheconosco.php" class="gallery-cell2"><div></div></a>
            <a href="#" class="gallery-cell3"><div></div></a>
        </div>
    </div>


<div class="container_localizacao">   


    <div class="container_horaroios">
        <div class="horarios">
            <h1>Horário</h1>

            
            <h3>Segunda a Sexta: <br> 07h00 as 16h00</h3>
            <h3>Sabado: <br> 08h00 as 13h00</h3>

        </div>

        <div class="telefone">

            <h1>Telefone</h1>
            <h3>(16) 3441-1077</h3>
            <h3>(16) 3441-1076</h3>
            <br>

            <h1>Whatsapp</h1>
            <h3>(16) 9 8104.7160</h3>
            
        </div>           
    </div>

        <div class="mapa">
        <iframe src="https://www.google.com/maps/embed?pb=!4v1691789553802!6m8!1m7!1sCAoSLEFGMVFpcE5YZE5EZElQS0JjSlZkanJhSVZiUTJFemZLXy1Jd0lTOTFFWGgz!2m2!1d-23.723499994154!2d-46.852643836087!3f304.96816607735843!4f35.93560685679779!5f0.7820865974627469" width="100%" height="600" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>
        
</div>

<!-- CONVENIOS PARCEIROS -->


<h1 class="h1_convenio">CONVÊNIOS ACEITOS</h1>
<div class="container_convenio">
    <div class="image-container">
        <div class="image-wrapper">
          <div>
            <img class="img_par" src="../imagem/convenios/bradesco_saude.jpg" alt="pedigree">
          </div>
          <div>
            <img class="img_par" src="../imagem/convenios/dix_saude.jpg" alt="purina">
          </div>
          <div>
            <img class="img_par" src="../imagem/convenios/hapvida.jpg" alt="royal canin">
          </div>
          <div>
            <img class="img_par" src="../imagem/convenios/porto_seguro.jpg" alt="zoetis">
          </div>
          <div>
            <img class="img_par" src="../imagem/convenios/são_miguel.jpg" alt="intersand">
          </div>
        </div>
      </div>
</div>

    <script> /* java script */
        const imageWrapper = document.querySelector('.image-wrapper')
const imageItems = document.querySelectorAll('.image-wrapper > *')
const imageLength = imageItems.length
const perView = 3
let totalScroll = 0
const delay = 2000

imageWrapper.style.setProperty('--per-view', perView)
for(let i = 0; i < perView; i++) {
  imageWrapper.insertAdjacentHTML('beforeend', imageItems[i].outerHTML)
}

let autoScroll = setInterval(scrolling, delay)

function scrolling() {
  totalScroll++
  if(totalScroll == imageLength + 1) {
    clearInterval(autoScroll)
    totalScroll = 1
    imageWrapper.style.transition = '0s'
    imageWrapper.style.left = '0'
    autoScroll = setInterval(scrolling, delay)
  }
  const widthEl = document.querySelector('.image-wrapper > :first-child').offsetWidth + 24
  imageWrapper.style.left = `-${totalScroll * widthEl}px`
  imageWrapper.style.transition = '.3s'
}
    </script>

    <!-- FIM CONVENIOS PARCEIROS-->



<!-- FIM Meio da Pagina -->

<!-- FOOTER -->

    <footer>
        <div class="footer-container">
            <h3>CLINICA VITACARE</h3>
            <p>Confira nossas redes Sociais</p>
            <ul class="socials">
                <li><a href="#"><i class="fa-brands fa-instagram"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-facebook"></i></a></li>
                <li><a href="#"><i class="fa-brands fa-whatsapp"></i></a></li>

            </ul>
        </div>
        <div class="footer-bottom">
            <p>Trabalho-TI22 &copy;2023 Senac RP. <span>CLINICA VITACARE</span></p>
        </div>
    </footer>

<!-- FIM FOOTER -->



<!-- FIM Footer -->

<script>
   
   function myMenuFunction() {
    var i = document.getElementById("navMenu");
    if(i.className === "nav-menu") {
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





</body>
</html>