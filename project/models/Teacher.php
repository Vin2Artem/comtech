<?php
	namespace Project\Models;
	use Project\Components\Helper;
	
	class Teacher extends User {
        use UserInit;

        public function editLesson(string $topic, string $desc, $file) {

        }

		public function getFile(string $filename) {
			// #
		}

		private function attachFile($file) {
			// # return Helper::uploadFile($file, $this);
		}

		private function detachFile(int $id) {
			// #
		}
	}
?>