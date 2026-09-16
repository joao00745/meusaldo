<?php

include "conexaoBD.php";

$id = $_GET['id'];

$sql = "DELETE FROM Movimentacoes
        WHERE idMovimentacao = $id";

mysqli_query($conn, $sql);

header("Location: movimentacao.php");
exit;

?>