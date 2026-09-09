<?php
session_start();

include "conexaoBD.php";



$descricao = $_POST['descricaoReceita'];
$valor = $_POST['valorReceita'];
$tipo = "Receita";

$idUsuario = $_SESSION['idUsuario'];



$sql = "INSERT INTO Movimentacoes
        (descricao, valor, tipo, Usuarios_idUsuario)
        VALUES
        ('$descricao', '$valor', '$tipo', '$idUsuario')";



$resultado = mysqli_query($conn, $sql);



if ($resultado) {
    header("Location: movimentacao.php");
    exit;
} else {
    echo "Erro ao cadastrar receita: " . mysqli_error($conn);
}
?>
?>