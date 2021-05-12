<?php
/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief File being the front controller of the API and allowing to process games request.
 */
use App\Controllers\GameController;
use App\Models\Game;
require "../../bootstrap.php";

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET,POST,PATCH,DELETE");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");



$requestMethod = $_SERVER["REQUEST_METHOD"];

$controller = new GameController($dbConnection);

$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$pathFragments = explode('/', $path);
$id = intval(end($pathFragments));
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
        $isSet = 0;
        if (isset($_GET['byName'])) {
            $name = str_replace(array('+'),array(' '),$_GET['byName']); 
            $response = $controller->getGamesFromName($name);
            $isSet = 1;
        }
        if (isset($_GET['byCategory'])) {
            $category = $_GET['byCategory'];
            $response = $controller->getGameFromCategory($category);
            $isSet = 1;
        }
        if (isset($_GET['byUserFavorite'])) {
            $user = $_GET['byUserFavorite'];
            $response = $controller->getFavoriteGameOfUser($user);
            $isSet = 1;
        }
        if (isset($_GET['byUserTime'])) {
            $user = $_GET['byUserTime'];
            $response = $controller->getTimeGames($user);
            $isSet = 1;
        }


        if ($isSet == 0) {
            if (empty($id) || !is_numeric($id)) {
                $response = $controller->getAllGames();
            }
            else{
                $response = $controller->getGame($id);
            }
            
        }
        break;
        case 'POST':

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
