<?php
namespace Project\Models;

use QRcode;

include "project/templates/left.php";
include "project\components\phpqrcode\qrlib.php";
?>

<div class="content">
    <h1>График оплат</h1>

    <?php for ($i = 0; $i < count($contracts); $i++) {
        $contract = $contracts[$i]
            ?>
        <div class="contract">
            <div class="contract_head">
                <h2>Договор №
                    <?= $contract->number ?>
                </h2>
                <div class='field-item'>
                    <span class='field-name'>Обучающийся:</span>
                    <span class='field-value'>
                        <?= User::getById($contract->studentId)->nick ?>
                    </span>
                </div>
                <?php
                $group = Group::getById($contract->groupId);
                $course = Course::getById($group->courseId);
                $payments = Payment::getAllByContract($contract->id);
                $payed = 0;
                $payForStage = round($contract->cost / $course->stages, 2);
                foreach ($payments as $payment) {
                    $payed += $payment->value;
                }
                ?>
                <div class='field-item'>
                    <span class='field-name'>Группа:</span>
                    <span class='field-value'>
                        <?= $group->name ?>
                    </span>
                </div>
                <div class='field-item'>
                    <span class='field-name'>Курс:</span>
                    <span class='field-value'>
                        <?= $course->name ?>
                    </span>
                </div>
                <div class='field-item'>
                    <span class='field-name'> Оплачено: </span>
                    <span class='field-value'>
                        <?= "{$payed}₽ / {$contract->cost}₽" ?>
                    </span>
                </div>
            </div>
            <table>
                <thead>
                    <th>Этап №</th>
                    <th>Сумма</th>
                    <th>Оплачено</th>
                    <th>Оплатить</th>
                </thead>
                <tbody>
                    <?php for ($j = 1; $j <= $course->stages; $j++) { ?>
                        <tr>
                            <td> Этап
                                <?= $j ?>
                            </td>
                            <td>
                                <?=
                                    $payForStage
                                ?>
                            </td>
                            <td>
                                <?php
                                if ($payed >= $payForStage) {
                                    $payedForStage = $payForStage;
                                    echo $payedForStage;
                                } elseif ($payed > 0) {
                                    $payedForStage = $payed;
                                    echo $payedForStage;
                                } else {
                                    $payedForStage = 0;
                                }
                                $payed -= $payForStage;
                                ?>
                            </td>
                            <td>
                                <?php
                                $left = $payForStage - $payedForStage;
                                if ($left > 0) {
                                    echo $left;
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <div class="qr">
                <span class="qr-desc">
                    Отсканируйте следующий QR-код для оплаты по договору:
                </span>
                <?php
                $qrText = "";
                $qrText .= "ST00012";
                $qrText .= "|Name=УФК по Саратовской области (БИТИ НИЯУ МИФИ, л/с 30606Щ12860)";
                $qrText .= "|PersonalAcc=03214643000000016000";
                $qrText .= "|BankName=ОТДЕЛЕНИЕ САРАТОВ БАНКА РОССИИ//УФК по Саратовской области г Саратов";
                $qrText .= "|BIC=016311121";
                $qrText .= "|CorrespAcc=40102810845370000052";
                $qrText .= "|Sum=31329";
                $qrText .= "|Purpose=НДС не облагается."; // #
                $qrText .= "|PayeeINN=7724068140";
                $qrText .= "|KPP=643943001";
                $qrText .= "|CBC=00000000000000000130";
                $qrText .= "|OKTMO=63607101";
                $qrText .= "|lastName=Виноградов";
                $qrText .= "|firstName=Артем";
                $qrText .= "|middleName=Алексеевич";
                $qrText .= "|contract=ОБ/03/19";
                $qrText .= "|persAcc=00000000323";
                $qrText .= "|childFio=Виноградов Артем Алексеевич";
                QRcode::png($qrText, 'project/webroot/qrs/filename.png');
                echo "<img src='/project/webroot/qrs/filename.png' class='qr-img'>";
                ?>
            </div>
        </div>
        <?php if ($i != count($contracts) - 1) { ?>
            <hr>
        <?php }
    } ?>
</div>

<style>
    .contract {
        max-width: 500px;
        margin: 0 auto;
    }

    h2 {
        text-align: center;
        padding-bottom: 20px;
    }

    hr {
        margin: 20px 0;
    }

    table {
        margin: 0 auto;
    }

    .qr {
        margin-top: 10px;
    }

    .qr-desc {
    }

    .qr-img {
        display: block;
        margin: 10px auto 0;
    }
</style>