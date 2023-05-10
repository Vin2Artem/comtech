<?php
namespace Project\Models;

use \Core\Model;

class Payment extends Model
{
    public $id;
    public $contract;
    public $date;
    public $value;

    public function __construct(int $id, int $contract, $date, float $value) {
        $this->id = $id;
        $this->contract = $contract;
        $this->date = $date;
        $this->value = $value;
    }

    public static function getAllByContract(int $contractId) {
        $payments_db = self::findManySafe('SELECT * FROM `payment` WHERE contract = ?', 'i', [$contractId]);
        if ($payments_db === NULL) {
            return "Оплат для пользователя с идентификатором $contractId не найдено";
        }
        if ($payments_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        $payments = [];
        foreach ($payments_db as $payment_db) {
            $payments[] = new Payment(
                $payment_db['id'],
                $payment_db['contract'],
                $payment_db['date'],
                $payment_db['value']
            );
        }
        return $payments;
    }

    public static function addPayment(int $id, int $contract, $date, float $value) {
        // #
    }
}
?>