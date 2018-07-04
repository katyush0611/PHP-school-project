<?php

class DB {
	private static $conn;
    public function __construct() {}

    public static function getConnection() {
    	if (!self::$conn) {
    		self::$conn = new mysqli('localhost', 'root', '', 'php-project');
    		if (self::$conn->connect_error) {
				die(self::$conn->connect_error);
			}
			return self::$conn;
		} else {
			return self::$conn;
		}
	}

}