<?php
namespace Project\Models;

include "project/templates/left.php";
$CATALOG = "/chats";

function role($user) {
    return $user->role;
}
?>

<style>
    .content {
        overflow: unset;
    }

    h1 {
        margin: -10px 0;
        padding: 10px;
        position: sticky;
        top: 110px;
        background: #F8F9FA;
    }
</style>

<div class="content">
    <h1>Чат "
        <?= $_SESSION['chat']->name ?>"
    </h1>

    <div class="msgs">
        <?php for ($h = 0; $h < 20; $h++) {
            for ($i = 0; $i < count($msgs); $i++) {
                $msg = $msgs[$i];
                $sender = User::getById($msg->sender);
                ?>
                <div class="chat-item mb-20">
                    <div class="chat-image">
                        <img src="<?= $sender->avatar ?>" class="avatar">
                    </div>
                    <div class="chat-text">
                        <div class="chat-title">
                            <span class="bold <?= $sender->role === "Менеджер" ? "underline" : "" ?>">
                                <?= $sender->nick ?>
                            </span>
                            <span>
                                <?= $msg->time ?>
                            </span>
                        </div>
                        <div class="msg-message">
                            <?= $msg->text ?>
                        </div>
                    </div>
                </div>
            <?php }
        } ?>
    </div>
    <div class="send">
        <form action="" method="post" id="mainForm" class="flex">
            <input type="text" name="text" class="input-field">
            <input type="submit" class="btn-green">
        </form>
    </div>

    <div id="errBlock">
    </div>
</div>

<script src="/project/webroot/scripts/main.js"></script>

<script>
    // # вывод с первого непрочитанного сообщения и подгрузка старых сообщений по мере прокрутки
    window.scrollTo(0, document.body.scrollHeight);
</script>