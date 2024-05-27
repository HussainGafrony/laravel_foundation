<?php
session_start();
include 'routes/route.php';
include 'layout/app/header.php';

// if (!isset($_SESSION['user_id'])) {
//     header("Location: ./views/login.php");
// }

$page = isset($_GET['p']) ? strip_tags($_GET['p']) : 'team';

route($page);

include './layout/app/footer.php';
