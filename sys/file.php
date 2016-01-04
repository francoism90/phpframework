<?php
namespace Sys;
use \Exception;
class File {
	protected $file = array();

	public function __construct(string $n) {
		$a = Arr::merge("config/file/$n");
		if ($_FILES[$a['key']]['error'] !== UPLOAD_ERR_OK)
			throw new Exception('Server Error');

		// Validate File
		$this->file = array(
			'target' => $a['target'],
			'size' => $_FILES[$a['key']]['size'],
			'tmp' => $_FILES[$a['key']]['tmp_name']
		);

		if ($this->file['size'] < $a['minfilesize'] || $this->file['maxfilesize'] > $a['maxfilesize'])
			throw new Exception(_('Invalid Filesize'));
	}

	public function move(string $name, bool $force = null) {
		$dest = $this->file['target'] . basename($name);
		if (!$force && file_exists($dest))
			throw new Exception(_('File already exists'));

		if (!move_uploaded_file($this->file['tmp'], $dest))
			throw new Exception(_('Error trying to move file'));
	}

	public function imageType(array $a = array(IMAGETYPE_PNG)) {
		$v = getimagesize($this->file['tmp']);
		return (!in_array($v[2], $a));
	}
}
?>
