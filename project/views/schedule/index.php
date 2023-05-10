<?php include "project/templates/left.php";
use Project\Models\Course;
use Project\Models\Group;
use Project\Models\Schedule;
use Project\Models\User;

$CATALOG = "/schedule";

function getDay(int $day) {
    switch ($day) {
        case 1:
            return "Понедельник";
        case 2:
            return "Вторник";
        case 3:
            return "Среда";
        case 4:
            return "Четверг";
        case 5:
            return "Пятница";
        case 6:
            return "Суббота";
        case 7:
            return "Воскресенье";
        default:
            return "Неверный номер дня недели";
    }
}

function getLesson(Schedule $shed) {
    $group = Group::getById($shed->groupId);
    $course = Course::getById($group->courseId);
    $teacher = User::getById($group->teacherId);
    return $group->name . "<br>" . $course->name . "<br>" . $teacher->nick;
}

function role($user) {
    return $user->role;
}
?>

<div class="content">
    <h1>Расписание</h1>

    <table class="schedule">
        <thead>
            <tr>
                <th>День недели</th>
                <th>Время</th>
                <th>Занятие</th>
                <th>Аудитория</th>
                <?php if (role($user) === "Менеджер") {
                    echo "<th colspan='2'>Управление</th>";
                } ?>
            </tr>
        </thead>
        <?php
        for ($i = 1; $i <= 7; $i++) {
            $sheds_day = Schedule::getForDay($schedule, $i);
            if ($sheds_day === []) {
                continue;
            }
            $day = getDay($i);
            $one = 0;
            echo "<tbody>";
            foreach (Schedule::getForTime($sheds_day) as $time => $shed_time) {
                echo "<tr>";
                if ($one === 0) {
                    echo "<td rowspan='" . count($sheds_day) . "' class='rotated'>" . $day . "</td>";
                    $one = 1;
                }
                echo "<td rowspan='" . count($shed_time) . "'>" . $time . "-" . date("H:i", strtotime($time . "+90 minutes")) . "</td>";
                echo "<td>" . getLesson($shed_time[0]) . "</td>";
                echo "<td class='centered'>" . $shed_time[0]->audience . "</td>";
                if (role($user) === "Менеджер") {
                    echo "<td class='centered'><a href='$CATALOG/edit/{$shed_time[0]->id}'><img src='\project\webroot\images\admin\pencil-square.svg' alt='Редактировать' class='s-32'></a></td>";
                    echo "<td class='centered'><a href='$CATALOG/delete/{$shed_time[0]->id}'><img src='/project/webroot/images/admin/round-delete-forever.svg' alt='Удалить' class='s-40'></a></td>";
                }
                echo "</tr>";
                for ($j = 1; $j < count($shed_time); $j++) {
                    echo "<tr>";
                    echo "<td>" . getLesson($shed_time[$j]) . "</td>";
                    echo "<td class='centered'>" . $shed_time[$j]->audience . "</td>";
                    if (role($user) === "Менеджер") {
                        echo "<td class='centered'><a href='$CATALOG/edit/{$shed_time[$j]->id}'><img src='\project\webroot\images\admin\pencil-square.svg' alt='Редактировать' class='s-32'></a></td>";
                    echo "<td class='centered'><a href='$CATALOG/delete/{$shed_time[$j]->id}'><img src='/project/webroot/images/admin/round-delete-forever.svg' alt='Удалить' class='s-40'></a></td>";
                    }
                    echo "</tr>";
                }
            }
            echo "</tbody>";
        }
        ?>
    </table>

</div>