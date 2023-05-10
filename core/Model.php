<?php
	namespace Core;
	use Exception;
	use Project\Components\Helper;
	
	abstract class Model
	{
		private static $link;

		private static function connect() {
			if (!self::$link) {
				self::$link = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
				self::$link->query("SET NAMES 'utf8'");
			}
		}

		protected static function lastId() {
			return self::$link->insert_id;
		}

		protected static function querySafe(string $query, string $types, array $params) {
			try {
				self::connect();
				$stmt = self::$link->prepare($query);
				if($stmt === false) {
					throw new Exception;
				}
				if ($stmt->bind_param($types, ...$params) === false) {
					throw new Exception;
				}
				if($stmt->execute() === false) {
					throw new Exception;
				}
			} catch (Exception $e) {
				return Helper::log(self::$link->error);
			}
		}

		protected static function findOneSafe(string $query, string $types, array $params) {
			try {
				self::connect();
				$stmt = self::$link->prepare($query);
				if($stmt === false) {
					throw new Exception;
				}
				if ($stmt->bind_param($types, ...$params) === false) {
					throw new Exception;
				}
				if($stmt->execute() === false) {
					throw new Exception;
				}
				$result = $stmt->get_result();
				if ($result === false && self::$link->errno !== 0) {
					throw new Exception;
				}
				$assoc = $result->fetch_assoc();
				if ($assoc === false) {
					throw new Exception;
				}
				return $assoc;
			} catch (Exception $e) {
				return Helper::log(self::$link->error);
			}
		}

		protected static function findManySafe(string $query, string $types = NULL, array $params = NULL) {
			try {
				self::connect();
				$stmt = self::$link->prepare($query);
				if($stmt === false) {
					throw new Exception;
				}
				if (isset($types) && isset($params)) {
					if($stmt->bind_param($types, ...$params) === false) {
						throw new Exception;
					}
				}
				if($stmt->execute() === false) {
					throw new Exception;
				}
				$result = $stmt->get_result();
				if ($result === false && self::$link->errno !== 0) {
					throw new Exception;
				}
				for ($data = []; $row = $result->fetch_assoc(); $data[] = $row);
				return $data;
			} catch (Exception $e) {
				return Helper::log(self::$link->error);
			}
		}
	}
