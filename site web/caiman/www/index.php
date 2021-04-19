<?php
//include "class/class.php";
session_start();

$r_page = filter_input(INPUT_GET, 'r', FILTER_SANITIZE_SPECIAL_CHARS);

switch ($r_page) {
    case "games" : 
        $fileLoad = "games.php";
        break;

    case "download" : 
        $fileLoad = "download.php";
        break;

    case "dashboard" : 
        $fileLoad = "dashboard.php";
        break;

    default:
        $fileLoad = "index.php";
        break;
}

$title="Test";
include "common/head.php";
include "common/modal.php";
include "css/style.css";
include "common/navbar.php";
include "page/". $fileLoad;
include "common/footer.php";

?>