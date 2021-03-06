<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Class used to handle request for the games pages
 */
class GamesController extends mainController implements iController
{
    public $games;
    public $categorie;
    public $requestedgame = null;
    private $html = "";
    private $e = null;
    private $idGame;
    private $idcategory;

    /**
     * default constructor
     */
    public function __construct()
    {
        $this->games  = new Games();
        $this->categorie = new Categories();
    }

    /**
     * used to handle if the user has resquest something
     *
     * @return void
     */
    public function formHandler()
    {
        $_SESSION['title'] = "Caiman: Games";
        $requestGame = null;
        $result = null;
        if (isset($_GET['e'])) {
            $this->e = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_STRING);
        }

        if ($this->e == "requestGame") {

            if (isset($_POST['gameName'])) {
                $requestGame = filter_input(INPUT_POST, 'gameName', FILTER_SANITIZE_STRING);
                $_SESSION['title'] = "Caiman: Search " . $requestGame;
            }

            if (isset($requestGame)) {
                $result = $this->games->getRequestGames($requestGame);
            }
        }

        if ($this->e == "detail") {

            if (isset($_GET['idGame'])) {
                $idGame = filter_input(INPUT_GET, 'idGame', FILTER_SANITIZE_STRING);
                $this->idGame = $idGame;
            }

            if (isset($idGame)) {
                $result = $this->games->getGameDetail($idGame);
                $_SESSION['title'] = "Caiman: " . $result[0]["name"];
            }
        }

        if ($this->e == "categorie") {
            $_SESSION['title'] = "Caiman: Categorie";
            if (isset($_GET['idCategorie'])) {
                $idcategory = filter_input(INPUT_GET, 'idCategorie', FILTER_SANITIZE_STRING);
                $this->idcategory = $idcategory;
            }

            if (isset($idcategory)) {
                $result = $this->games->getGamesInCategorie($idcategory);
            }
        }


        if ($this->e == "addFavoris") {
            $_SESSION['title'] = "Caiman: Favorite";
            if (isset($_GET['idGame'])) {
                $idGame = filter_input(INPUT_GET, 'idGame', FILTER_SANITIZE_NUMBER_INT);
            }

            if (isset($idGame)) {
                $result = $this->games->addGameToFavoris($_SESSION['user']->idUser, $idGame);
                header('Location:' . $_SERVER['HTTP_REFERER']);
                $_SESSION['error'] = "Favorite added";
            }
        }

        if ($this->e == "removeFavoris") {
            if (isset($_GET['idGame'])) {
                $idGame = filter_input(INPUT_GET, 'idGame', FILTER_SANITIZE_NUMBER_INT);
            }

            if (isset($idGame)) {
                $result = $this->games->removeGameFromFavoris($_SESSION['user']->idUser, $idGame);
                header('Location:' . $_SERVER['HTTP_REFERER']);
                $_SESSION['error'] = "Favorite removed";
            }
        }

        $this->requestedgame = $result;
    }

    /**
     * print the html for the resquested content
     * 
     *
     * @return html
     */
    public function printHTML()
    {
        $html = '<main style="margin-top:20px">
        <div class="container-md">';
        $html .= $this->errorHandler();
        if ($this->e == null) {
            $html .= $this->recherchFull();
            $html .= $this->getListAllGames();
        }

        if ($this->e == "requestGame") {
            $html .= $this->recherchFull();
            $html .= $this->getRequestedGames();
        }

        if ($this->e == "detail") {
            $html .= $this->recherchNotFull();
            $html .= $this->getGameDetail();
        }

        if ($this->e == "categorie") {
            $html .= $this->recherchFull();
            $html .= $this->getGamesFromCategorie();
        }

        $html .= "</div></main> ";
        echo $html;
    }

    /**
     * create the html of the list of all the games
     *
     * @return html
     */
    public function getListAllGames()
    {
        $html = '<div class="cardGameBox box">';

        $listGamesBrut = $this->games->getAllGames();

        foreach ($listGamesBrut as $key => $games) {


            $html .= $this->createCardHTML($games);
        }

        $html .= '</div>';
        return $html;
    }

    /**
     * create a list of the requested games
     *
     * @return html
     */
    public function getRequestedGames()
    {

        $html = '<div class="cardGameBox box">';
        $listGamesBrut = $this->requestedgame;
        foreach ($listGamesBrut as $key => $games) {


            $html .= $this->createCardHTML($games);
        }

        $html .= '</div>';
        return $html;
    }

    /**
     * create the page of a specific game
     *
     * @return html
     */
    public function getGameDetail()
    {

        $gameDetail = $this->games->getGameDetail($this->idGame);
        $category = $this->categorie->getCategoriesOfGame($this->idGame);
        $html = '';

        $html .= '</br>
            <div class="row">
                <div class="col">
                    <img class="detailImage" src="./img/games/' . $gameDetail[0]['imageName'] . '"  >
                </div>
                <div class="col">
                    <h2 class="card-title">' . $gameDetail[0]['name'] . '</h2>
                    <p class="card-title">' . $gameDetail[0]['description'] . '</p>
                    </br>
        <div class="list-group">';
        if ($_SESSION['user']->idUser != -1) {
            if ($this->games->checkIfGameIsAlreadyInFavoris($_SESSION['user']->idUser, $gameDetail[0]['id'])) {
                $html .= '<a class="btn btn-outline-success " href="?r=games&e=addFavoris&idGame=' . $gameDetail[0]['id'] . '" role="button">Add to favorite</a>';
            } else {
                $html .= '<a class="btn btn-outline-warning " href="?r=games&e=removeFavoris&idGame=' . $gameDetail[0]['id'] . '" role="button">Remove favorite</a>';
            }
        }
        if ($_SESSION['user']->role == 1) {
            $html .= '</br> <a class="btn btn-outline-danger " href="?r=administrator&e=updateGame&id=' . $gameDetail[0]['id'] . '" role="button">Update game</a>';
            $html .= '</br> <a class="btn btn-outline-danger " href="?r=administrator&e=addGameCategorie&id=' . $gameDetail[0]['id'] . '" role="button">Update/add categories</a>';
        }

        $html .= '</div>
                    <h3 class="card-title">Categories</h3>
                    <div class="list-group">';

        foreach ($category as $key => $cat) {
            $html .= '<a href="?r=games&e=categorie&idCategorie=' . $cat['id'] . '"<button type="button" class="btn btn-outline-success btnCategorie margintop10">' . $cat['name'] . '</button></a>';
        }

        $html .= '  </div>
                    </div>
                </div>
            </div>
            
            
            ';


        $html .= '';
        return $html;
    }

    /**
     * crate a list of game of a specific categorie
     *
     * @return html
     */
    public function getGamesFromCategorie()
    {

        $html = '<div class="cardGameBox box">';
        $listGamesBrut = $this->requestedgame;

        foreach ($listGamesBrut as $key => $game) {

            $html .= $this->createCardHTML($game);
        }

        $html .= '</div>';
        return $html;
    }

    /**
     * print the html of a game
     * 
     *
     * @return html
     */
    private function createCardHTML($game)
    {
        $html = '
        <div class="card cardBootstarp " style=" max-width: 15rem; margin:10px;  background-color: #161b22; border:2px solid #28a745;">
        <a href="?r=games&e=detail&idGame=' . $game['id'] . '">
        <img src="./img/games/' . $game['imageName'] . '" class="card-img-top imageCard"  >
        <div class="card-body darkContent">
            <h6 class="card-title whiteTexte">' . $game['name'] . '</h5>
            
        </div>
        <div class="card-body"> ';
        if ($_SESSION['user']->idUser != -1) {
            if ($this->games->checkIfGameIsAlreadyInFavoris($_SESSION['user']->idUser, $game['id'])) {
                $html .= '<a class="btn btn-outline-light cardContent" href="?r=games&e=addFavoris&idGame=' . $game['id'] . '" role="button"><i class="far fa-heart"></i></a>';
            } else {
                $html .= '<a class="btn btn-outline-light cardContent" href="?r=games&e=removeFavoris&idGame=' . $game['id'] . '" role="button"><i class="fa fa-heart"></i></a>';
            }
        }

        $html .= '
        </div>
        </a>
        </div>';
        return $html;
    }

    /**
     * create the html of a form to research game and to display the list of categorie
     *
     * @return html
     */
    public function recherchFull()
    {
        $html = "";

        $html .= '<div class="jumbotron DarkJumbotron  " style="background-color: #161b22;">
        <div class="container">
          <h1 class="display-5">Research</h1>
          
          <form class="row g-3" action="?r=games&e=requestGame" method="post">

            <div class="col-auto">
                <input type="texte" class="form-control" id="gameName" name="gameName" placeholder="Mario">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success mb-3">Research</button>
            </div>
          </form>
          <h4>Categories:</h4>
          <p>

          ';
        foreach ($this->categorie->getListAllCategories() as $key => $cat) {
            $html .= '<a class="btn btn-outline-success btnCategorie " href="?r=games&e=categorie&idCategorie=' . $cat['id'] . '" role="button">' . $cat['name'] . '</a>';
        }
        $html .= '
        </p>
          </div>
      </div>';

        return $html;
    }

    /**
     * create the html of a form to research game 
     *
     * @return html
     */
    public function recherchNotFull()
    {
        $html = "";

        $html .= '<div class="card  " style="background-color: #0d1117;">
        <div class="card-body container DarkJumbotron">
          <h2 class="card-title ">Research</h2>
          
          <form class="row g-3" action="?r=games&e=requestGame" method="post">

            <div class="col-auto">
                <input type="texte" class="form-control" id="gameName" name="gameName" placeholder="Mario">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success mb-3">Research</button>
            </div>
          </form>
          </div>
      </div>';

        return $html;
    }
}
