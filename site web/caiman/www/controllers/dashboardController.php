<?php

include_once "./models/class.php";
class DashboardController
{
    public $dashboard;
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
                echo "old pass";
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
    }

    public function writeFormUpdatePassword()
    {
        ?>
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
        </form>
        <?php
    }
    public function printHTML()
    {
        $_SESSION['user']->printInfos();
        $this->writeFormUpdatePassword();
    }
}
