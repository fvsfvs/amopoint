<?php
require_once('init.php');
$errors = [];
$auth = new Auth;
if (isset($_GET['action']) and $_GET['action']  == 'logout') {
    $auth->logOut();
}

if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $error = $auth->checkPassword();
}

?>
<!DOCTYPE html>
<html lang="ru">
    <head>
        <meta charset="UTF-8">
        <title>Авторизация</title>
        <script src="https://www.google.com/jsapi"></script>
        <link href="assets/style.css" rel="stylesheet" />
    </head>
    <body>
        <div class="login"><form method="post">
            <label class="margin-5">Логин</label>
            <input class="ui-input margin-5" type="text" name="login" placeholder="" value="">
            <label class="margin-5">Пароль</label>
            <input class="ui-input margin-5" type="password" name="password" placeholder="">
            <input type="submit" class="button button--success margin-5" value ="Авторизоваться">
            <p class="error"><?=isset($error) ? $error: '' ?></p>

</form></div>   
    </body>
</html>