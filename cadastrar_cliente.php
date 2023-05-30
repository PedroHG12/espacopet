<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.html");
    exit();
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os dados do formulário
    $nome = $_POST["nome"];
    $endereco = $_POST["endereco"];
    $telefone = $_POST["telefone"];
    $email = $_POST["email"];

    // Conectar ao banco de dados
    $conn = new mysqli("localhost", "root", "", "petshop");

    // Verificar a conexão
    if ($conn->connect_error) {
        die("Erro na conexão com o banco de dados: " . $conn->connect_error);
    }

    // Inserir o novo cliente no banco de dados
    $sql = "INSERT INTO Clientes (nome, endereco, telefone, email) VALUES ('$nome', '$endereco', '$telefone', '$email')";

    if ($conn->query($sql) === TRUE) {
        echo "Cliente cadastrado com sucesso!";
    } else {
        echo "Erro ao cadastrar o cliente: " . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Espaço Pet</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Cadastrar Cliente</h1>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <input type="text" name="nome" placeholder="Nome" required>
            <input type="text" name="endereco" placeholder="Endereço">
            <input type="text" name="telefone" placeholder="Telefone">
            <input type="text" name="email" placeholder="Email">
            <input type="submit" value="Cadastrar">
        </form>
    </div>
</body>
</html>
