<?php
namespace Project\Models;

use Project\Components\Helper;

class Student extends User
{
        use UserInit;

        public function uploadFile(array $file) {
                $fname = $file['name'];
                if ($fname === "") {
                        return "Файл не загружен";
                }
                $fileId = Cloud::uploadFile($this->id, $fname);
                if (gettype($fileId) === "string") {
                        return $fileId;
                }
                $err = Helper::uploadFile($file, $this, $fileId, false);
                if (gettype($err) === "string") {
                        Cloud::deleteFile($this->id, $fileId);
                        return $err;
                }
                return true;
        }

        public function getFile($fileId) {
                if (intval($fileId) <= 0) {
                        return false;
                }
                $file = Cloud::getFileById($fileId);
                $filename = strval($fileId) . "_" . $file->filename;
                return Helper::getFile($this->id, $filename);
        }

        public function getFiles() {
                return Cloud::getFilesByUser($this->id);
        }

        public function deleteFile($fileId) {
                if (intval($fileId) <= 0) {
                        return false;
                }
                $file = Cloud::getFileById($fileId);
                $filename = strval($fileId) . "_" . $file->filename;
                $err = Helper::deleteFile($this->id, $filename);
                if (gettype($err) === "string") {
                        return $err;
                }
                return Cloud::deleteFile($this->id, $fileId);
        }
}
?>