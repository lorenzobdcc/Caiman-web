<?php
class GamesController
{
    public $games;
    public $requestedgame = null;
    private $html = "";
    private $e = null;
    private $idGame;


    public function __construct()
    {
        $this->games  = new Games();
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

        $this->requestedgame = $result;
    }


    public function printHTML()
    {
        $html = '<main style="margin-top:20px">
        <div class="container-md">';


        if ($this->e == null) {
            $html .= $this->getListAllGames();
        }

        if ($this->e == "requestGame") {
            $html .= $this->getRequestedGames();
        }

        if ($this->e == "detail") {
            $html .= $this->getGameDetail();
        }

        $html .= "</main> </div>";
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


        $html = '<div class="row row-cols-3 row-cols-md-2 g-4">';
        $gameDetail = $this->games->getGameDetail($this->idGame);
        $html = '
            <div class="row">
                <div class="col">
                    <img src="./img/games/' . $gameDetail[0]['imageName'] . '." " >
                </div>
                <div class="col">
                    <h2 class="card-title">' . $gameDetail[0]['name']. '</h2>
                    <p class="card-title">' . $gameDetail[0]['description'] . '</p>
                </div>
            </div>
            
            
            ';
            $category =$this->games->getCategoryOfGame($this->idGame);
            
            foreach ($category as $key => $cat) {


                echo "<br>".$cat['name'];
            }
        $html .= '</div>';
        return $html;
    }

    private function createCardHTML($game)
    {
        $html = '<div class="card " style=" max-width: 14rem; margin:10px;">
        <img src="./img/games/' . $game['imageName'] . '." class="card-img-top" >
        <div class="card-body">
            <h5 class="card-title">' . $game['name'] . '</h5>
            <a href="?r=games&e=detail&idGame=' . $game['id'] . '" class="btn btn-primary">detail</a>
        </div>
    </div>';
        return $html;
    }
}
