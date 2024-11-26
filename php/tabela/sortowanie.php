<?php
if ($_GET['table'] && $_GET['order_by'] && $_GET['sort_direction']) {
    session_start();
    $table = $_GET['table'];
    $order_by = $_GET['order_by'];
    $order_id = $_GET['order_id'];
    $sort_direction = $_GET['sort_direction'];
    if ($table == 'wpisy') {
        include 'wpisy.php';
        TabelaWpisy($order_by, $order_id, $sort_direction);
    } else if ($table == 'uspr') {
        include 'uspr.php';
        $isUspr = $_GET["isUspr"];
        TabelaUspr($order_by, $order_id, $sort_direction,$isUspr);
    } else if ($table == 'historia' && (bool)$_SESSION['is_admin']) {
        include 'historia.php';
        TabelaHistoria($order_by, $order_id, $sort_direction);
    }
}