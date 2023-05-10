<?php
namespace Project\Models;

include "project/templates/left.php";
$CATALOG = "/chats";

function role($user) {
    return $user->role;
}
?>

<div class="content">
    <h1>Чаты</h1>

    <form action="<?= $CATALOG ?>/search" method="post" class="flex mb-20">
        <input type="text" name="text" class="input-field" >
        <input type="submit" value="Поиск" class="btn-green">
    </form>

    <?php if (role($user) === 'Менеджер') { ?>
        <div class="block-centered m-10">
            <a href="<?= $CATALOG ?>/add" class="btn-green">Создать новый чат</a>
        </div>
    <?php } ?>

    <div class="chats">
        <?php for ($i = 0; $i < count($chats); $i++) {
            $chat = $chats[$i];
            $message = Message::getById($chat->latest);
            $sender = User::getById($message->sender);
            ?>
            <a href="<?= "$CATALOG/$chat->id" ?>">
                <div class="chat-item">
                    <div class="chat-image">
                        <img src="<?= $sender->avatar ?>" class="avatar">
                    </div>
                    <div class="chat-text">
                        <div class="chat-title">
                            <span class="bold">
                                <?= $chat->name ?>
                            </span>
                            <span>
                                <?= $message->time ?>
                            </span>
                        </div>
                        <div class="chat-message">
                            <span class="gray"> <?= $sender->nick ?>: </span>
                            <?= $message->text ?>
                        </div>
                    </div>
                </div>
            </a>
            <?php if ($i != count($chats) - 1) { ?>
                <hr>
            <?php } ?>
        <?php } ?>
    </div>
</div>