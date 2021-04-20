<?php
$login = new Login();


if (isset($_POST['username'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
}
if (isset($_POST['password'])) {
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
}

if (isset($password) && isset( $username)) {
    $login->search_username = $username;
$login->search_password = $password;

$usersInfos = $login->checkLogin();

if (isset($usersInfos)) {

    $_SESSION['user'] = new User($usersInfos[0]['username'],$usersInfos[0]['email'],$usersInfos[0]['idRole']);
    header('Location: ?r=dashboard');
    echo "login en cours";
}
}

?>