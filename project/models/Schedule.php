<?php
namespace Project\Models;

use \Core\Model;

class Schedule extends Model
{
    public $id;
    public $groupId;
    public $day;
    public $time;
    public $audience;

    private static $times = [];

    protected function __construct(int $id, int $group, int $day, $time, string $audience)
    {
        $this->id = $id;
        $this->groupId = $group;
        $this->day = $day;
        $this->time = $time;
        $this->audience = $audience;
    }

    public static function getAll() {
        $schedules_id = self::findManySafe('SELECT s.id, `group`, day, time, name AS audience FROM schedule s JOIN audience a ON s.audience = a.id');
        if ($schedules_id === NULL) {
            return "В расписании нет занятий";
        }
        if ($schedules_id === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }

        $schedules = [];
        foreach ($schedules_id as $schedule_id) {
            self::$times[] = $schedule_id['time'] = date("H:i", strtotime($schedule_id['time']));
            $schedules[] = new Schedule(
                $schedule_id['id'],
                $schedule_id['group'],
                $schedule_id['day'],
                $schedule_id['time'],
                $schedule_id['audience']
            );
        }
        self::$times = array_unique(self::$times);
        return $schedules;
    }

    public static function getForDay(array $schedules, int $day) {
        $ret = [];
        foreach ($schedules as $schedule) {
            if ($schedule->day === $day) {
                $ret[] = $schedule;
            }
        }
        return $ret;
    }

    public static function getForTime($schedules) {
        $result = array();
        foreach ($schedules as $schedule) {
            $time = $schedule->time;
            if (!isset($result[$time])) {
                $result[$time] = array();
            }
            $result[$time][] = $schedule;
        }
        ksort($result);
        return $result;
    }
    

    public static function getById(int $id)
    {
        $schedule_id = self::findOneSafe('SELECT s.id, `group`, day, time, name AS audience FROM schedule s JOIN audience a ON s.audience = a.id WHERE s.id = ?', 'i', [$id]);
        if ($schedule_id === NULL) {
            return "Занятие с идентификатором $id не найдено";
        }
        if ($schedule_id === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        return new Schedule(
            $schedule_id['id'],
            $schedule_id['group'],
            $schedule_id['day'],
            $schedule_id['time'],
            $schedule_id['audience']
        );
    }

    public static function addShedule(int $group, int $day, int $time, string $audience) {
        // #
    }

    public function editShedule(int $group, int $day, int $time, string $audience) {
        // #
    }
}
?>