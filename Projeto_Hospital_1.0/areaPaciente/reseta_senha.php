<?php
 #AQUI VOCE FAZ O CODIGO DE LOGIN PHP RODAR NA MESMA PÁGINA

 #ABRE UMA VARIAVEL SESSÃO
 session_start();

 #SOLICITA O ARQUIVO CONECTADB
 require_once("../conectadb.php");



 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["email"], $_POST["telefone"], $_POST["cpf"])) {
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $cpf = $_POST['cpf'];

    // Verificar se as informações coincidem no banco de dados
    $stmt = $link->prepare("SELECT pac_nome FROM paciente WHERE pac_email = ? AND pac_telefone = ? AND pac_cpf = ?");
    $stmt->bind_param("sss", $email, $telefone, $cpf);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($nomepac);
        $stmt->fetch();
        $_SESSION['reset_email'] = $email;

        echo"<script>window.location.href='reseta_senhaForm.php';</script>";
    } else {
        echo "<script>window.alert('Informações incorretas. Verifique seu e-mail, número de telefone e CPF.');</script>";
        echo"<script>window.location.href='esqueci_minhasenha.php';</script>";
    }

    $stmt->close();
}

$link->close();

?>