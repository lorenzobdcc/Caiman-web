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

require "../../bootstrap.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



$requestMethod = $_SERVER["REQUEST_METHOD"];

$controller = new UserController($dbConnection);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathFragments = explode('/', $path);
$apitockenget = intval(end($pathFragments));
$apitockenget = $pathFragments[5];
parse_str(file_get_contents('php://input'), $input);

$user = new User();
$user->id = $id ?? null;
$user->password = $input["password"] ?? null;
$user->salt = $input["salt"] ?? null;
$user->apitocken = $input["apitocken"] ?? null;
$user->email = $input["email"] ?? null;
$user->privateAccount = $input["privateAccount"] ?? null;
$user->idRole = $input["idRole"] ?? null;
switch ($requestMethod) {
    case 'GET':
        print_r($_GET);
        switch ($i) {
            case 0:
                echo "i égal 0";
                break;
            case 1:
                echo "i égal 1";
                break;
            case 2:
                echo "i égal 2";
                break;
        }

        if (empty($apitockenget) == 1) {
            $response = $controller->getAllUsers();
        }
        else{
            $response = $controller->getUser($apitockenget);
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
