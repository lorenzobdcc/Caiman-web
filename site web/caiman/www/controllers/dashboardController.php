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
        if ($this->e == "update") {
            if (isset($_POST['oldPassword'])) {
                $oldPassword = filter_input(INPUT_POST, 'oldPassword', FILTER_SANITIZE_STRING);
            }
            if (isset($_POST['newPassword'])) {
                $newPassword = filter_input(INPUT_POST, 'newPassword', FILTER_SANITIZE_STRING);
            }
            if (isset($_POST['newPasswordRepeat'])) {
                $newPasswordRepeat = filter_input(INPUT_POST, 'newPasswordRepeat', FILTER_SANITIZE_STRING);
            }
            echo "<br>npr" . $newPasswordRepeat;
            echo "<br>np" . $newPassword;
            echo "<br>p" . $oldPassword;
            
            if (isset($oldPassword) && isset( $newPassword) && isset( $newPasswordRepeat)) {
                echo"error: ".  $_SESSION['user']->updatePassword($newPassword,$newPasswordRepeat,$oldPassword);
                echo "je suis dans le form update_password";
            }else {
                echo "je suis pas dans le form update_password";
            }
        }
    }

    public function __construct()
    {
        $this->dashboard  = new Dashboard();
        $this->game = new Games();
    }

    public function writeFormUpdatePassword()
    {
        $html = '
        <form action="?r=dashboard&e=update" method="post">
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
        </form>';
        return $html;
    }
    public function printHTML()
    {
        //$_SESSION['user']->printInfos();

        $html = '<main  style="margin-top:20px ">
        <div class="container-md">';
        $html .= $this->htmlFormHead();
        $html .= $this->htmlFormContent();

        $html .= "</div></main> ";

        echo $html;
    }

    private function htmlFormHead()
    {
        $html = "";

        $html .= '<div class="jumbotron jumbotron-fluid">
        <div class="container">';
          
          $html .= '<div class="container">
        <div class="row">
          <div class="col-sm">
          <ul>
          ';
          $html .= "<li>".$_SESSION['user']->username."</li>";
          $html .= "<li>".$_SESSION['user']->email."</li>";
          $html .='
          </ul>
          </div>
          <div class="col-sm">
          ';
          $html .= $this->htmlFormupdatePassword();
          $html .='
          </div>
        </div>
      </div>';

      $html.='
          
        </div>
      </div>';

      return $html;
    }

    private function htmlFormContent()
    {
        $html = "";

        $html .= '<div class="jumbotron jumbotron-fluid">
        <div class="container">';
          
          $html .= '<div class="container">
        <div class="row">
          <div class="col-sm">
          

          ';
          $html .= $this->htmlFavoriteGames();
          $html .='
          </div>
        </div>
      </div>';

      $html.='
          
        </div>
      </div>';

      return $html;
    }

    private function htmlFormupdatePassword()
    {
        $html = "";

        $html = '
        <div style="width: 70%; margin: auto;">
        <p>Want to update password?</p>
        <a href="?r=dashboard&e=updatePassword" class="btn btn-warning my-2">Update password</a>
      </div>';

      return $html;
    }

    public function htmlFavoriteGames()
    {

        $html = '<div class="row row-cols-3 row-cols-md-2 g-4">';
        $listGamesBrut = $this->game->getFavoriteGamesOfUser($_SESSION['user']->idUser);
        foreach ($listGamesBrut as $key => $game) {

            $html .= $this->createCardHTML($game);
        }

        $html .= '</div>';
        return $html;
    }

    private function createCardHTML($game)
    {
        $html = '
        <div class="card" style=" max-width: 11rem; margin:10px;">
        <a href="?r=games&e=detail&idGame=' . $game['id'] . '">
        <img src="./img/games/' . $game['imageName'] . '." class="card-img-top imageCard"  >
        <div class="card-body">
            <h5 class="card-title greenTexte">' . $game['name'] . '</h5>
            ';
            if ($_SESSION['user']->idUser != -1) {
                if ($this->game->checkIfGameIsAlreadyInFavoris($_SESSION['user']->idUser, $game['id'])) {
                    $html.= '<a class="btn btn-outline-success " href="?r=games&e=addFavoris&idGame=' . $game['id'] . '" role="button">Add to favorite</a>';
                }else {
                    $html.= '<a class="btn btn-outline-warning " href="?r=games&e=removeFavoris&idGame=' . $game['id'] . '" role="button">Remove favorite</a>';
                }
            }

            $html .= '
        </div>
        </a>
        </div>';
        return $html;
    }
}
