<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief File being the front controller of the API and allowing to process games request.
 */

use App\Controllers\UserController;
use App\Models\User;

require "../../../bootstrap.php";

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

$apikey = "";
$user = new User();
$user->id = $id ?? null;
$user->password = $input["password"] ?? null;
$user->salt = $input["salt"] ?? null;
$user->apitocken = $input["apitoken"] ?? null;
$user->email = $input["email"] ?? null;
$user->privateAccount = $input["privateAccount"] ?? null;
$user->idRole = $input["idRole"] ?? null;

switch ($requestMethod) {
    case 'GET':
        $response = $controller->getAllUsers();

        break;

    case 'POST':
        $apikey = $_REQUEST['apikey'];
        if ($apikey != "") {
            $response = $controller->getUser($apikey);
        } else {
            header("HTTP/1.1 404 Not Found");
            exit();
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
