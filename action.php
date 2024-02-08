<?php
session_start();

if (isset($_POST['pid'])) {
    $pid = $_POST['pid'];
    $pname = $_POST['pname'];
    $pprice =  $_POST['pprice'];
    $pimage = $_POST['pimage'];
    $pcode = $_POST['pcode'];
    $pqty = $_POST['pqty'];
    $total_price = $pprice * $pqty;

    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    if (!isset($_SESSION['cart'][$pid])) {
        // Adiciona o item ao carrinho de compras na sessão
        $_SESSION['cart'][$pid] = [
            'pid' => $pid,
            'pname' => $pname,
            'pprice' => $pprice,
            'pimage' => $pimage,
            'pcode' => $pcode,
            'pqty' => $pqty,
            'total_price' => $total_price
        ];
        echo '<div class="alert alert-success alert-dismissible mt-2">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Item adicionado ao seu carrinho!</strong>
        </div>';
    }
    else{
        echo '<div class="alert alert-warning alert-dismissible mt-2">
          <button type="button" class="close" data-dismiss="alert">&times;</button>
          <strong>Item já existe no seu carrinho!</strong>
        </div>';
    }
}

// Obter o número de itens no carrinho
if (isset($_GET['cartItem']) && isset($_GET['cartItem']) == 'cart_item') {
    $cartItemCount = isset($_SESSION['cart']) ? count($_SESSION['cart']) : 0;
    echo $cartItemCount;
}

// Aumentar a quantidade do item no carrinho
if (isset($_GET['add']) && isset($_GET['pid'])) {
    $pidAdd = $_GET['pid'];

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['pid'] === $pidAdd) {
            $_SESSION['cart'][$key]['pqty'] = $item['pqty'] + 1;
            $_SESSION['cart'][$key]['total_price'] = $_SESSION['cart'][$key]['pqty'] * $item['pprice'];
            break;
        }
    }

    header('location:cart.php');
    exit();
}

// Diminuir a quantidade do item no carrinho
if (isset($_GET['dim']) && isset($_GET['pid'])) {
    $pidAdd = $_GET['pid'];

    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['pqty'] > 1) {
            if ($item['pid'] === $pidAdd) {
                $_SESSION['cart'][$key]['pqty'] = $item['pqty'] - 1;
                $_SESSION['cart'][$key]['total_price'] = $_SESSION['cart'][$key]['pqty'] * $item['pprice'];
                break;
            }
        }
    }

    header('location:cart.php');
    exit();
}


// Remover item do carrinho
if (isset($_GET['remove']) && isset($_GET['pid'])) {
    $pidToRemove = $_GET['pid'];
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['pid'] === $pidToRemove) {
            unset($_SESSION['cart'][$key]);
            $_SESSION['showAlert'] = 'block';
            $_SESSION['message'] = 'Item removido do carrinho!';
            break;
        }
    }

    $_SESSION['cart'] = array_values($_SESSION['cart']);
    header('location:cart.php');
}


// Limpar o carrinho
if (isset($_GET['clear'])) {
    unset($_SESSION['cart']);
    $_SESSION['showAlert'] = 'block';
    $_SESSION['message'] = 'Todos os itens removidos do carrinho!';
    header('location:cart.php');
}

?>
