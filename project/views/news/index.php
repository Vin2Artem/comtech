<?php include "project/templates/left.php";
$CATALOG = "/news";
?>

<div class="content">
    <h1>Новости</h1>

    <form action="<?= $CATALOG ?>/search" method="post" class="flex">
        <input type="text" name="text" class="input-field" >
        <input type="submit" value="Поиск" class="btn-green">
    </form>

    <?php

    function role($user) {
        return $user->role;
    }

    if (role($user) === "Менеджер") {
        echo "<div class='block-centered m-10'><a href='$CATALOG/add' class='btn-green'>Добавить новость</a></div>";
    }

    for ($i = 0; $i < count($news); $i++) {
        $new = $news[$i];
        echo '<div class="news-item">';
        echo '<h2 class="news-title">' . $new->title . '</h2>';
        echo '<div class="news-description">' . $new->description . '</div>';
        echo '<div class="news-info">' . $new->date . '</div>';
        echo '</div>';

        if (role($user) === "Менеджер") {
            echo "<div class='block-centered m-10'><a href='$CATALOG/edit/{$new->id}' class='btn-yellow'>Редактировать</a>";
            echo "<a href='$CATALOG/delete/{$new->id}' class='btn-red'>Удалить</a></div>";
            //print_r($new->groupIds);
        }

        if ($i != count($news) - 1) {
            echo "<hr>";
        }
    } ?>
</div>