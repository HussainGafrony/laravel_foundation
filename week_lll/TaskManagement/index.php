<?php
session_start();
include 'routes/route.php';
include 'layout/app/header.php';

$page = isset($_GET['p']) ? strip_tags($_GET['p']) : 'statistics';

route($page);

include './layout/app/footer.php';
