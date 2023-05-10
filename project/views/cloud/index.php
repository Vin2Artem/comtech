<?php
namespace Project\Models;

include "project/templates/left.php";
$CATALOG = "/cloud"; ?>

<div class="content">
    <h1>Облако</h1>

    <form action="<?= $CATALOG ?>/add" method="post" enctype="multipart/form-data" id="mainForm" class="centered mb-20">
        <input type="file" name="file">
        <input type="submit" value="Загрузить файл" class="btn-green">
        <div id="errBlock">
        </div>
    </form>
    <div class="contracts">
        <?php if (count($files) === 0) {
            echo "Пока нет загруженных файлов";
        } else { ?>
            <table>
                <thead>
                    <th>Дата загрузки</th>
                    <th>Файл</th>
                    <th>Действия</th>
                </thead>
                <tbody>
                    <?php for ($i = 0; $i < count($files); $i++) {
                        $file = $files[$i]
                            ?>
                        <tr>
                            <td>
                                <?= $file->date ?>
                            </td>
                            <td>
                                <?= "<a href='$CATALOG/download/$file->id'>$file->filename</a>" ?>
                            </td>
                            <td>
                                <?= "<a href='$CATALOG/delete/$file->id'>Удалить</a>" ?>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } ?>
    </div>
</div>

<script src="/project/webroot/scripts/main.js"></script>