<?php
/**
 * index.php
 *
 * File being the front controller of the API and allowing to process dog requests.
 *
 * @author  Jonathan Borel-Jaquet - CFPT / T.IS-ES2 <jonathan.brljq@eduge.ch>
 */

use App\Controllers\GameController;
use App\Models\Game;
require "../../../bootstrap.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



$requestMethod = $_SERVER["REQUEST_METHOD"];

$controller = new GameController($dbConnection);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathFragments = explode('/', $path);
$name = $pathFragments[4];
parse_str(file_get_contents('php://input'), $input);

$game = new Game();
$game->id = $id ?? null;
$game->name = $input["name"] ?? null;
$game->description = $input["description"] ?? null;
$game->imageName = $input["imageName"] ?? null;
$game->idConsole = $input["idConsole"] ?? null;
$game->idFile = $input["idFile"] ?? null;

switch ($requestMethod) {
    case 'GET':
        if (empty($name) ) {
            //$response = $controller->getAllGames();
        }
        else{
            $response = $controller->getGamesFromName($name);
        }
        break;
        case 'POST':
            $name = $_REQUEST['name'];
            $response = $controller->getGamesFromName($name);
            
            break;

    case 'PATCH':
        if (empty($id) || !is_numeric($id)) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }
        $response = $controller->updateGame($dog);
        break;

    case 'DELETE':
        if (empty($id) || !is_numeric($id)) {
            header("HTTP/1.1 404 Not Found");
            exit();
        }
        $response = $controller->deleteGame($id);
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