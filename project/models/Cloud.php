<?php
namespace Project\Models;

use \Core\Model;

class Cloud extends Model
{
    public $id;
    public $userId;
    public $filename;
    public $date;

    public function __construct(int $id, int $user, string $filename, $date) {
        $this->id = $id;
        $this->userId = $user;
        $this->filename = $filename;
        $this->date = $date;
    }

    public static function getFilesByUser(int $userId) {
        $files_db = self::findManySafe('SELECT * FROM cloud WHERE user = ?', 'i', [$userId]);
        if ($files_db === NULL) {
            return "Файлов для пользователя с идентификатором $userId не найдено";
        }
        if ($files_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        $files = [];
        foreach ($files_db as $file_db) {
            $files[] = new Cloud(
                $file_db['id'],
                $file_db['user'],
                $file_db['filename'],
                $file_db['date']
            );
        }
        return $files;
    }

    public static function getFileById(int $fileId) {
        $file_db = self::findOneSafe('SELECT * FROM cloud WHERE id = ? ', 'i', [$fileId]);
        if ($file_db === NULL) {
            return "Файл с идентификатором $fileId не найдено";
        }
        if ($file_db === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        $file = new Cloud(
            $file_db['id'],
            $file_db['user'],
            $file_db['filename'],
            $file_db['date']
        );
        return $file;
    }

    public static function uploadFile($userId, $filename) {
        if (self::querySafe("INSERT INTO cloud (user, filename) VALUES (?, ?)", 'is', [$userId, $filename]) === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        ;
        return self::lastId();
    }

    public static function deleteFile($userId, $fileId) {
        if (self::querySafe("DELETE FROM cloud WHERE user = ? AND id = ?", 'ii', [$userId, $fileId]) === false) {
            return "Произошла ошибка, попробуйте позднее или свяжитесь с нами";
        }
        ;
        return true;
    }
}
?>