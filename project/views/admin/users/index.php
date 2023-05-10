<?php
namespace Project\Models;

include "project/templates/left.php";
$CATALOG = "/admin/users";
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
    <h1>Управление пользователями</h1>

    <form action="<?= $CATALOG ?>/search" method="post" class="flex">
        <input type="text" name="text" class="input-field" >
        <input type="submit" value="Поиск" class="btn-green">
    </form>

    <div class="block-centered m-10">
        <a href="<?= $CATALOG ?>/add" class="btn-green">Добавить пользователя</a>
    </div>
    <div class="users">
        <table>
            <thead>
                <th></th>
                <?php foreach ($user->printFields() as $fieldArr) {
                    echo "<th>$fieldArr[0]</th>";
                } ?>
                <th></th>
            </thead>
            <tbody>
                <?php for ($i = 0; $i < count($users); $i++) {
                    $usr = $users[$i];
                    echo "<tr><td><a href='$CATALOG/edit/{$usr->id}'><img src='\project\webroot\images\admin\pencil-square.svg' alt='Редактировать' class='s-32'></a></td>";
                    foreach ($usr->printFields() as $fieldArr) {
                        $value = $fieldArr[1];
                        if (
                            strpos($value, ".jpg") ||
                            strpos($value, ".png") ||
                            strpos($value, ".gif")
                        ) {
                            echo "<td><img src='$value' alt='$value' class='avatar'></td>";
                        } else {
                            echo "<td>$value</td>";
                        }
                    }
                    echo "<td><a href='$CATALOG/delete/{$usr->id}'><img src='/project/webroot/images/admin/round-delete-forever.svg' alt='Удалить' class='s-32'></a></td></tr>";
                } ?>
            </tbody>
        </table>
    </div>
</div>