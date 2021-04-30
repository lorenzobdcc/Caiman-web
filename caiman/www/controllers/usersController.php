<?php

/** BDCC
 *  -------
 *  @author Lorenzo Bauduccio <lorenzo.bdcc@eduge.ch>
 *  @file
 *  @copyright Copyright (c) 2021 BDCC
 *  @brief Class used to handle request of the user of the website
 */
include_once "./models/class.php";
class UsersController implements iController
{
    public $userData;
    private $e = null;
    private $requestUsername = null;
    private $idUser = null;
    private $game = null;

    /**
     * used to handle if the user has resquest something
     *
     * @return void
     */
    public function formHandler()
    {
        $_SESSION['title'] = "Caiman: Users";

        if (isset($_GET['e'])) {
            $this->e = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // request user by their username
        if ($this->e == "researchUser") {
            $_SESSION['title'] = "Caiman: Search";
            if (isset($_POST['username'])) {
                $this->requestUsername = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_STRING);
            }
        }

        // show detail of a user
        if ($this->e == "detailUser") {
            $_SESSION['title'] = "Caiman: User detail";
            if (isset($_GET['idUser'])) {
                $this->idUser = filter_input(INPUT_GET, 'idUser', FILTER_SANITIZE_STRING);
            }
        }
    }

    /**
     * default constructor
     */
    public function __construct()
    {
        $this->userData = new UserData();
        $this->game = new Games();
    }

    /**
     * print the html for the resquested content
     * 
     *
     * @return void
     */
    public function printHTML()
    {

        $html = '<main  style="margin-top:20px ">
        <div class="container-md">';

        if ($this->e == null) {
            $html .= $this->htmlrecherchUsers();
        }

        if ($this->e == "researchUser") {
            $html .= $this->htmlrecherchUsers();
            $html .= $this->htmlDetailUser();
        }

        if ($this->e == "detailUser") {
            $html .= $this->htmlDataUser();
            $html .= $this->htmlFavoriteGameUser();
            $html .= $this->htmlTimeInGameUser();
        }

        $html .= "</div></main> ";

        echo $html;
    }

    /**
     * create the form to search users
     *
     * @return html
     */
    public function htmlrecherchUsers()
    {
        $html = "";

        $html .= '<div class="card  " style="background-color: #0d1117;">
        <div class="card-body container DarkJumbotron">
          <h2 class="card-title ">Research</h2>
          
          <form class="row g-3" action="?r=users&e=researchUser" method="post">

            <div class="col-auto">
                <input type="texte" class="form-control" id="username" name="username" placeholder="username">
            </div>
            <div class="col-auto">
                <button type="submit" class="btn btn-success mb-3">Research</button>
            </div>
          </form>
          </div>
      </div>';

        return $html;
    }

    /**
     * create the list of user requested by their username
     *
     * @return html
     */
    public function htmlrequestUser()
    {
        $html = "";

        $html .= '<div class="card  " style="background-color: #0d1117;">
        <div class="card-body container DarkJumbotron">
          <h2 class="card-title ">Results</h2>
          <div class="list-group">
          ';

        foreach ($this->userData->getUsersByUsername($this->requestUsername) as $key => $user) {

            $html .= '<a class="btn btn-outline-success btnCategorie margintop10 " href="?r=users&e=detailUser&idUser=' . $user['id'] . '" role="button">' . $user['username'] . '</a>';
        }

        $html .= '
            </div>
          </div>
      </div>';

        return $html;
    }

    /**
     * create a page with the details of a user
     *
     * @return html
     */
    public function htmlDetailUser()
    {
        $html = "";

        $html .= '<div class="card  " style="background-color: #0d1117;">
        <div class="card-body container DarkJumbotron">
          <h2 class="card-title ">Results</h2>
          <div class="list-group">
          ';

        foreach ($this->userData->getUsersByUsername($this->requestUsername) as $key => $user) {

            $html .= '<a class="btn btn-outline-success btnCategorie margintop10 " href="?r=users&e=detailUser&idUser=' . $user['id'] . '" role="button">' . $user['username'] . '</a>';
        }

        $html .= '
            </div>
          </div>
      </div>';

        return $html;
    }

    /**
     * crate html of the info on a user
     *
     * @return html
     */
    private function htmlDataUser()
    {
        $html = "";
        $dataUser = $this->userData->getUserData($this->idUser);
        $dataUser = $dataUser[0];

        $html .= '<div class=" jumbotron DarkJumbotron width100" style="background-color: #161b22;">';

        $html .= '<div class="container">
        <div class="row"><h2>User\'s Informations</h2></div>
        <div class="row ">
          <div class="col-sm">
            <ul class="list-group">';
        $html .= '<li class="list-group-item">Username: ' . $dataUser['username'] . '</li>';


        $html .= '
            </ul>
          </div>
            <div class="col-sm">
            
            </div>
        </div>';

        $html .= '
          
        </div>
      </div>';

        return $html;
    }

    /**
     * create a list of the user's favorite games
     *
     * @return html
     */
    private function htmlFavoriteGameUser()
    {
        $html = '<div class="d-inline-flex  jumbotron DarkJumbotron  width100" style="background-color: #161b22;" >
        <div class="container">
        <div class="row"><h2>User\'s favorites games</h2></div>
        <div class="row cardGameBox box">
        ';

        $listGamesBrut =  $this->game->getFavoriteGamesOfUser($this->idUser);

        foreach ($listGamesBrut as $key => $games) {


            $html .= $this->createCardHTML($games);
        }

        $html .= '</div>
        </div>
        </div>';
        return $html;
    }

    /**
     * create a list of the games who as been played by the user and display the number of hours and minutes
     *
     * @return html
     */
    private function htmlTimeInGameUser()
    {
        $html = '<div class="d-inline-flex  jumbotron DarkJumbotron  width100" style="background-color: #161b22;" >
        <div class="container">
        <div class="row"><h2>User\'s time in games</h2></div>
        <div class="row cardGameBox box">
        ';

        $listGamesBrut =  $this->game->getListOfGameWithTimeUser($this->idUser);
        foreach ($listGamesBrut as $key => $games) {


            $html .= $this->createCardHTMLTime($games['idGame']);
        }

        $html .= '</div>
        </div>
        </div>';
        return $html;
    }



    /**
     * diplay a game
     *
     * @param int $game
     * @return html
     */
    private function createCardHTML($game)
    {
        $html = '
        <div class="card cardBootstarp" style=" max-width: 15rem;  margin:10px; padding:0; background-color: #161b22; border:2px solid #28a745;">
        <a href="?r=games&e=detail&idGame=' . $game['id'] . '">
        <img src="./img/games/' . $game['imageName'] . '." class="card-img-top imageCard"  >
        <div class="card-body ">
        <h6 class="card-title whiteTexte">' . $game['name'] . '</h5>
        <div class="card-body ">
            ';

        $html .= '<a class="btn btn-outline-success cardContent" href="?r=games&e=removeFavoris&idGame=' . $game['id'] . '" role="button"><i class="fa fa-heart "></i></a>';


        $html .= '
        </div>
        </div>
        </a>
        </div>';
        return $html;
    }

    /**
     * create the view of a game with the time played
     *
     * @param int $game
     * @return html
     */
    private function createCardHTMLTime($game)
    {
        $gameDetail = $this->game->getGameDetail($game);
        $gameDetail = $gameDetail[0];
        $gameTime = $this->game->getTimeInGameUser($this->idUser, $game);
        $html = '
        <div class="card cardBootstarp" style=" max-width: 15rem; margin:10px; padding:0; background-color: #161b22; border:2px solid #28a745;">
        <img src="./img/games/' . $gameDetail['imageName'] . '." class="card-img-top imageCard"  >
        <div class="card-body ">
        <h6 class="card-title whiteTexte">' . $gameDetail['name'] . '</h5>
            <p class="greenTexte">';
        $heure = (int)($gameTime[0]['timeInMinute'] / 60);
        $minutes = ($gameTime[0]['timeInMinute'] % 60);
        if ($minutes == 60) {
            $heure++;
            $minutes = 0;
        }
        $html .= $heure . "h" . $minutes . " minutes";
        $html .= ' </p>
        </div>
        </div>';
        return $html;
    }
}
