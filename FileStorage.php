<?php

namespace alvin\phpmvc;

/**
 * File storage class
 */
class FileStorage {

	/**
	 * Put a file.
	 *
	 * check if specified path exists and puts the file there with unique filename
	 *
	 * @param string $uploadPath The path of the file
	 * @param string $fileName The name of the file
	 * @return string The filename
	 */
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