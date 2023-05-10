<?php
namespace Project\Components;

use Project\Models\User;

define("CLOGSDIR", "project/common_logs");

define("LOG_DEBG", "debug");
define("LOG_WARN", "warn");
define("LOG_ERROR", "error");
define("LOG_FATAL", "fatal");

class Helper
{
    private static $ip;

    public static function init() {
        if (!file_exists(CLOGSDIR)) {
            mkdir(CLOGSDIR, 0700, true);
        }
        if (!file_exists(CLOGSDIR . '/' . LOG_DEBG)) {
            mkdir(CLOGSDIR . '/' . LOG_DEBG, 0700, true);
        }
        if (!file_exists(CLOGSDIR . '/' . LOG_WARN)) {
            mkdir(CLOGSDIR . '/' . LOG_WARN, 0700, true);
        }
        if (!file_exists(CLOGSDIR . '/' . LOG_ERROR)) {
            mkdir(CLOGSDIR . '/' . LOG_ERROR, 0700, true);
        }
        if (!file_exists(CLOGSDIR . '/' . LOG_FATAL)) {
            mkdir(CLOGSDIR . '/' . LOG_FATAL, 0700, true);
        }
        self::$ip = self::getIP();
    }

    private static function getIP() {
        $keys = [
            'HTTP_CLIENT_IP',
            'HTTP_X_FORWARDED_FOR',
            'REMOTE_ADDR'
        ];
        foreach ($keys as $key) {
            if (!empty($_SERVER[$key])) {
                $arr = explode(',', $_SERVER[$key]);
                $ip = trim(end($arr));
                if (filter_var($ip, FILTER_VALIDATE_IP)) {
                    return $ip;
                }
            }
        }
    }

    private static function getRef() {
        return isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : "empty";
    }

    public static function log(string $msg, string $level = LOG_ERROR, bool $withParams = false) {
        /*foreach(debug_backtrace() as $value) {
            print_r($value);
            echo "<br>";
        }*/
        $dateTime = date("d.m.Y H:i:s");
        $params = '';
        if ($withParams) {
            if (!empty($_POST)) {
                foreach ($_POST as $key => $value) {
                    $params .= "\nПараметр $key = '$value'";
                }
            } else {
                $params .= "\nПараметры POST-запроса отсутствуют";
            }
        }
        $ip = self::$ip;
        $referer = self::getRef();

        $logMsg = "[$dateTime] $msg
        IP = $ip
        ref = $referer
        method = {$_SERVER['REQUEST_METHOD']}
        uri = {$_SERVER['REQUEST_URI']}$params\n";
        file_put_contents(CLOGSDIR . "/log.txt", "[$level] | $logMsg", FILE_APPEND | LOCK_EX);
        file_put_contents(CLOGSDIR . "/$level/log.txt", $logMsg, FILE_APPEND | LOCK_EX);

        return false; // not change!
    }

    public static function deleteFile(int $userId, string $fname) {
        $filePath = "project/cloud/$userId/$fname";

        if (file_exists($filePath)) {
            if (unlink($filePath)) {
                return true;
            } else {
                return "Не удалось удалить файл: $fname";
            }
        } else {
            return "Файл не найден: $fname";
        }
    }


    public static function getFile(int $userId, string $fname) {
        $fdown = "project/cloud/$userId/$fname";
        if (!file_exists($fdown)) {
            return false;
        }
        $fsize = filesize($fdown);

        if (getenv('HTTP_RANGE') == '') {
            $f = fopen($fdown, 'r');

            header("HTTP/1.1 200 OK");
            header("Connection: close");
            header("Content-Type: application/octet-stream");
            header("Accept-Ranges: bytes");
            header("Content-Disposition: Attachment; filename=" . $fname);
            header("Content-Length: " . $fsize);

            while (!feof($f)) {
                if (connection_aborted()) {
                    fclose($f);
                    break;
                }
                echo fread($f, 10000);
            }
            fclose($f);
        } else {
            preg_match("/bytes=(\d+)-/", getenv('HTTP_RANGE'), $m);
            $csize = $fsize - $m[1];
            $p1 = $fsize - $csize;
            $p2 = $fsize - 1;

            $f = fopen($fdown, 'r');
            fseek($f, $p1);

            header("HTTP/1.1 206 Partial Content");
            header("Connection: close");
            header("Content-Type: application/octet-stream");
            header("Accept-Ranges: bytes");
            header("Content-Disposition: Attachment; filename=" . $fname);
            header("Content-Range: bytes " . $p1 . "-" . $p2 . "/" . $fsize);
            header("Content-Length: " . $csize);

            while (!feof($f)) {
                if (connection_aborted()) {
                    fclose($f);
                    break;
                }
                echo fread($f, 10000);
            }
            fclose($f);
        }
        return true;
    }

    private static function getUploadErrorMessage($errorCode) {
        switch ($errorCode) {
            case UPLOAD_ERR_INI_SIZE:
                return 'Размер загруженного файла превысил максимально допустимый размер, указанный в файле конфигурации'; // php.ini
            case UPLOAD_ERR_FORM_SIZE:
                return 'Размер загруженного файла превысил максимально допустимый размер, указанный в форме загрузки';
            case UPLOAD_ERR_PARTIAL:
                return 'Загружаемый файл был получен только частично';
            case UPLOAD_ERR_NO_FILE:
                return 'Файл не был загружен';
            case UPLOAD_ERR_NO_TMP_DIR:
                return 'Отсутствует временная директория для загрузки файлов';
            case UPLOAD_ERR_CANT_WRITE:
                return 'Ошибка записи файла на диск';
            case UPLOAD_ERR_OK:
                return true; // Загрузка файла прошла успешно
            default:
                return 'Неизвестная ошибка при загрузке файла';
        }
    }


    public static function uploadFile(array $file, User $user, int $fileId, bool $checkFormat) {
        $allowedFormats = [
            'jpg' => ['FF', 'D8'],
            'jpeg' => ['FF', 'D8'],
            'png' => ['89', '50', '4E', '47', '0D', '0A', '1A', '0A'],
            'gif' => ['47', '49', '46', '38', '37', '61'],
        ];

        $maxFileSize = 5 * 1024 * 1024; // 5 МБ

        $fileName = $file['name'];
        $fileSize = $file['size'];
        $fileTempName = $file['tmp_name'];

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        if ($fileSize > $maxFileSize) {
            return "Размер файла превышает максимально допустимый лимит 5 МБ.";
        }

        $err = self::getUploadErrorMessage($file['error']);
        if ($err !== true) {
            return $err;
        }

        if ($checkFormat) {
            if (!isset($allowedFormats[$fileExt])) {
                return "Недопустимый формат файла. Допустимые форматы: jpg, jpeg, gif, png.";
            }

            $fileContents = file_get_contents($fileTempName);
            $fileSignature = substr($fileContents, 0, 8);
            $fileSignature = str_split(bin2hex($fileSignature), 2);

            if (!array_diff($fileSignature, $allowedFormats[$fileExt])) {
                $fileSignatureString = implode('', $fileSignature);
                self::log("Некорректная сигнатура загружаемого файла: $fileSignatureString. UserInfo = [{$user->getUserInfo()}]", LOG_WARN);
                return "Недопустимый формат файла. Допустимые форматы: jpg, jpeg, gif, png.";
            }
        }

        $uploadDir = "project/cloud/{$user->id}/";

        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0700, true);
        }

        $newFileName = strval($fileId) . "_" . $fileName;
        $destination = $uploadDir . $newFileName;

        if (!move_uploaded_file($fileTempName, $destination)) {
            return self::log("Ошибка при загрузке файла на сервер.");
        }

        return true;
    }

}