<?php
class GamesController
{
    public $games;
    public $categorie;
    public $requestedgame = null;
    private $html = "";
    private $e = null;
    private $idGame;
    private $idcategory;


    public function __construct()
    {
        $this->games  = new Games();
        $this->categorie = new Categories();
    }
    public function formHandler()
    {
        $requestGame = null;
        $result = null;
        if (isset($_GET['e'])) {
            $this->e = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_STRING);
        }

        if ($this->e == "requestGame") {
            if (isset($_POST['gameName'])) {
                $requestGame = filter_input(INPUT_POST, 'gameName', FILTER_SANITIZE_STRING);
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
            }
        }

        if ($this->e == "categorie") {
            if (isset($_GET['idCategorie'])) {
                $idcategory = filter_input(INPUT_GET, 'idCategorie', FILTER_SANITIZE_STRING);
                $this->idcategory = $idcategory;
            }

            if (isset($idcategory)) {
                $result = $this->games->getGamesInCategorie($idcategory);
            }
        }

        
        if ($this->e == "addFavoris") {
            if (isset($_GET['idGame'])) {
                $idGame = filter_input(INPUT_GET, 'idGame', FILTER_SANITIZE_NUMBER_INT);
            }

            if (isset($idGame)) {
                $result = $this->games->addGameToFavoris($_SESSION['user']->idUser,$idGame);
                header('Location:'.$_SERVER['HTTP_REFERER']);
            }
        }

        if ($this->e == "removeFavoris") {
            if (isset($_GET['idGame'])) {
                $idGame = filter_input(INPUT_GET, 'idGame', FILTER_SANITIZE_NUMBER_INT);
            }

            if (isset($idGame)) {
                $result = $this->games->removeGameFromFavoris($_SESSION['user']->idUser,$idGame);
                header('Location:'.$_SERVER['HTTP_REFERER']);
            }
        }

        $this->requestedgame = $result;
    }


    public function printHTML()
    {
        $html = '<main style="margin-top:20px">
        <div class="container-md">';

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

    public function getListAllGames()
    {
        $html = '<div class="d-inline-flex p-2">';

        $listGamesBrut = $this->games->getAllGames();

        foreach ($listGamesBrut as $key => $games) {


            $html .= $this->createCardHTML($games);
        }

        $html .= '</div>';
        return $html;
    }

    public function getRequestedGames()
    {

        $html = '<div class="row row-cols-3 row-cols-md-2 g-4">';
        $listGamesBrut = $this->requestedgame;

        foreach ($listGamesBrut as $key => $games) {


            $html .= $this->createCardHTML($games);
        }

        $html .= '</div>';
        return $html;
    }

    public function getGameDetail()
    {

        $gameDetail = $this->games->getGameDetail($this->idGame);
        $category = $this->categorie->getCategoriesOfGame($this->idGame);
        $html = '';

        $html .= '</br>
            <div class="row">
                <div class="col">
                    <img class="detailImage" src="./img/games/' . $gameDetail[0]['imageName'] . '."  >
                </div>
                <div class="col">
                    <h2 class="card-title">' . $gameDetail[0]['name'] . '</h2>
                    <p class="card-title">' . $gameDetail[0]['description'] . '</p>
                    </br>
        <div class="list-group">';
            if ($_SESSION['user']->idUser != -1) {
                if ($this->games->checkIfGameIsAlreadyInFavoris($_SESSION['user']->idUser, $gameDetail[0]['id'])) {
                    $html.= '<a class="btn btn-outline-success " href="?r=games&e=addFavoris&idGame=' . $gameDetail[0]['id'] . '" role="button">Add to favorite</a>';
                }else {
                    $html.= '<a class="btn btn-outline-warning " href="?r=games&e=removeFavoris&idGame=' . $gameDetail[0]['id'] . '" role="button">Remove favorite</a>';
                }
            }

            $html .= '</div>
                    <h3 class="card-title">Categories</h3>
                    <div class="list-group">';

        foreach ($category as $key => $cat) {
            $html .= '<a href="?r=games&e=categorie&idCategorie=' . $cat['id'] . '"<button type="button" class="list-group-item list-group-item-action btn-success">' . $cat['name'] . '</button></a>';
        }

        $html .= '  </div>
                    </div>
                </div>
            </div>
            
            
            ';


        $html .= '';
        return $html;
    }

    public function getGamesFromCategorie()
    {

        $html = '<div class="row row-cols-3 row-cols-md-2 g-4">';
        $listGamesBrut = $this->requestedgame;

        foreach ($listGamesBrut as $key => $game) {

            $html .= $this->createCardHTML($game);
        }

        $html .= '</div>';
        return $html;
    }

    private function createCardHTML($game)
    {
        $html = '
        <div class="card cardBootstarp" style=" max-width: 11rem; margin:10px;">
        <a href="?r=games&e=detail&idGame=' . $game['id'] . '">
        <img src="./img/games/' . $game['imageName'] . '." class="card-img-top imageCard"  >
        <div class="card-body">
            <h5 class="card-title greenTexte">' . $game['name'] . '</h5>
            ';
            if ($_SESSION['user']->idUser != -1) {
                if ($this->games->checkIfGameIsAlreadyInFavoris($_SESSION['user']->idUser, $game['id'])) {
                    $html.= '<a class="btn btn-outline-success cardContent" href="?r=games&e=addFavoris&idGame=' . $game['id'] . '" role="button"><i class="far fa-heart"></i></a>';
                }else {
                    $html.= '<a class="btn btn-outline-success cardContent" href="?r=games&e=removeFavoris&idGame=' . $game['id'] . '" role="button"><i class="fa fa-heart"></i></a>';
                }
            }

            $html .= '
        </div>
        </a>
        </div>';
        return $html;
    }

    public function recherchFull()
    {
        $html = "";

        $html .= '<div class="jumbotron ">
        <div class="container">
          <h1 class="display-5">Recherche</h1>
          
          <form class="row g-3" action="?r=games&e=requestGame" method="post">

            <div class="col-auto">
                <input type="texte" class="form-control" id="gameName" name="gameName" placeholder="Mario">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success mb-3">Recherche</button>
            </div>
          </form>
          <h4>Categories:</h4>
          <p>

          ';
          foreach ($this->categorie->getListAllCategories() as $key => $cat) {
              $html .= '<a class="btn btn-outline-success btnCategorie " href="?r=games&e=categorie&idCategorie=' . $cat['id'] . '" role="button">'.$cat['name'].'</a>';
          }
          $html.= '
        </p>
          </div>
      </div>';

      return $html;
    }

    public function recherchNotFull()
    {
        $html = "";

        $html .= '<div class="card">
        <div class="card-body container">
          <h2 class="card-title ">Recherche</h2>
          
          <form class="row g-3" action="?r=games&e=requestGame" method="post">

            <div class="col-auto">
                <input type="texte" class="form-control" id="gameName" name="gameName" placeholder="Mario">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success mb-3">Recherche</button>
            </div>
          </form>
          </div>
      </div>';

      return $html;
    }
}
