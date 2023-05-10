<?php
namespace Project\Models;

use Project\Components\Helper;
use Project\Models\Group;

class Manager extends User
{
        use UserInit;

        public function addSchedule() {
                // #
        }

        public function editSchedule() {
                // #
        }

        public function addNews(string $title, string $description, $date, array $groupIds) {
                // #
        }

        public function editNews(string $title, string $description, array $groupIds) {
                // #
        }

        public function deleteNews(int $newsId) {
                // #
        }

        public function addUser(string $login, string $pass, string $surname, string $name, $patronymic, string $phone, $avatar, string $role) {
                // #
        }

        public function editUser(int $id, string $login, string $surname, string $name, $patronymic, string $phone, $avatar, int $role) {
                if (!isset($patronymic) || trim($patronymic) === '') {
                        $patronymic = "";
                }
                if (
                        self::querySafe(
                                'UPDATE user SET login=?, surname=?, name=?, patronymic=?, phone=?, avatar=?, type=? WHERE id=?',
                                'ssssssii',
                                [$login, $surname, $name, $patronymic, $phone, $avatar, $role, $id]
                        ) === false
                ) {
                        return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
                }
                ;
                return true;
        }

        public function addContract() {
                // #
        }

        private function addGroup(string $name, $date, int $teacher, int $course) {
                return Group::addGroup($name, $date, $teacher, $course);
        }

        public function editGroup(Group $group, string $name, $date, int $teacher, int $course) {
                return $group->editGroup($name, $date, $teacher, $course);
        }

        private function addCourse(string $name, int $stages) {
                return Course::addCourse($name, $stages);
        }

        public function editCourse(Course $course, string $name, int $stages) {
                return $course->editCourse($name, $stages);
        }
}
?>