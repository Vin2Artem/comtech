<?php
namespace Project\Models;

include "project/templates/left.php";
$CATALOG = "/admin";
?>

<div class="content">
    <h1>Администрирование</h1>

    <div class="admin-panel">
        <a href='<?= "$CATALOG/users" ?>' class="btn-green">Пользователи</a>
        <a href='<?= "$CATALOG/contracts" ?>' class="btn-green">Договора</a>
        <a href='<?= "$CATALOG/courses" ?>' class="btn-green">Курсы</a>
        <a href='<?= "$CATALOG/groups" ?>' class="btn-green">Группы</a>
    </div>
</div>