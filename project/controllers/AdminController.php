<?php
namespace Project\Controllers;

use \Core\Controller;
use Project\Components\Helper;
use Project\Models\Contract;
use Project\Models\Role;
use Project\Models\User;

class AdminController extends Controller
{
    public function index() {
        session_start();
        if (!isset($_SESSION['user'])) {
            return $this->redirect('/');
        }

        $user = $_SESSION['user'];

        if ($user->role !== "Менеджер") {
            Helper::log("Попытка обращения к административной странице. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
            return $this->redirect(START_PAGE);
        }

        $this->title = 'Администрирование';

        return $this->render('admin/index', [
            'user' => $user
        ]);
    }

    public function indexUsers() {
        session_start();
        if (!isset($_SESSION['user'])) {
            return $this->redirect('/');
        }

        $user = $_SESSION['user'];

        if ($user->role !== "Менеджер") {
            Helper::log("Попытка обращения к странице управления пользователями. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
            return $this->redirect(START_PAGE);
        }

        $this->title = 'Пользователи';

        return $this->render('admin/users/index', [
            'user' => $user,
            'users' => User::getAll(),
        ]);
    }

    public function indexContracts() {
        session_start();
        if (!isset($_SESSION['user'])) {
            return $this->redirect('/');
        }

        $user = $_SESSION['user'];

        if ($user->role !== "Менеджер") {
            Helper::log("Попытка обращения к странице управления договорами. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
            return $this->redirect(START_PAGE);
        }

        $this->title = 'Договора';

        return $this->render('admin/contracts/index', [
            'user' => $user,
            'contracts' => Contract::getAll(),
        ]);
    }

    public function searchUser(array $params) {

    }

    public function addUser(array $params) {
        session_start();
        if (!isset($_SESSION['user'])) {
            return $this->redirect('/');
        }

        $user = $_SESSION['user'];

        if ($user->role !== "Менеджер") {
            Helper::log("Попытка обращения к странице добавления пользователя. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
            return $this->redirect(START_PAGE);
        }

        return $this->render('admin/users/add', [
            'user' => $user,
        ]);
    }

    public function editUser(array $params) {
        session_start();
        if (!isset($_SESSION['user'])) {
            return $this->redirect('/');
        }

        $user = $_SESSION['user'];

        if ($user->role !== "Менеджер") {
            Helper::log("Попытка обращения к странице обновления пользователя. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
            return $this->redirect(START_PAGE);
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $this->editUserPost($params);
        }

        $this->title = 'Изменение данных пользователя';

        return $this->render('admin/users/edit', [
            'user' => $user,
            'userEdit' => User::getById($params['id']),
            'roles' => Role::getAll()
        ]);
    }

    public function editUserPost(array $params) {
        $errors = '';
        if (!isset($_POST['login']) || $_POST['login'] === '') {
            $errors .= "Логин не введён\n";
        }
        if (!isset($_POST['surname']) || $_POST['surname'] === '') {
            $errors .= "Фамилия не введена\n";
        }
        if (!isset($_POST['name']) || $_POST['name'] === '') {
            $errors .= "Имя не введено\n";
        }
        if (!isset($_POST['phone']) || $_POST['phone'] === '') {
            $errors .= "Телефон не введён\n";
        }
        if (!isset($_POST['role']) || $_POST['role'] === '') {
            $errors .= "Роль не указана\n";
        }

        if ($errors !== '') {
            $this->layout = "empty";
            return $this->render('error/error', ['msg' => trim($errors)]);
        }

        $user = $_SESSION['user'];
        $msg = $user->editUser($params['id'], $_POST["login"], $_POST["surname"], $_POST["name"], $_POST["patronymic"], $_POST["phone"], $_POST["avatar"], $_POST["role"]);

        if ($msg !== true) {
            $this->layout = "empty";
            return $this->render('error/error', ['msg' => trim($errors)]);
        }
    }

    public function deleteUser(array $params) {
        session_start();
        if (!isset($_SESSION['user'])) {
            return $this->redirect('/');
        }

        $user = $_SESSION['user'];

        if ($user->role !== "Менеджер") {
            Helper::log("Попытка обращения к странице удаления пользователя. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
            return $this->redirect(START_PAGE);
        }

        return $this->render('admin/users/delete', [
            'user' => $user,
            'userEdit' => User::getById($params['id']),
        ]);
    }

    public function addContract(array $params) {
        // #
    }

    public function editGroup(array $params) {
        // #
    }

    public function addCourse(array $params) {
        // #
    }

    public function editCourse(array $params) {
        // #
    }
}