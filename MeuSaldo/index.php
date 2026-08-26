<?php include "header.php" ?>
<?php
include "conexaoBD.php";
$idUsuario = (int) $idUsuario;

$sqlAnuncios = "SELECT
                    idAnuncio,
                    nomeProduto,
                    estoqueProduto,
                    categoriaAnuncio,
                    valorCustoAnuncio,
                    valorAnuncio
                FROM Anuncios
                WHERE Usuarios_idUsuario = $idUsuario
                ORDER BY idAnuncio DESC";

$resultadoAnuncios = mysqli_query($conn, $sqlAnuncios);

if (!$resultadoAnuncios) {
    die("Erro ao consultar os anúncios: " . mysqli_error($conn));
}

$quantidadeProdutos = mysqli_num_rows($resultadoAnuncios);

$sqlEstoque = "SELECT SUM(estoqueProduto) AS estoqueTotal
               FROM Anuncios
               WHERE Usuarios_idUsuario = $idUsuario";

$resultadoEstoque = mysqli_query($conn, $sqlEstoque);

$dadosEstoque = mysqli_fetch_assoc($resultadoEstoque);

$estoqueTotal = $dadosEstoque['estoqueTotal'] ?? 0;

$resultadoAnuncios = mysqli_query($conn, $sqlAnuncios);

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

        <div class="input-group">

            <input class="form-control"
                   type="text"
                   placeholder="Pesquisar..."
                   aria-label="Pesquisar" />

            <button class="btn btn-primary"
                    id="btnNavbarSearch"
                    type="button">

                <i class="fas fa-search"></i>

            </button>

        </div>

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

                        Início

                    </li>

                </ol>

                <div class="row">


                    <div class="col-xl-4 col-md-6">

                        <div class="card bg-primary text-white mb-4">

                            <div class="card-body">

                                <h5>

                                    Produtos cadastrados

                                </h5>

                                <h2>

                                    <?php

                                    echo $quantidadeProdutos;

                                    ?>

                                </h2>

                            </div>


                            <div class="card-footer d-flex align-items-center justify-content-between">

                                <span>

                                    Produtos

                                </span>

                                <i class="fas fa-box"></i>

                            </div>

                        </div>

                    </div>


                    <div class="col-xl-4 col-md-6">

                        <div class="card bg-success text-white mb-4">

                            <div class="card-body">

                                <h5>

                                    Estoque total

                                </h5>

                                <h2>

                                    <?php

                                    echo $estoqueTotal;

                                    ?>

                                </h2>

                            </div>


                            <div class="card-footer d-flex align-items-center justify-content-between">

                                <span>

                                    Unidades

                                </span>

                                <i class="fas fa-warehouse"></i>

                            </div>

                        </div>

                    </div>

                    <div class="col-xl-4 col-md-6">

                        <div class="card bg-warning text-white mb-4">

                            <div class="card-body">

                                <h5>

                                    Anúncios

                                </h5>

                                <h2>

                                    <?php

                                    echo $quantidadeProdutos;

                                    ?>

                                </h2>

                            </div>


                            <div class="card-footer d-flex align-items-center justify-content-between">

                                <span>

                                    Anúncios ativos

                                </span>

                                <i class="fas fa-tags"></i>

                            </div>

                        </div>

                    </div>


                </div>

                <?php

                if (
                    isset($_GET['cadastro']) &&
                    $_GET['cadastro'] == 'sucesso'
                ) {

                    ?>

                    <div class="alert alert-success alert-dismissible fade show">

                        <strong>Sucesso!</strong>

                        Produto cadastrado corretamente.

                        <button type="button"
                                class="btn-close"
                                data-bs-dismiss="alert">

                        </button>

                    </div>

                    <?php

                }

                ?>


                <div class="card mb-4">


                    <div class="card-header">

                        <i class="fas fa-table me-1"></i>

                        Anúncios cadastrados

                    </div>


                    <div class="card-body">

                        <div class="mb-3">

                            <a href="formAnuncio.php"
                               class="btn btn-primary">

                                <i class="fas fa-plus"></i>

                                Novo anúncio

                            </a>

                        </div>

                        <div class="table-responsive">


                            <table id="datatablesSimple">


                                <thead>

                                    <tr>

                                        <th>ID</th>

                                        <th>Produto</th>

                                        <th>Estoque</th>

                                        <th>Categoria</th>

                                        <th>Valor de custo</th>

                                        <th>Valor de venda</th>

                                    </tr>

                                </thead>


                                <tfoot>

                                    <tr>

                                        <th>ID</th>

                                        <th>Produto</th>

                                        <th>Estoque</th>

                                        <th>Categoria</th>

                                        <th>Valor de custo</th>

                                        <th>Valor de venda</th>

                                    </tr>

                                </tfoot>


                                <tbody>


                                <?php

                                if (
                                    $resultadoAnuncios &&
                                    mysqli_num_rows($resultadoAnuncios) > 0
                                ) {


                                    while (
                                        $anuncio =
                                        mysqli_fetch_assoc(
                                            $resultadoAnuncios
                                        )
                                    ) {


                                        ?>

                                        <tr>


                                            <!-- ID -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $anuncio['idAnuncio']
                                                );

                                                ?>

                                            </td>


                                            <!-- PRODUTO -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $anuncio['nomeProduto']
                                                );

                                                ?>

                                            </td>


                                            <!-- ESTOQUE -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $anuncio['estoqueProduto']
                                                );

                                                ?>

                                            </td>


                                            <!-- CATEGORIA -->

                                            <td>

                                                <?php

                                                echo htmlspecialchars(
                                                    $anuncio['categoriaAnuncio']
                                                );

                                                ?>

                                            </td>


                                            <!-- CUSTO -->

                                            <td>

                                                R$

                                                <?php

                                                echo number_format(
                                                    $anuncio[
                                                        'valorCustoAnuncio'
                                                    ],
                                                    2,
                                                    ',',
                                                    '.'
                                                );

                                                ?>

                                            </td>


                                            <!-- VENDA -->

                                            <td>

                                                R$

                                                <?php

                                                echo number_format(
                                                    $anuncio[
                                                        'valorAnuncio'
                                                    ],
                                                    2,
                                                    ',',
                                                    '.'
                                                );

                                                ?>

                                            </td>


                                        </tr>


                                        <?php

                                    }


                                } else {


                                    ?>


                                    <tr>

                                        <td colspan="6"
                                            class="text-center">

                                            <i class="fas fa-box-open fa-2x mb-2"></i>

                                            <br>

                                            Nenhum anúncio cadastrado.

                                        </td>

                                    </tr>


                                    <?php

                                }

                                ?>


                                </tbody>


                            </table>


                        </div>


                    </div>


                </div>


            </div>


        </main>


        <!-- =====================================================
             FOOTER
        ====================================================== -->

        <footer class="py-4 bg-light mt-auto">

            <div class="container-fluid px-4">

                <div class="d-flex align-items-center justify-content-between small">


                    <div class="text-muted">

                        MeuSaldo © 2026

                    </div>


                    <div>

                        <a href="#">

                            Privacidade

                        </a>

                        &middot;

                        <a href="#">

                            Termos

                        </a>

                    </div>


                </div>

            </div>

        </footer>


    </div>

</div>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>


<script src="js/scripts.js"></script>


<script src="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/umd/simple-datatables.min.js"
        crossorigin="anonymous"></script>


<script src="js/datatables-simple-demo.js"></script>


</body>

</html>