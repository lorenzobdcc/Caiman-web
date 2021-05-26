<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief File being the front controller of the API and allowing to process users connexion.
 */

use App\Controllers\UserController;

require "../../../../bootstrap.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



$requestMethod = $_SERVER["REQUEST_METHOD"];

$controller = new UserController($dbConnection);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathFragments = explode('/', $path);

parse_str(file_get_contents('php://input'), $input);
$username = "";
$password = "";

switch ($requestMethod) {


    case 'POST':
        if (isset($_REQUEST['caimanToken'])) {
            $caimanTocken = $_REQUEST['caimanToken'];
            if ($caimanTocken != "") {
               $response = $controller->findByCaimanToken($caimanTocken);
               
            }

            
        }
        if (isset($_REQUEST['username']) && isset($_REQUEST['password'])) {
        $username = $_REQUEST['username'];
        $password = $_REQUEST['password'];


        if ($password != "" && $username != "") {
            $response = $controller->connection($username, $password);
            $responsePHP = json_decode($response['body']);
            $controller->updateCaimanToken($responsePHP->apitocken);
            $response = $controller->connection($username, $password);
        } else {
            header("HTTP/1.1 404 Not Found");
            exit();
        }
    }

        break;

    default:
        header("HTTP/1.1 404 Not Found");
        exit();
        break;
}

header($response['status_code_header']);
if ($response['body']) {
    echo $response['body'];
}
