<?php
namespace Project\Controllers;

use \Core\Controller;
use \Project\Components\Helper;
use \Project\Models\User;

class LoginController extends Controller
{
    public function index() {
        if ($_SERVER['REQUEST_URI'] === '/') {
            return $this->redirect('/login/');
        }

        session_start();
        if (isset($_SESSION['user'])) {
            return $this->redirect(START_PAGE);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return $this->login();
        }
        $this->title = 'Авторизация';
        $this->layout = "no_header";
        return $this->render('login/index');
    }

    public function login() {
        $errors = '';
        if (!isset($_POST['login']) || trim($_POST['login']) === '') {
            $errors .= "Логин не введён\n";
        }
        if (!isset($_POST['pass']) || $_POST['pass'] === '') {
            $errors .= "Пароль не введён\n";
        }
        if ($errors !== '') {
            $this->layout = "empty";
            return $this->render('error/error', ['msg' => trim($errors)]);
        }
        $login = $_POST['login'];
        $pass = $_POST['pass'];
        $user = User::getByLoginPass($login, $pass);
        if (gettype($user) == 'string') {
            $this->layout = "empty";
            return $this->render('error/error', ['msg' => $user]);
        }
        $_SESSION['user'] = $user;
        return $this->redirect(START_PAGE);
    }

    public function logout() {
        session_start();
        $_SESSION['user'] = NULL;
        $_SESSION['chat'] = NULL;
        return $this->redirect('/');
    }
}
?>