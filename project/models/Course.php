<?php
namespace Project\Models;

use \Core\Model;

class Course extends Model
{
    public $id;
    public $name;
    public $stages;

    protected function __construct(int $id, string $name, int $stages)
    {
        $this->id = $id;
        $this->name = $name;
        $this->stages = $stages;
    }

    public static function getById(int $id)
    {
        $course_db = self::findOneSafe('SELECT * FROM course WHERE id = ?', 'i', [$id]);
        if ($course_db === NULL) {
            return "Курс с идентификатором $id не найден";
        }
        if ($course_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        return new Course(
            $course_db['id'],
            $course_db['name'],
            $course_db['stages']
        );
    }
    
    public static function getAll() {
        $courses_db = self::findManySafe('SELECT * FROM course');
        if ($courses_db === NULL) {
            return "Курсы отсутствуют";
        }
        if ($courses_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }

        $courses = [];
        foreach ($courses_db as $course_db) {
            $courses[] = new Course(
                $course_db['id'],
                $course_db['name'],
                $course_db['stages']
            );
        }
        return $courses;
    }

    public static function addCourse(string $name, int $stages) {
        if (self::querySafe(
            'INSERT INTO course (name, stages) VALUES (?, ?)',
            'si',
            [$name, $stages]
        ) === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        };
        return true;
    }

    public function editCourse(string $name, int $stages) {
        if (self::querySafe(
            'UPDATE course SET name = ?, stages = ? WHERE id = ?',
            'ssiii',
            [$name, $stages, $this->id]
        ) === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        };
        return true;
    }
}
?>