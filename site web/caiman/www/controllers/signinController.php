<?php
$signin = new Signin();


if (isset($_POST['username'])) {
    $username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
}
if (isset($_POST['password'])) {
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
}
if (isset($_POST['passwordRepeat'])) {
    $passwordRepeat = filter_input(INPUT_POST, 'passwordRepeat', FILTER_SANITIZE_SPECIAL_CHARS);
}
if (isset($_POST['email'])) {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
}

if (isset($password) && isset( $username) && isset($passwordRepeat)) {

    if ($password != $passwordRepeat) {
        header('Location: ?r=signin&e=1');
        exit;
    }
$signin->insert_username = $username;
$signin->insert_password = $password;
$signin->insert_email = $email;

$signin->newUser();

}else
{
    echo "les champs ne sont pas renmpli";
}

?>