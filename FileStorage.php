<?php

namespace alvin\phpmvc;

class FileStorage {
	public function put(string $uploadPath, string $fileName) {
		$file = Application::$app->request->input($fileName);
		if ($uploadPath[-1] == '/') {
			$uploadPath = substr_replace($uploadPath, "", -1);
		}
		if (!$file) {
			return false;
		}

		$fileExt = $file['ext'];
		$uploadName = bin2hex(random_bytes(10)) . "." . $fileExt;
		$uploadPathWithFilename = $uploadPath . "/" . $uploadName;
		$tempPath = $file['tmp_name'];

		echo $uploadPathWithFilename;

		if (!is_dir($uploadPath)) {
			mkdir($uploadPath, 0777, true);
		}

		if (!move_uploaded_file($tempPath, $uploadPathWithFilename)) {
			return false;
		}
		return $uploadName;
	}
}