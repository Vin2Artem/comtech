<?php
namespace Project\Models;

use \Core\Model;

class Contract extends Model
{
    public $id;
    public $number;
    public $cost;
    public $groupId;
    public $studentId;
    public $customerId;

    public function __construct(int $id, string $number, float $cost, int $group, int $student, int $customer) {
        $this->id = $id;
        $this->number = $number;
        $this->cost = $cost;
        $this->groupId = $group;
        $this->studentId = $student;
        $this->customerId = $customer;
    }

    /*public static function getById(int $id)
    {
    $contract_db = self::findOneSafe('SELECT * FROM contract WHERE id = ?', 'i', [$id]);
    if ($contract_db === NULL) {
    return "Договор с идентификатором $id не найден";
    }
    if ($contract_db === false) {
    return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
    }
    return new Contract(
    $contract_db['id'],
    $contract_db['number'],
    $contract_db['cost'],
    $contract_db['group'],
    $contract_db['student'],
    $contract_db['customer']
    );
    }*/

    public static function getAllByUser(int $userId) {
        $contracts_db = self::findManySafe('SELECT * FROM contract WHERE customer = ?', 'i', [$userId]);
        if ($contracts_db === NULL) {
            return "Договоров для пользователя с идентификатором $userId не найдено";
        }
        if ($contracts_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        $contracts = [];
        foreach ($contracts_db as $contract_db) {
            $contracts[] = new Contract(
                $contract_db['id'],
                $contract_db['number'],
                $contract_db['cost'],
                $contract_db['group'],
                $contract_db['student'],
                $contract_db['customer']
            );
        }
        return $contracts;
    }

    public static function getAll() {
        $contracts_db = self::findManySafe('SELECT * FROM contract');
        if ($contracts_db === NULL) {
            return "Договора не найдены";
        }
        if ($contracts_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        $contracts = [];
        foreach ($contracts_db as $contract_db) {
            $contracts[] = new Contract(
                $contract_db['id'],
                $contract_db['number'],
                $contract_db['cost'],
                $contract_db['group'],
                $contract_db['student'],
                $contract_db['customer']
            );
        }
        return $contracts;
    }

    public static function addContract(string $number, float $cost, int $group, int $student, int $customer) {
        // #
    }

    public static function printFields() {
        return array(
            "Номер",
            "Стоимость",
            "Группа",
            "Курс",
            "Обучающийся",
            "Заказчик"
        );
    }

    public function printFieldValues() {
        $group = Group::getById($this->groupId);
        $course = Course::getById($group->courseId);
        $student = Student::getById($this->studentId);
        $customer = Customer::getById($this->customerId);
        return array(
            $this->number,
            $this->cost,
            $group->name,
            $course->name,
            $student->nick,
            $customer->nick,
        );
    }
}
?>