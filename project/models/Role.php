<?php
namespace Project\Models;

use \Core\Model;

class Role extends Model
{
    public $id;
    public $value;

    protected function __construct(int $id, string $value)
    {
        $this->id = $id;
        $this->value = $value;
    }

    public static function getAll() {
        $roles_db = self::findManySafe('SELECT * FROM usertype');
        if ($roles_db === NULL) {
            return "Роли отсутствуют";
        }
        if ($roles_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }

        $roles = [];
        foreach ($roles_db as $role_db) {
            $roles[] = new Role(
                $role_db['id'],
                $role_db['role']
            );
        }
        return $roles;
    }
}
?>