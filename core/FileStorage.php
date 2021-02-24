<?php

namespace app\core;
use app\core\Application;

class FileStorage {
	public string $uploadDir;
	public function __construct() {
		if (getenv("FILESTORAGE_DIR")) {
			$this->uploadDir = getenv("FILESTORAGE_DIR");
		} else {
			$this->uploadDir = "uploads";
		}
	}
	public function put(string $folderName, string $fileName) {
		$file = Application::$app->request->input($fileName);
		$rootDir = Application::$app->rootDir;
		if (!$file) {
			return false;
		}

		$fileExt = $file['ext'];
		$uploadName = uniqid('', true) . "." . $fileExt;
		$uploadDir = $rootDir . "/public/$this->uploadDir/" . $folderName;
		$uploadPath = $uploadDir . "/" . $uploadName;
		$tempPath = $file['tmp_name'];
		if (!is_dir($uploadDir)) {
			mkdir($uploadDir, $mode = 0777, $recursive = true);
		}
		if (!move_uploaded_file($tempPath, $uploadPath)) {
			return false;
		}
		return $uploadName;
	}
}