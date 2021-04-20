<?php
include_once "models/class.php";
include_once "../HOST.php";
session_start();

if (!isset($_SESSION['user'])) {
   $_SESSION['user'] = new user("","","visitor"); 
   echo "reset user";
}


$r_page = filter_input(INPUT_GET, 'r', FILTER_SANITIZE_SPECIAL_CHARS);

switch ($r_page) {
    case "games" : 
        $fileLoad = "gamesController.php";
        $pageClass = new Games();
        break;

    case "download" : 
        $fileLoad = "downloadController.php";
        $pageClass = new Download();
        break;

    case "dashboard" : 
        $fileLoad = "dashboardController.php";
        $pageClass = new Dashboard();
        break;

    case "signin" : 
        $fileLoad = "signinController.php";
        $pageClass = new Signin();
        break;
    case "login" : 
        $fileLoad = "loginController.php";
        $pageClass = new Login();
        break;
    case "logout" : 
            session_destroy();
            header('Location: index.php');
            break;
    default:
        $fileLoad = "indexController.php";
        $pageClass = new Index();
        break;
}

$title="Caiman";
include "controllers/". $fileLoad;
include "common/head.php";
include "common/modal.php";
include "css/style.css";
include "common/navbar.php";
echo $pageClass->printHTML();
include "common/footer.php";

?>