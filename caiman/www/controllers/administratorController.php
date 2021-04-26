<?php

include_once "./models/class.php";
class AdministratorController
{
    public $administrator;
    public $game;
    public $categorie;
    private $e = null;
    private $idGameToUpdate;


    public function formHandler()
    {
        $result = null;

        if (isset($_GET['e'])) {
            $this->e = filter_input(INPUT_GET, 'e', FILTER_SANITIZE_STRING);
        }
        // update game
        if ($this->e == "updateGame") {
            if (isset($_GET['id'])) {
                $requestGame = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
                $this->idGameToUpdate = $requestGame;
            }
        }

        // add game categorie
        if ($this->e == "addGameCategorie") {
            if (isset($_GET['id'])) {
                $requestGame = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
                $this->idGameToUpdate = $requestGame;
            }
        }

        //add game
        if ($this->e == "addGameUpload") {
            if (isset($_POST['name'])) {
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            } else {
                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            if (isset($_POST['description'])) {
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            } else {
                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            if (isset($_POST['imageName'])) {
                $imageName = filter_input(INPUT_POST, 'imageName', FILTER_SANITIZE_STRING);
            } else {
                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            if (isset($_POST['console'])) {
                $consoleId = filter_input(INPUT_POST, 'console', FILTER_SANITIZE_STRING);
            } else {
                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            if (isset($_POST['gameFileName'])) {
                $gameFileName = filter_input(INPUT_POST, 'gameFileName', FILTER_SANITIZE_STRING);
            } else {
                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }


            $this->administrator->addGame($name, $description, $imageName, $consoleId, $gameFileName);

            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }

         //add game
         if ($this->e == "updateGameUpdate") {
            if (isset($_POST['name'])) {
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            } else {
                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            if (isset($_POST['description'])) {
                $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
            } else {
                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            if (isset($_POST['console'])) {
                $consoleId = filter_input(INPUT_POST, 'console', FILTER_SANITIZE_STRING);
            } else {
                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }

            if (isset($_POST['idGame'])) {
                $idGame = filter_input(INPUT_POST, 'idGame', FILTER_SANITIZE_STRING);
            } else {
                header('Location:' . $_SERVER['HTTP_REFERER']);
                exit;
            }


            $this->administrator->updateGame($idGame, $name, $description, $consoleId);

            header('Location:' . $_SERVER['HTTP_REFERER']);
            exit;
        }


        if ($this->e == "addCategorie") {
            if (isset($_POST['name'])) {
                $name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_STRING);
            }

            if (isset($name)) {
                $result = $this->categorie->addCategorie($name);
            }
        }
    }

    public function __construct()
    {
        $this->administrator  = new Administrator();
        $this->game = new Games();
        $this->categorie = new Categories();
    }


    public function printHTML()
    {

        $html = '<main style="margin-top:20px">
        <div class="container-md">';

        if ($this->e == null) {
            $html .= $this->htmlAdministratorHome();
        }

        if ($this->e == "addGame") {
            $html .= $this->htmlNewGame();
        }

        if ($this->e == "updateGame") {
            $html .= $this->htmlUpdateGame();
        }

        if ($this->e == "addCategorie") {
            $html .= $this->htmlAddCategorie();
        }

        if ($this->e == "addGameCategorie") {
            $html .= $this->htmlAddCategorieToGame();
        }



        $html .= "</div></main> ";
        echo $html;
    }

    private function htmlAdministratorHome()
    {

        $html = "";

        $html .= '<div class=" jumbotron DarkJumbotron width100" style="background-color: #161b22;">';

        $html .= '<div class="container">
            <div class="row"><h2>Administrator pannel</h2></div>
            <div class="row">
              <div class="col-sm">
               <p>To update a game you need to go on his own page and click on the update button</p>
              </div>
                <div class="col-sm">
                    <div style="width: 70%; margin: auto;">
                        <a href="?r=administrator&e=addGame" class="btn btn-warning my-2">Add new game</a>
                        <a href="?r=administrator&e=addCategorie" class="btn btn-warning my-2">Add new catégorie</a>
                    </div>
                </div>
            </div>';

        $html .= '
              
            </div>
          </div>';

        return $html;
    }

    private function htmlNewGame()
    {
        $html = "";

        $html .= '<div class="jumbotron jumbotron-fluid DarkJumbotron width100" style="background-color: #161b22;"">
        <div class="container">';

        $html .= '<div class="container">
        <div class="row">
          <div class="col-sm">
          <div style="width: 70%; margin: auto;">
        <h2>Add game</h2>
        <form action="?r=administrator&e=addGameUpload" method="post" enctype="multipart/form-data">
              <div class="form-group">
                <label for="name">Game\'s name</label>
                <input type="texte" name="name" class="form-control" id="name" aria-describedby="name" placeholder="Enter name">
              </div>
              <div class="form-group">
                <label for="description">Game\'s description</label>
                <textarea class="form-control" id="description" name="description" rows="5"></textarea>
              </div>
              <div class="form-group">
                <label for="ImageName">Game\'s image name</label>
                <p>Example: Super Mario Sunshine -> SUPER_MARIO_SUNSHINE.png </p>
                <input type="texte" name="imageName" class="form-control" id="imageName" aria-describedby="imageName" placeholder="Enter image name">
              </div>
              <div class="form-group">
                <label for="file">Image File</label>
                <input type="file" class="form-control-file" id="image" name="image">
              </div>
              <div class="form-group">
                <label for="file">Console</label>
                <select class="form-control" name="console">
                    ';
        $html .= $this->htmlgetListConsole();
        $html .= '
                </select>
              </div>
              <div class="form-group">
                <label for="gameFileName">Game\'s file name</label>
                <p>Example: Super Mario Sunshine -> SUPER_MARIO_SUNSHINE.iso </p>
                <input type="texte" name="gameFileName" class="form-control" id="gameFileName" aria-describedby="gameFileName" placeholder="Enter file name">
              </div>
              <div class="form-group">
                <label for="file">Game file</label>
                <input type="file" class="form-control-file" id="fileGame" name="fileGame">
              </div>

              <div class="form-group">
              <button type="submit" class="btn btn-success">Add Game</button>
            </div>          
          </form>
      </div>
          </div>

        </div>
      </div>';

        $html .= '
          
        </div>
      </div>';

        return $html;
    }

    private function htmlAddCategorieToGame()
    {
        $gameData = $this->game->getGameDetail($this->idGameToUpdate);
        $html = "";

        $html .= '<div class="jumbotron jumbotron-fluid DarkJumbotron width100" style="background-color: #161b22;"">
        <div class="container">';

        $html .= '<div class="container">
        <div class="row">
          <div class="col-sm">
          <div style="width: 70%; margin: auto;">
        <h2>Update game</h2>
        <form action="?r=administrator&e=updateGameUpdate" method="post" enctype="multipart/form-data">
        <input id="idGame" name="idGame" type="hidden" value="' . $gameData[0]['id'] . '">
              <div class="form-group">
                <label for="name"></label>
                <input type="texte" name="name" class="form-control" id="name" aria-describedby="name" placeholder="Enter name" value="' . $gameData[0]['name'] . '">
              </div>
              <div class="form-group">
                <label for="file">Console</label>
                <select class="form-control" name="console">
                    ';
        $html .= $this->htmlgetListConsole();
        $html .= '
                </select>
              </div>

              <div class="form-group">
              <button type="submit" class="btn btn-success">Update Game</button>
            </div>          
          </form>
      </div>
          </div>

        </div>
      </div>';

        $html .= '
          
        </div>
      </div>';

        return $html;
    }
    private function htmlUpdateGame()
    {
        $gameData = $this->game->getGameDetail($this->idGameToUpdate);
        $html = "";

        $html .= '<div class="jumbotron jumbotron-fluid DarkJumbotron width100" style="background-color: #161b22;"">
        <div class="container">';

        $html .= '<div class="container">
        <div class="row">
          <div class="col-sm">
          <div style="width: 70%; margin: auto;">
        <h2>Update game</h2>
        <form action="?r=administrator&e=updateGameUpdate" method="post" enctype="multipart/form-data">
        <input id="idGame" name="idGame" type="hidden" value="' . $gameData[0]['id'] . '">
              <div class="form-group">
                <label for="name">Game\'s name</label>
                <input type="texte" name="name" class="form-control" id="name" aria-describedby="name" placeholder="Enter name" value="' . $gameData[0]['name'] . '">
              </div>
              <div class="form-group">
                <label for="description">Game\'s description</label>
                <textarea class="form-control" id="description" name="description" rows="5" >' . $gameData[0]['description'] . '</textarea>
              </div>
              <div class="form-group">
                <label for="file">Console</label>
                <select class="form-control" name="console">
                    ';
        $html .= $this->htmlgetListConsole();
        $html .= '
                </select>
              </div>

              <div class="form-group">
              <button type="submit" class="btn btn-success">Update Game</button>
            </div>          
          </form>
      </div>
          </div>

        </div>
      </div>';

        $html .= '
          
        </div>
      </div>';

        return $html;
    }

    private function htmlgetListConsole()
    {
        $html = "";

        foreach ($this->administrator->getListConsole() as $key => $console) {
            $html .= '<option value="' . $console['id'] . '">' . $console['name'] . '</option>';
        }

        return $html;
    }

    private function htmlAddCategorie()
    {

        $html = "";

        $html .= '<div class="jumbotron jumbotron-fluid DarkJumbotron width100" style="background-color: #161b22;"">
        <div class="container">';

        $html .= '<div class="container">
        <div class="row">
          <div class="col-sm">
          <div style="width: 70%; margin: auto;">
        <h2>Add categorie</h2>
        <form action="?r=administrator&e=addCategorie" method="post">
              <div class="form-group">
                <label for="username">Categorie\'s name</label>
                <input type="texte" name="name" class="form-control" id="name" aria-describedby="name" placeholder="Enter name">
              </div>

              <div class="form-group">
              <button type="submit" class="btn btn-success">Add</button>
            </div>          
          </form>
      </div>
          </div>
          <div class="col-sm">
          
          </div>
        </div>
      </div>';

        $html .= '
          
        </div>
      </div>';

        return $html;
    }
}