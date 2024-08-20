<?php
class Auth
{

    private $db;

    function __construct(){
        global $db;
        $this->db = $db;      
    }

    function authGetUser() {
       
        $user = null;
        if (isset($_SESSION['token'])) {
            $token = $_SESSION['token'];
        }
        else if (isset($_COOKIE['token'])) {
            $token = $_COOKIE['token'];
        } 
        else {
            $token = null;
        } 
        if($token !== null){
            $session = $this->sessionsOne($token);

            if($session !== null){
                $user = $this->userById($session['user_id']);
            }
            if($user === null){
                if (isset($_SESSION['token'])) {
                    unset($_SESSION['token']);
                }
                setcookie('token', '', time() - 1, BASE_URL);
                header('Location: auth.php');
            }
        }
        return $user;
    }

    function sessionsAdd($userId, $token) {
        $params = ['uid' => $userId, 'token' => $token];
        $sql = "INSERT INTO sessions (user_id, token) VALUES (:uid, :token)";
        $this->db->query($sql, $params);
        return true;
    }

    function sessionsOne($token) {
        $sql = "SELECT * FROM sessions WHERE token=:token";
        $res = $this->db->select($sql, ['token' => $token]);
        $session = $res[0];
        return $session == false ? null : $session;
    }

    function userById($id) {
        $sql = "SELECT * FROM users WHERE user_id=:id";
        $res = $this->db->select($sql, ['id' => $id]);
        $user = $res[0];
        return $user === false ? null : $user;
    }

    function userByLogin($login) {
        $sql = "SELECT user_id,password FROM users WHERE login=:login";
        $res = $this->db->select($sql, ['login' => $login]);
        $user = isset($res[0]) ? $res[0] : null;
        return $user;
    }

    function checkPassword(){
        if(($_SERVER['REQUEST_METHOD'] === 'POST') and isset($_POST['login'])){
            $login = trim($_POST['login']);
            $password = $_POST['password'];
                
            if($login != '' && $password != ''){
                $user = $this->userByLogin($login);
        
                if($user !== null && password_verify($password, $user['password'])){
                    $token = substr(bin2hex(random_bytes(128)), 0, 128);
                    $this->sessionsAdd($user['user_id'], $token);
                    $_SESSION['token'] = $token;
                    setcookie('token', $token, time() + 3600);
                    header('Location: index.php');
                    exit();
                }
                else {
                    return 'Неверный логин или пароль';
                }
            }
            else {
                return 'Заполните логин и пароль';
            }
        }
        else {
            return 'Заполните логин и пароль';
        }
    }

    public function logout(){
        if (isset($_SESSION['token'])) {
            unset($_SESSION['token']);
        }
        setcookie('token', '', time() - 1);
    }
}