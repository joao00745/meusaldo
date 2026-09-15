<?php
session_start();

include "conexaoBD.php";



$descricao = $_POST['descricaoDespesa'];
$valor = $_POST['valorDespesa'];
$tipo = "Despesa";

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
    echo "Erro ao cadastrar despesa: " . mysqli_error($conn);
}
?>
?>