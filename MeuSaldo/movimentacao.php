<?php include "header.php"; include "conexaoBD.php" ;
session_start();

//DESPESA

$sqlDespesa = "SELECT SUM(estoqueProduto * valorCustoAnuncio) AS despesaTotal
               FROM Anuncios
               WHERE Usuarios_idUsuario = $idUsuario";

$resultadoDespesa = mysqli_query($conn, $sqlDespesa);

$dadosDespesa = mysqli_fetch_assoc($resultadoDespesa);

$despesaTotal = $dadosDespesa['despesaTotal'] ?? 0;  


//RECEITA

$sqlReceita = "SELECT SUM(estoqueProduto * valorAnuncio) AS receitaTotal
               FROM Anuncios
               WHERE Usuarios_idUsuario = $idUsuario";

$resultadoReceita = mysqli_query($conn, $sqlReceita);

$dadosReceita = mysqli_fetch_assoc($resultadoReceita);

$receitaTotal = $dadosReceita['receitaTotal'] ?? 0 ;





//Movimentação Despesa
$sqlOutrasDespesas = "SELECT SUM(valor) AS total
                      FROM Movimentacoes
                      WHERE tipo = 'despesa'
                      AND Usuarios_idUsuario = $idUsuario";

$resultadoOutrasDespesas = mysqli_query($conn, $sqlOutrasDespesas);
$dadosOutrasDespesas = mysqli_fetch_assoc($resultadoOutrasDespesas);
$outrasDespesas = $dadosOutrasDespesas['total'] ?? 0;

//Movimentação receita
$sqlOutrasReceitas = "SELECT SUM(valor) AS total
                      FROM Movimentacoes
                      WHERE tipo = 'receita'
                      AND Usuarios_idUsuario = $idUsuario";

$resultadoOutrasReceitas = mysqli_query($conn, $sqlOutrasReceitas);
$dadosOutrasReceitas = mysqli_fetch_assoc($resultadoOutrasReceitas);
$outrasReceitas = $dadosOutrasReceitas['total'] ?? 0;


//Soma receita
$receitaTotalizada = $outrasReceitas + $receitaTotal;

//Soma Despesa
$despesaTotalizada = $outrasDespesas + $despesaTotal;

//Lucro Venda
session_start();

$lucroVenda = $_SESSION['lucroVenda'];
//LUCRO TOTAL
$lucroTotal = ($outrasReceitas - $outrasDespesas) + $lucroVenda;

?>
<!DOCTYPE html>

<html lang="pt-br">

<head>

    <meta charset="utf-8" />

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="viewport"
          content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <meta name="description" content="" />

    <meta name="author" content="" />

    <title>MeuSaldo</title>

    <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css"
          rel="stylesheet" />

    <link href="css/styles.css"
          rel="stylesheet" />

    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js"
            crossorigin="anonymous"></script>

</head>


<body class="sb-nav-fixed">


<nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">

    <a class="navbar-brand ps-3"
       href="index.php">

        MeuSaldo

    </a>


    <button class="btn btn-link btn-sm order-1 order-lg-0 me-4 me-lg-0"
            id="sidebarToggle"
            href="#!">

        <i class="fas fa-bars"></i>

    </button>


    <form class="d-none d-md-inline-block form-inline ms-auto me-0 me-md-3 my-2 my-md-0">

        

    </form>

    <?php
        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
            echo"
            <ul class='navbar-nav ms-auto ms-md-0 me-3 me-lg-4'>

                <li class='nav-item dropdown'>

                    <a class='nav-link '
                    id='navbarDropdown'
                    href='#'
                    role='button'
                    data-bs-toggle=dropdown'
                    aria-expanded='false'>
                        <i class='fas fa-user fa-fw'></i>

                    </a>
        ";
        }
        else{
            echo"
            <ul class='navbar-nav ms-auto ms-md-0 me-3 me-lg-4'>
                <li class='nav-item dropdown'>

                    <a class='nav-link'
                    id='navbarDropdown'
                    href='formLogin.php'
                    role='button'
                    data-bs-toggle=dropdown'
                    aria-expanded='false'>

                        <i class='fas fa-user fa-fw'></i>
                        Login

                    </a>
            </ul>
            ";
        }
    ?>

</nav>



<div id="layoutSidenav">
    <div id="layoutSidenav_nav">

        <nav class="sb-sidenav accordion sb-sidenav-dark"
             id="sidenavAccordion">


            <div class="sb-sidenav-menu">

                <div class="nav">


                    <div class="sb-sidenav-menu-heading">

                        MeuSaldo

                    </div>
                    <a class="nav-link"
                       href="index.php">

                        <div class="sb-nav-link-icon">

                            <i class="fas fa-home"></i>

                        </div>

                        Início

                    </a>
                    <?php
                        if(isset($_SESSION['logado']) && $_SESSION['logado'] === true){
                        echo"
                            <a class='nav-link'
                            href='formAnuncio.php'>

                                <div class='sb-nav-link-icon'>

                                    <i class='fas fa-plus'></i>

                                </div>

                                Criar anúncio

                            </a>

                            <a class='nav-link'
                            href='listaProdutos.php'>

                                <div class='sb-nav-link-icon'>

                                    <i class='fas fa-box'></i>

                                </div>

                                Produtos

                            </a>

                            <a class='nav-link'
                            href='movimentacao.php'>

                                <div class='sb-nav-link-icon'>

                                    $

                                </div>

                                Movimentação

                            </a>


                            <a class='nav-link'
                            href='logout.php'>

                                <div class='sb-nav-link-icon'>

                                    <i class='fas fa-sign-out-alt'></i>

                                </div>

                                Sair

                            </a>
                            ";
                        }
                        else{
                            echo"
                            <a class='nav-link'
                            href='formLogin.php'>

                                <div class='sb-nav-link-icon'>

                                    <i class='fas fa-sign-out-alt'></i>

                                </div>

                                Login

                            </a>
                            ";
                        
                        }
                    ?>


                </div>

            </div>


            <div class="sb-sidenav-footer">

                <div class="small">

                    Usuário conectado:

                </div>

                <?php
                
                if (isset($primeiroNome)) {

                    echo htmlspecialchars($primeiroNome);

                } else {

                    echo "Nenhum usuário conectado";

                }

                ?>

            </div>


        </nav>

    </div>

    <div id="layoutSidenav_content">


        <main>


            <div class="container-fluid px-4">



                <h1 class="mt-4">

                    MeuSaldo

                </h1>


                <ol class="breadcrumb mb-4">

                    <li class="breadcrumb-item active">

                        Movimentações

                    </li>

                </ol>

                <div class="row">
                    <div class="col-xl-4 col-md-6">

                        <div class="card bg-danger text-white mb-4">

                            <div class="card-body">

                                <h5>

                                    Despesa Total

                                </h5>

                                <h2>

                                    <?php
                                    echo " R$ - $outrasDespesas";

                                    ?>

                                </h2>

                            </div>


                            <div class="card-footer d-flex align-items-center justify-content-between">

                                <span>

                                    Custos

                                </span>

                                <i class="fas fa-box"></i>

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-4 col-md-6">

                        <div class="card bg-primary text-white mb-4">

                            <div class="card-body">

                                <h5>

                                    Receita Total

                                </h5>

                                <h2>

                                    <?php

                                    echo "R$ + $outrasReceitas";

                                    ?>

                                </h2>

                            </div>


                            <div class="card-footer d-flex align-items-center justify-content-between">

                                <span>

                                    Ganhos Brutos

                                </span>

                                <i class="fas fa-warehouse"></i>

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-4 col-md-6">

                        <div class="card bg-success text-white mb-4">

                            <div class="card-body">

                                <h5>

                                    Lucro Total

                                </h5>

                                <h2>

                                    <?php

                                    echo "R$ $lucroTotal";

                                    ?>

                                </h2>

                            </div>


                            <div class="card-footer d-flex align-items-center justify-content-between">

                                <span>

                                    Lucro Líquido

                                </span>

                                <i class="fas fa-tags"></i>

                            </div>

                        </div>

                    </div>


                </div>
                <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Movimentações
                </div>

                <div class="card-body">
                    <a href="formDespesa.php" class="btn btn-danger mb-3">
                        <i class="fas fa-plus"></i>
                        Adicionar despesa
                    </a>
                    <a href="formReceita.php" class="btn btn-primary mb-3">
                        <i class="fas fa-plus"></i>
                        Adicionar receita
                    </a>
                    
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Descrição</th>
                                <th>Valor</th>
                                <th>Tipo</th>
                            </tr>
                        </thead>

                        <tbody>

                            <?php

                            $sqlMovimentacoes = "SELECT idMovimentacao, descricao, valor, tipo
                                                FROM movimentacoes
                                                WHERE Usuarios_idUsuario = $idUsuario";

                            $resultadoMovimentacoes = mysqli_query($conn, $sqlMovimentacoes);

                            while ($movimentacao = mysqli_fetch_assoc($resultadoMovimentacoes)) {
                                
                            ?>
                            

                                <tr>
                                    <td>
                                        <?php echo htmlspecialchars($movimentacao['descricao']); ?>
                                    </td>

                                    <td>
                                        R$ <?php echo number_format($movimentacao['valor'], 2, ',', '.'); ?>
                                    </td>

                                    <td>
                                        <?php echo htmlspecialchars($movimentacao['tipo']); ?>
                                    </td>
                                    <td>
                                        <a href="removerDespesa.php?id=<?php echo $movimentacao['idMovimentacao']; ?>"
                                        class="btn btn-danger btn-sm"
                                        onclick="return confirm('Tem certeza que deseja excluir esta movimentação?');">
                                            Excluir
                                        </a>
                                    </td>
                                </tr>


                            <?php
                            }
                            ?>

                        </tbody>
                        
                    </table>
                    <form action="venderProduto.php" method="POST">

                    <label>Produto:</label>

                    <select name="idAnuncio" required>
                        <option value="">Selecione um produto</option>

                        <?php
                        $sqlProdutos = "SELECT idAnuncio, nomeProduto, estoqueProduto
                                        FROM Anuncios
                                        WHERE Usuarios_idUsuario = $idUsuario";

                        $resultadoProdutos = mysqli_query($conn, $sqlProdutos);

                        while ($produto = mysqli_fetch_assoc($resultadoProdutos)) {
                        ?>

                            <option value="<?php echo $produto['idAnuncio']; ?>">
                                <?php echo $produto['nomeProduto']; ?>
                                - Estoque: <?php echo $produto['estoqueProduto']; ?>
                            </option>

                        <?php
                        }
                        ?>

                    </select>

                    
                    <br><br>

                    <label>Quantidade</label>

                    <input type="number" name="quantidade" min="1" required>

                    <br><br>

                    <button type="submit" class="btn btn-primary mb-3">
                        Registrar venda
                    </button>
                    

                </form>
                <table class="table table-bordered">

    <thead>
        <tr>
            <th>Produto</th>
            <th>Quantidade</th>
            <th>Ação</th>
        </tr>
    </thead>

    <tbody>

        <?php

        $sqlVendas = "SELECT V.idVenda,
                             V.quantidadeVendida,
                             A.nomeProduto
                      FROM Vendas V
                      INNER JOIN Anuncios A
                      ON V.Anuncios_idAnuncios = A.idAnuncio
                      WHERE A.Usuarios_idUsuario = $idUsuario";

        $resultadoVendas = mysqli_query($conn, $sqlVendas);

        while ($venda = mysqli_fetch_assoc($resultadoVendas)) {

        ?>

            <tr>

                <td>
                    <?php echo htmlspecialchars($venda['nomeProduto']); ?>
                </td>

                <td>
                    <?php echo $venda['quantidadeVendida']; ?>
                </td>

                <td>

                    <form action="removerVenda.php" method="POST">

                        <input type="hidden"
                               name="idVenda"
                               value="<?php echo $venda['idVenda']; ?>">

                        <button type="submit"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Tem certeza que deseja remover esta venda?');">
                            Remover venda
                        </button>

                    </form>

                </td>

            </tr>

        <?php
        }
        ?>

    </tbody>

</table>
                </div>
            </div>