<?php
namespace Project\Models;

use \Core\Model;
use Project\Components\Helper;

trait UserInit
{
    protected function __construct(int $id, string $login, string $name, string $surname, string $patronymic, string $phone, string $role) {
        $this->id = $id;
        $this->login = $login;
        $this->name = $name;
        $this->surname = $surname;
        $this->patronymic = isset($patronymic) ? $patronymic : '';
        $this->phone = $phone;

        if (file_exists("/project/webroot/avatars/$id.jpg")) {
            $this->avatar = "/project/webroot/avatars/$id.jpg";
        } elseif (file_exists("/project/webroot/avatars/$id.png")) {
            $this->avatar = "/project/webroot/avatars/$id.png";
        } elseif (file_exists("/project/webroot/avatars/$id.gif")) {
            $this->avatar = "/project/webroot/avatars/$id.gif";
        } else {
            $this->avatar = '/project/webroot/avatars/default.jpg';
        }

        $name1 = mb_substr($this->name, 0, 1) . ".";
        $patr1 = $this->patronymic !== '' ? mb_substr($this->patronymic, 0, 1) . '.' : '';
        $this->nick = trim("$this->surname $name1 $patr1");

        $this->role = $role;
        //Helper::log("Объект $role создан");
    }
}

abstract class User extends Model
{
    public $id;
    public $login;
    public $name;
    public $surname;
    public $patronymic;
    public $phone;
    public $avatar;
    public $role;
    public $nick;

    public static function getByLoginPass(string $login, string $pass) {
        $user_db = self::findOneSafe("SELECT u.id, login, pass, name, surname, patronymic, phone, ut.role FROM user u JOIN usertype ut ON u.type = ut.id WHERE login = ?", "s", [$login]);
        if ($user_db === NULL) {
            return "Пользователь с логином $login не найден";
        }
        if ($user_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        if (!password_verify($pass, $user_db['pass'])) {
            return "Неверный пароль для пользователя $login";
        }
        return self::initByRole($user_db);
    }

    public static function getById(int $id) {
        $user_db = self::findOneSafe('SELECT u.id, login, pass, name, surname, patronymic, phone, ut.role FROM user u JOIN usertype ut ON u.type = ut.id WHERE u.id = ?', 'i', [$id]);
        if ($user_db === NULL) {
            return "Пользователь с идентификатором $id не найден";
        }
        if ($user_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        return self::initByRole($user_db);
    }

    public static function getAll() {
        $users_db = self::findManySafe('SELECT u.id, login, pass, name, surname, patronymic, phone, ut.role FROM user u JOIN usertype ut ON u.type = ut.id');
        if ($users_db === NULL) {
            return "Пользователи отсутствуют";
        }
        if ($users_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        $users = [];
        foreach ($users_db as $user_db) {
            $temp = self::initByRole($user_db);
            if (gettype($temp) === "string") {
                Helper::log($temp);
            } else {
                $users[] = $temp;
            }
        }
        return $users;
    }

    public function changeAvatar() {
        // #
    }

    public function changePass() {
        // #
    }

    public function printFields() {
        return array(
            "login" => ["Логин", $this->login],
            "surname" => ["Фамилия", $this->surname],
            "name" => ["Имя", $this->name],
            "patronymic" => ["Отчество", $this->patronymic],
            "phone" => ["Телефон", $this->phone],
            "avatar" => ["Аватар", $this->avatar],
            "role" => ["Роль", $this->role],
        );
    }


    public function getUserInfo() {
        return "ID = $this->id, Логин = $this->login, Фамилия = $this->surname, Имя = $this->name, Отчество = $this->patronymic, Телефон = $this->phone, Аватар = $this->avatar, Роль = $this->role";
    }

    private static function initByRole(array $user_db) {
        switch ($user_db['role']) {
            case "Менеджер":
                return new Manager(
                    $user_db['id'],
                    $user_db['login'],
                    $user_db['name'],
                    $user_db['surname'],
                    $user_db['patronymic'],
                    $user_db['phone'],
                    $user_db['role']
                );
            case "Заказчик":
                return new Customer(
                    $user_db['id'],
                    $user_db['login'],
                    $user_db['name'],
                    $user_db['surname'],
                    $user_db['patronymic'],
                    $user_db['phone'],
                    $user_db['role']
                );
            case "Преподаватель":
                return new Teacher(
                    $user_db['id'],
                    $user_db['login'],
                    $user_db['name'],
                    $user_db['surname'],
                    $user_db['patronymic'],
                    $user_db['phone'],
                    $user_db['role']
                );
            case "Обучающийся":
                return new Student(
                    $user_db['id'],
                    $user_db['login'],
                    $user_db['name'],
                    $user_db['surname'],
                    $user_db['patronymic'],
                    $user_db['phone'],
                    $user_db['role']
                );
            default:
                return "Неизвестный тип пользователя (id = " . $user_db['id'] . ")";
        }
    }
}
?>