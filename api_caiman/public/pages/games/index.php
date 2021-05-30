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
            $name = str_replace(array('+'), array(' '), $_GET['byName']);
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
        if (isset($_GET['gameFileName'])) {
            $id = $_GET['gameFileName'];
            $response = $controller->getFileName($id);
            $isSet = 1;
        }
        if (isset($_GET['gameConsole'])) {
            $id = $_GET['gameConsole'];
            $response = $controller->getConsole($id);
            $isSet = 1;
        }
        if (isset($_GET['idGame']) && isset($_GET['apiKey'])) {
            $idGame = $_GET['idGame'];
            $apiKey = $_GET['apiKey'];
            $isSet = 1;
            $response = $controller->getURL($idGame, $apiKey);
        }
        if (isset($_GET['idEmulator']) && isset($_GET['idUser']) && isset($_GET['apiKey'])) {
            $idEmulator = $_GET['idEmulator'];
            $idUser = $_GET['idUser'];
            $apiKey = $_GET['apiKey'];
            $isSet = 1;
            $response = $controller->getURLSave($idEmulator,$idUser, $apiKey);
        }
        if (isset($_GET['idGameTime']) && isset($_GET['idUser'])) {
            $idGame = $_GET['idGameTime'];
            $idUser = $_GET['idUser'];
            $response = $controller->getTimePlayed($idGame, $idUser);
            $isSet = 1;
        }

        if ($isSet == 0) {
            if (empty($id) || !is_numeric($id)) {
                $response = $controller->getAllGames();
            } else {
                $response = $controller->getGame($id);
            }
        }
        break;
    case 'POST':
        if (isset($_POST['idEmulator']) && isset($_POST['idUser']) && isset($_POST['apiKey'])) {
            $idEmulator = $_POST['idEmulator'];
            $idUser = $_POST['idUser'];
            $apiKey = $_POST['apiKey'];
            $file = $_FILES["fileSave"]["tmp_name"];
            $response = $controller->AddSave($idEmulator,$idUser, $apiKey,$file);
        }
        if (isset($_POST['idGameAdd']) && isset($_POST['idUser'])) {
            $idGame = $_POST['idGameAdd'];
            $idUser = $_POST['idUser'];
            $response = $controller->addGameToFavorite($idGame, $idUser);
        }
        if (isset($_POST['idGameRemove']) && isset($_POST['idUser'])) {
            $idGame = $_POST['idGameRemove'];
            $idUser = $_POST['idUser'];
            $response = $controller->removeGameFromFavorite($idGame, $idUser);
        }
        if (isset($_POST['idGameCheck']) && isset($_POST['idUser'])) {
            $idGame = $_POST['idGameCheck'];
            $idUser = $_POST['idUser'];
            $response = $controller->checkIfGameFavorite($idGame, $idUser);
        }
        if (isset($_POST['idGameTimeAdd']) && isset($_POST['idUser'])) {
            $idGame = $_POST['idGameTimeAdd'];
            $idUser = $_POST['idUser'];
            $response = $controller->addOneMInuteToGameTime($idGame, $idUser);
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
