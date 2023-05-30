<?php
session_start();
if (!isset($_SESSION["username"])) {
    header("Location: index.html");
    exit();
}

// Conectar ao banco de dados
$conn = new mysqli("localhost", "root", "", "petshop");

// Verificar a conexão
if ($conn->connect_error) {
    die("Erro na conexão com o banco de dados: " . $conn->connect_error);
}

// Obter a lista de clientes para exibir no formulário
$sql = "SELECT id, nome FROM Clientes";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $clientes = $result->fetch_all(MYSQLI_ASSOC);
} else {
    $clientes = array();
}

// Verificar se o formulário foi enviado
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obter os dados do formulário
    $id_cliente = $_POST["id_cliente"];
    $data = $_POST["data"];
    $hora = $_POST["hora"];
    $descricao = $_POST["descricao"];

    // Inserir a nova consulta no banco de dados
    $sql = "INSERT INTO Consultas (id_cliente, data, hora, descricao) VALUES ('$id_cliente', '$data', '$hora', '$descricao')";

    if ($conn->query($sql) === TRUE) {
        echo "Consulta criada com sucesso!";
    } else {
        echo "Erro ao criar a consulta: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Espaço Pet</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Criar Consulta</h1>
        <form action="<?php echo $_SERVER["PHP_SELF"]; ?>" method="post">
            <select name="id_cliente">
                <?php foreach ($clientes as $cliente): ?>
                    <option value="<?php echo $cliente["id"]; ?>"><?php echo $cliente["nome"]; ?></option>
                <?php endforeach; ?>
            </select>
            <input type="date" name="data" required>
            <input type="time" name="hora" required>
            <textarea name="descricao" placeholder="Descrição da consulta" required></textarea>
            <input type="submit" value="Criar Consulta">
        </form>
    </div>
</body>
</html>
