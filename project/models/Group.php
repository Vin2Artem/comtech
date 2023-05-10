<?php
namespace Project\Models;

use \Core\Model;

class Group extends Model
{
    public $id;
    public $name;
    public $date;
    public $teacherId;
    public $courseId;

    protected function __construct(int $id, string $name, $date, int $teacher, int $course)
    {
        $this->id = $id;
        $this->name = $name;
        $this->date = $date;
        $this->teacherId = $teacher;
        $this->courseId = $course;
    }

    public static function getAll() {
        $groups_db = self::findManySafe('SELECT * FROM group');
        if ($groups_db === NULL) {
            return "Группы отсутствуют";
        }
        if ($groups_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }

        $groups = [];
        foreach ($groups_db as $group_db) {
            $groups[] = new Group(
                $group_db['id'],
                $group_db['name'],
                $group_db['date'],
                $group_db['teacher'],
                $group_db['course']
            );
        }
        return $groups;
    }

    public static function getById(int $id)
    {
        $group_db = self::findOneSafe('SELECT * FROM `group` WHERE id = ?', 'i', [$id]);
        if ($group_db === NULL) {
            return "Группа с идентификатором $id не найдена";
        }
        if ($group_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        return new Group(
            $group_db['id'],
            $group_db['name'],
            $group_db['date'],
            $group_db['teacher'],
            $group_db['course']
        );
    }

    public static function addGroup(string $name, $date, int $teacher, int $course) {
        if (self::querySafe(
            'INSERT INTO `group` (name, `date`, teacher, course) VALUES (?, ?, ?, ?)',
            'ssii',
            [$name, $date, $teacher, $course]
        ) === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        };
        return true;
    }

    public function editGroup(string $name, $date, int $teacher, int $course) {
        if (self::querySafe(
            'UPDATE `group` SET name = ?, `date` = ?, teacher = ?, course = ? WHERE id = ?',
            'ssiii',
            [$name, $date, $teacher, $course, $this->id]
        ) === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        };
        return true;
    }
}
?>