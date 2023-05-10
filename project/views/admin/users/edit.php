<?php include "project/templates/left.php";
use Project\Models\User;

?>
<div class="content">
    <h1>Профиль</h1>
    <form action="" method="post" class="profile-form">
        <fieldset>
            <legend>Основные данные</legend>
            <?php

            foreach ($userEdit->printFields() as $fieldName => $fieldArr) {
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
                    echo "<input type='file' name='avatar' class='mb-10'>";
                    echo "<div class='block-centered'>";
                    echo "<button type='submit' class='btn-yellow'>Изменить</button>";
                    echo "<button type='submit' class='btn-red'>Удалить</button>";
                    echo "</div>";
                    echo "</div>";
                } else if ($fieldName == "role") {
                    echo "<select class='select' name='$fieldName' required>";
                    for ($j = 0; $j < count($roles); $j++) {
                        if ($value == $roles[$j]->value) {
                            echo "<option value='{$roles[$j]->id}' selected>{$roles[$j]->value}</option>";
                        } else {
                            echo "<option value='{$roles[$j]->id}'>{$roles[$j]->value}</option>";
                        }
                    }
                    echo '</select><div class="select-field"></div>';
                } else if ($fieldName == "patronymic") {
                    echo "<input type='text' name='$fieldName' class='input-field' value='$value'>";
                } else {
                    echo "<input type='text' name='$fieldName' required class='input-field' value='$value'>";
                }
                echo "</div>";
            } ?>

            <div class="block-centered mb-20">
                <button type="submit" class="btn-green">Сохранить</button>
            </div>
        </fieldset>
        </form>
</div>

<style>
    .select-field {
  position: relative;
  /*margin-bottom: 20px;*/
}

.select {
  flex: 1;
  -webkit-appearance: none;
  -moz-appearance: none;
  appearance: none;
  width: 100%;
  height: 40px;
  padding: 10px;
  font-size: 16px;
  border: none;
  border-radius: 5px;
  background-color: #fff;
  color: #333;
  box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.select-field::after {
  content: "";
  background-image: url("/project/webroot/images/menu/triangle-down.svg");
  position: absolute;
  top: -7px;
  right: 10px;
  width: 14px;
  height: 14px;
  pointer-events: none;
}

.select:focus + .select-field::after {
  transform: rotate(180deg);
}


</style>