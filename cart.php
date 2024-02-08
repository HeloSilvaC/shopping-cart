<?php
session_start();
var_dump($_SESSION);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="author" content="Sahil Kumar">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Cart</title>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.min.css'/>
    <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.9.0/css/all.min.css'/>
</head>

<body>
<nav class="navbar navbar-expand-md bg-dark navbar-dark">
    <a class="navbar-brand" href="index.php"><i class="fas fa-mobile-alt"></i>&nbsp;&nbsp;Mobile Store</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#collapsibleNavbar">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="collapsibleNavbar">
        <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link active" href="index.php"><i class="fas fa-mobile-alt mr-2"></i>Produtos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="cart.php"><i class="fas fa-shopping-cart"></i> <span id="cart-item"
                                                                                               class="badge badge-danger"></span></a>
            </li>
        </ul>
    </div>
</nav>

<div class="container">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div style="display:<?php echo isset($_SESSION['showAlert']) ? $_SESSION['showAlert'] : 'none'; ?>;" class="alert alert-success alert-dismissible mt-3">
                <button type="button" class="close" data-dismiss="alert" onclick="closeAlert()">&times;</button>
                <strong><?php echo isset($_SESSION['message']) ? $_SESSION['message'] : ''; ?></strong>
            </div>

            <script>
                function closeAlert() {
                    <?php $_SESSION['message'] = null; ?>
                    <?php $_SESSION['showAlert'] = 'none'; ?>
                    location.reload();
                }
            </script>


            <div class="table-responsive mt-2">
                <table class="table table-bordered table-striped text-center">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Imagem</th>
                        <th>Produto</th>
                        <th>Preço</th>
                        <th>Quantidade</th>
                        <th>Preço total</th>
                        <th>Remover</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // Verifica se existe um carrinho na sessão e se ele não está vazio
                    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                        $grand_total = 0;
                        // Loop pelos itens do carrinho
                        foreach ($_SESSION['cart'] as $key => $item) {
                            ?>
                            <tr>
                                <td><?= $item['pid'] ?></td>
                                <td><img src="<?= $item['pimage'] ?>" width="50"></td>
                                <td><?= $item['pname'] ?></td>
                                <td>R$ <?= number_format($item['pprice'], 2, '.', ','); ?></td>
                                <td>
                                    <p class="badge badge-light""><?= $item['pqty']?></p>
                                    <br>
                                    <button class="operator btn btn-info"><a style="text-decoration: none; color: white;" href="action.php?add=<?= $key ?>&pid=<?= $item['pid'] ?> ">+</a></button>
                                    <button class="operator btn btn-info"><a style="text-decoration: none; color: white" href="action.php?dim=<?= $key ?>&pid=<?= $item['pid'] ?> ">-</a></button>
                                </td>
                                <td>R$ <?= number_format($item['total_price'], 2, ',', '.'); ?></td>
                                <td>
                                    <a href="action.php?remove=<?= $key ?>&pid=<?= $item['pid'] ?>"
                                       class="text-danger lead remove-item"><i class="fas fa-trash-alt"></i></a>
                                </td>
                            </tr>
                            <?php
                            $grand_total += $item['total_price'];
                        }
                        ?>
                        <tr>
                            <td colspan="5"><b>Total geral</b></td>
                            <td><b>R$ <?= number_format($grand_total, 2, ',', '.'); ?></b></td>
                            <td>
                                <a href="action.php?clear=all" class="badge-danger badge p-1"
                                   onclick="return confirm('Tem certeza de que deseja limpar seu carrinho?');"><i
                                            class="fas fa-trash"></i> Deletar carrinho</a>
                            </td>
                        </tr>
                        <?php
                    } else {
                        ?>
                        <tr>
                            <td colspan="7">Seu carrinho está vazio!</td>
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
</body>
</html>
