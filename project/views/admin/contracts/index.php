<?php
namespace Project\Models;

include "project/templates/left.php";
$CATALOG = "/admin/contracts";
?>
<style>
    /*.users th:first-child {
    display: none;
}
.users td:first-child {
    display: none;
}*/
</style>
<div class="content">
    <h1>Управление договорами</h1>

    <div class="block-centered">
        <a href="<?= $CATALOG ?>/add" class="btn-green mb-20">Добавить договор</a>
    </div>
    <div class="contracts">
        <table>
            <thead>
                <th></th>
                <?php foreach (Contract::printFields() as $field) {
                    echo "<th>$field</th>";
                } ?>
                <th></th>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($contracts); $i++) {
                    $contract = $contracts[$i];
                    echo "<tr><td><a href='$CATALOG/edit/{$contract->id}'><img src='\project\webroot\images\admin\pencil-square.svg' alt='Редактировать' class='s-32'></a></td>";
                    foreach ($contract->printFieldValues() as $value) {
                        echo "<td>$value</td>";
                    }
                    echo "<td><a href='$CATALOG/delete/{$contract->id}'><img src='/project/webroot/images/admin/round-delete-forever.svg' alt='Удалить' class='s-40'></a></td></tr>";
                } ?>
            </tbody>
        </table>
    </div>
</div>