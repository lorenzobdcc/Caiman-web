<?php

include_once "./models/class.php";
class DashboardController
{
    public $dashboard;
    public $game;
    private $e = null;


    public function formHandler()
    {
        $oldPassword = null;
        $newPasswordRepeat = null;
        $newPassword = null;
        
        if (isset($_GET['e'])) {
            $this->e = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_SPECIAL_CHARS);
        }
        // form update
        if ($this->e == "updatePassword") {
            if (isset($_POST['oldPassword'])) {
                $oldPassword = filter_input(INPUT_POST, 'oldPassword', FILTER_SANITIZE_STRING);
            }
            if (isset($_POST['newPassword'])) {
                $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_STRING);
            }
            if (isset($_POST['newPasswordRepeat'])) {
                $newPasswordRepeat = filter_input(INPUT_POST, 'newPasswordRepeat', FILTER_SANITIZE_STRING);
            }
            
            if (isset($oldPassword) && isset( $newPassword) && isset( $newPasswordRepeat)) {
                $_SESSION['user']->updatePassword($newPassword,$newPasswordRepeat,$oldPassword);
            }
        }

        // update if account if visible or not
        if ($this->e == "updatePrivateAccount") {

            if ($_SESSION['user']->idUser != -1) {
                $_SESSION['user']->updatePrivateAccount();
                header('Location:'.$_SERVER['HTTP_REFERER']);
            }
        }
    }

    public function __construct()
    {
        $this->dashboard  = new Dashboard();
        $this->game = new Games();
    }


    public function printHTML()
    {

        $html = '<main  style="margin-top:20px ">
        <div class="container-md">';

        if ($this->e == null) {
            $html .= $this->htmlFormHead();
            $html .= $this->htmlFavoriteGames();
            $html .= $this->htmlGameTime();
        }

        if ($this->e == "updatePassword") {
            $html .= $this->htmlFormUpdatePassword();
        }

        $html .= "</div></main> ";

        echo $html;
    }

    private function htmlFormHead()
    {
        $html = "";

        $html .= '<div class=" jumbotron DarkJumbotron width100" style="background-color: #161b22;">';
          
        $html .= '<div class="container">
        <div class="row"><h2>User\'s Informations</h2></div>
        <div class="row">
          <div class="col-sm">
            <ul class="list-group">';
                $html .= '<li class="list-group-item">Username: '.$_SESSION['user']->username.'</li>';
                $html .= '<li class="list-group-item">Email: '.$_SESSION['user']->email.'</li>';
                if ($_SESSION['user']->getPrivateAccount() == 1) {
                    
                $html .= '<li class="list-group-item">Your account is visible for other users</li>';
                }else {
                    $html .= '<li class="list-group-item">Your account is not visible for other users</li>';
                }
                $html .='
            </ul>
          </div>
            <div class="col-sm">
            <div style="width: 70%; margin: auto;">
            <a href="?r=dashboard&e=updatePassword" class="btn btn-warning my-2">Update password</a>
            <a href="?r=dashboard&e=updatePrivateAccount" class="btn btn-warning my-2">Update if account is private</a>
          </div>
            </div>
        </div>';

      $html.='
          
        </div>
      </div>';

      return $html;
    }

    private function htmlFavoriteGames()
    {
        $html = '<div class="d-inline-flex  jumbotron DarkJumbotron  width100" style="background-color: #161b22;" >
        <div class="container">
        <div class="row"><h2>User\'s favorites games</h2></div>
        <div class="row cardGameBox box">
        ';

        $listGamesBrut =  $this->game->getFavoriteGamesOfUser($_SESSION['user']->idUser);

        foreach ($listGamesBrut as $key => $games) {


            $html .= $this->createCardHTML($games);
        }

        $html .= '</div>
        </div>
        </div>';
        return $html;
    }

    private function htmlGameTime()
    {
        $html = '<div class="d-inline-flex  jumbotron DarkJumbotron  width100" style="background-color: #161b22;" >
        <div class="container">
        <div class="row"><h2>User\'s time in games</h2></div>
        <div class="row cardGameBox box">
        ';

        $listGamesBrut =  $this->game->getListOfGameWithTimeUser($_SESSION['user']->idUser);
        foreach ($listGamesBrut as $key => $games) {


            $html .= $this->createCardHTMLTime($games['idGame']);
        }

        $html .= '</div>
        </div>
        </div>';
        return $html;
    }




    private function createCardHTML($game)
    {
        $html = '
        <div class="card cardBootstarp" style=" max-width: 11rem; margin:10px; padding:0; background-color: #161b22; border:2px solid #28a745;">
        <a href="?r=games&e=detail&idGame=' . $game['id'] . '">
        <img src="./img/games/' . $game['imageName'] . '." class="card-img-top imageCard"  >
        <div class="card-body ">
        <h6 class="card-title whiteTexte">' . $game['name'] . '</h5>
            ';

                    $html.= '<a class="btn btn-outline-success cardContent" href="?r=games&e=removeFavoris&idGame=' . $game['id'] . '" role="button"><i class="fa fa-heart "></i></a>';


            $html .= '
        </div>
        </a>
        </div>';
        return $html;
    }

    private function createCardHTMLTime($game)
    {
        $gameDetail = $this->game->getGameDetail($game);
        $gameDetail = $gameDetail[0];
        $gameTime = $this->game->getTimeInGameUser($_SESSION['user']->idUser, $game);
        $html = '
        <div class="card cardBootstarp" style=" max-width: 11rem; margin:10px; padding:0; background-color: #161b22; border:2px solid #28a745;">
        <img src="./img/games/' . $gameDetail['imageName'] . '." class="card-img-top imageCard"  >
        <div class="card-body ">
        <h6 class="card-title whiteTexte">' . $gameDetail['name'] . '</h5>
            <p class="greenTexte">';
            $heure = ($gameTime[0]['timeInMinute']%60);
            $minutes = (60% $gameTime[0]['timeInMinute']);
            if ($minutes == 60) {
                $heure ++;
                $minutes = 0;
            }
            $html .= $heure. "H ".$minutes. " minutes";
            $html .=' </p>
        </div>
        </div>';
        return $html;
    }

    public function htmlFormUpdatePassword()
    {
        $html = '<div class="d-inline-flex p-2 jumbotron  width100 DarkJumbotron " style="background-color: #161b22;" >
        <div class="container">
        <div class="row"><h2>Update your password</h2></div>
        <div class="row">
        
        
        <form action="?r=dashboard&e=updatePassword" method="post">
            <div class="form-group">
                <label for="oldPassword">Old password</label>
                <input type="password" class="form-control" id="oldPassword" name="oldPassword" placeholder="Old password">
            </div>
            <div class="form-group">
                <label for="newPassword">Password</label>
                <input type="password" class="form-control" id="newPassword" name="newPassword" placeholder="New password">
            </div>
            <div class="form-group">
                <label for="newPasswordRepeat">Password</label>
                <input type="password" class="form-control" id="newPasswordRepeat" name="newPasswordRepeat" placeholder="New password repeat">
            </div>

            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
        </div>
                </div>
                </div>';
                return $html;
    }
}
