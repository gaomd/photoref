<?php namespace SssPhotoLibrary\File;

class FileFactory {

	/**
	 * @var \SssPhotoLibrary\File\FileInterface
	 */
	private $file;

	public function __construct(FileInterface $file)
	{
		$this->file = $file;
	}

	/**
	 * @param $path
	 * @param string $mode
	 * @param bool $checkExists
	 * @return \SssPhotoLibrary\File\FileInterface
	 */
	public function open($path, $mode = 'r', $checkExists = true)
	{
		$fileClass = get_class($this->file);

		/** @var \SssPhotoLibrary\File\FileInterface $file */
		$file = new $fileClass;
		$file->open($path, $mode, $checkExists);

		return $file;
	}
}
