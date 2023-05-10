<?php include "project/templates/left.php";
use Project\Models\User;

?>
<div class="content">
    <h1>Профиль</h1>
    <form action="change_main.php" method="post" class="profile-form">
        <fieldset>
            <legend>Основные данные</legend>
            <?php
            foreach ($user->printFields() as $fieldName => $fieldArr) {
                $field = $fieldArr[0];
                $value = $fieldArr[1];
                echo "<div class='field-item'>";
                echo "<span class='field-name'>$field:</span>";
                if (
                    strpos($value, ".jpeg") ||
                    strpos($value, ".jpg") ||
                    strpos($value, ".png") ||
                    strpos($value, ".gif")
                ) {
                    echo "<div class='field-value'>";
                    echo "<img src='$value' width='150' height='150' alt='$value'>";
                    echo "<input type='file' name='file' class='mb-10'>";
                    echo "<div class='block-centered'>";
                    echo "<button type='submit' class='btn-yellow'>Изменить</button>";
                    echo "<button type='submit' class='btn-red'>Удалить</button>";
                    echo "</div>";
                    echo "</div>";
                } else {
                    echo "<span class='field-value'>$value</span>";
                }
                echo "</div>";
            } ?>
        </fieldset>
    </form>
    <form action="change_main.php" method="post" class="profile-form">
        <fieldset>
            <legend>Изменение пароля</legend>
            <div class='field-item'>
                <label for="old-password" class="field-name">Старый пароль:</label>
                <input type="password" name="old-pwd" required class="input-field">
            </div>
            <div class='field-item'>
                <label for="new-password" class="field-name">Новый пароль:</label>
                <input type="password" name="new-pwd" required class="input-field">
            </div>
            <div class='field-item'>
                <label for="confirm-password" class="field-name">Подтвердите новый пароль:</label>
                <input type="password" name="confirm-pwd" required class="input-field">
            </div>

            <div class="block-centered mb-20">
                <button type="submit" class="btn-green">Сохранить</button>
            </div>
        </fieldset>
    </form>
</div>