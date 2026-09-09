<?php include "header.php" ?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>MeuSaldo</title>
        <link href="https://cdn.jsdelivr.net/npm/simple-datatables@7.1.2/dist/style.min.css" rel="stylesheet" />
        <link href="css/styles.css" rel="stylesheet" />
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    </head>
    <body class="sb-nav-fixed bg-primary" >
        <nav class="sb-topnav navbar navbar-expand navbar-dark bg-dark">
            <!-- Navbar Brand-->
            <a class="navbar-brand ps-3" href="index.php">Início</a>
            
        </nav>

    !--Formulário do Anuncio--!
     <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">
                                    <div class="card-header"><h3 class="text-center font-weight-light my-4">Criar Produto</h3></div>
                                    <div class="card-body">
                                        <form action="actionAnuncio.php" method="POST">
                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="nomeProduto" id="nomeProduto" type="text" placeholder="Nome do seu produto"   />
                                                <label for="nomeProduto" required>Nome do Produto</label>
                                            </div>

                                            <div class="form-floating mb-3">
                                                <input class="form-control" name="estoqueProduto" id="estoqueProduto" type="number" placeholder="Quantidade no estoque" />
                                                <label for="estoqueProduto" min="0" max="300" required>Estoque</label>
                                            </div>  

                                            <div class="form-floating mb-3">
                                                <select name="categoriaAnuncio" id="categoriaAnuncio" placeholder="Selecione uma Categoria" class="form-control">
                                                    <option value="Alimentos">Alimentos</option>
                                                    <option value="Eletrônicos">Eletrônicos</option>
                                                    <option value="Vestuário">Vestuário</option>
                                                    <option value="Outra">Outra</option>
                                                </select>
                                                <label for="categoriaAnuncio">Categoria</label>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <div class="form-floating mt-3 mb-3">
                                                <input type="text" name="valorCustoAnuncio" id="valorCustoAnuncio" placeholder="Informe o valor que investiu em R$" class="form-control">
                                                <label for="valorCustoAnuncio">Preço de Custo (investimento)</label>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback"></div>
                                            </div>

                                            <div class="form-floating mt-3 mb-3">
                                                <input type="text" name="valorAnuncio" id="valorAnuncio" placeholder="Informe o valor que quer vender em R$" class="form-control">
                                                <label for="valorAnuncio">Valor do Produto (venda)</label>
                                                <div class="valid-feedback"></div>
                                                <div class="invalid-feedback"></div>
                                            </div>
                                            <button type="submit" class="btn btn-primary w-100" href="formLogin.php">
                                                    Criar produto
                                            </button>
                                        </form>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer">
                <footer class="py-4 bg-light mt-auto">
                    <div class="container-fluid px-4">
                        <div class="d-flex align-items-center justify-content-between small">
                            <div class="text-muted">Copyright &copy; Your Website 2023</div>
                            <div>
                                <a href="#">Privacy Policy</a>
                                &middot;
                                <a href="#">Terms &amp; Conditions</a>
                            </div>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script src="js/scripts.js"></script>
    </body>
</html>
