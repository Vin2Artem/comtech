<?php
namespace Project\Models;

use \Core\Model;

class Chat extends Model
{
    public $id;
    public $name;
    public $latest;

    public function __construct(int $id, string $name, $latest)
    {
        $this->id = $id;
        $this->name = $name;
        $this->latest = $latest;
    }

    public static function getById(int $id)
    {
        $chat_db = self::findOneSafe('SELECT * FROM chat WHERE id = ?', 'i', [$id]);
        if ($chat_db === NULL) {
            return "Чат с идентификатором $id не найден";
        }
        if ($chat_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }

        return new Chat(
            $chat_db['id'],
            $chat_db['name'],
            $chat_db['latest']
        );
    }

    public static function getAllByUser(int $userId)
    {
        $chats_db = self::findManySafe('SELECT c.id, c.name, c.latest FROM user_chats uc JOIN chat c ON uc.chat = c.id JOIN msg m ON c.latest = m.id WHERE user = ? ORDER BY time DESC', 'i', [$userId]);
        if ($chats_db === NULL) {
            return "Чатов для пользователя с идентификатором $userId не найдено";
        }
        if ($chats_db === false){
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        $chats = [];
        foreach ($chats_db as $chat_db) {
            $chats[] = new Chat(
                $chat_db['id'],
                $chat_db['name'],
                $chat_db['latest']
            );
        }
        return $chats;
    }

    public function isAvailableForUser(int $userId)
    {
        $chat_db = self::findOneSafe('SELECT * FROM user_chats uc JOIN chat c ON uc.chat = c.id WHERE user = ? and c.id = ?', 'ii', [$userId, $this->id]);
        if ($chat_db === NULL) {
            return false;
        }
        if ($chat_db === false){
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        return true;
    }

    public function getMessages() {
        return Message::getAllByChat($this->id);
    }

    public function sendMessage(User $user, $text, $file, $msg) {
        return Message::addMessage($this->id, $user->id, $text, $file, $msg);
    }
}
?>