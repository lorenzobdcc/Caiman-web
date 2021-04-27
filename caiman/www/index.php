<?php
include_once "../HOST.php";
include_once "models/class.php";
include_once "controllers/controllers.php";

session_start();

if (!isset($_SESSION['user'])) {
   $_SESSION['user'] = new user("","","visitor","-1"); 
}


$r_page = filter_input(INPUT_GET, 'r', FILTER_SANITIZE_SPECIAL_CHARS);

switch ($r_page) {
    case "games" : 
        $controller = new GamesController();
        break;

    case "download" : 
        $controller = new DownloadController();
        break;

    case "dashboard" : 
        $controller = new DashboardController();
        break;

    case "signin" : 
        $controller = new SigninController();
        break;

    case "login" : 
        $controller = new LoginController();
        break;

    case "logout" : 
            session_destroy();
            header('Location:'.$_SERVER['HTTP_REFERER']);
            break;
    case "administrator" : 
        $controller = new AdministratorController();
            break;
    default:
        $controller = new IndexController();
        break;
}
$controller->formHandler();

$title="Caiman";
include "common/head.php";
include "common/modal.php";
include "common/navbar.php";
$controller->printHTML();
include "common/footer.php";

?>