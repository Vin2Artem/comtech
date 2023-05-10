<?php
namespace Project\Models;

use \Core\Model;

class Message extends Model
{
    public $id;
    public $chat;
    public $sender;
    public $text;
    public $file;
    public $time;
    public $msgId;

    public function __construct(int $id, int $chat, int $sender, string $text, $file, $time, $msg) {
        $this->id = $id;
        $this->chat = $chat;
        $this->sender = $sender;
        $this->text = $text;
        $this->file = $file;
        $this->time = $time;
        $this->msgId = $msg;
    }

    public static function getById(int $id) {
        $msg_db = self::findOneSafe('SELECT * FROM msg WHERE id = ?', 'i', [$id]);
        if ($msg_db === NULL) {
            return "Сообщение с идентификатором $id не найдено";
        }
        if ($msg_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        return new Message(
            $msg_db['id'],
            $msg_db['chat'],
            $msg_db['sender'],
            $msg_db['text'],
            $msg_db['file'],
            $msg_db['time'],
            $msg_db['msg']
        );
    }

    public static function getAllByChat(int $chatId) {
        $msgs_db = self::findManySafe('SELECT * FROM msg WHERE chat = ? ORDER BY time ASC', 'i', [$chatId]);
        $msgs = [];
        if ($msgs_db === NULL) {
            return $msgs;
        }
        if ($msgs_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        $msgs = [];
        foreach ($msgs_db as $msg_db) {
            $msgs[] = new Message(
                $msg_db['id'],
                $msg_db['chat'],
                $msg_db['sender'],
                $msg_db['text'],
                $msg_db['file'],
                $msg_db['time'],
                $msg_db['msg']
            );
        }
        return $msgs;
    }

    public static function addMessage($chatId, $sender, $text, $file, $msg) {
        if (self::querySafe(
            'INSERT INTO msg(chat, sender, text, file, msg) VALUES (?, ?, ?, ?, ?)',
            'iissi',
            [$chatId, $sender, $text, $file, $msg]
        ) === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        };
        return true;
    }

    public function editMessage(int $msgId, $text, $file, $msg) {
        // #
    }
}
?>