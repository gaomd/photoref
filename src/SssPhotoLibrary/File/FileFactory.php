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
	 * @return \SssPhotoLibrary\File\FileInterface
	 */
	public function open($path)
	{
		$fileClass = get_class($this->file);

		/** @var \SssPhotoLibrary\File\FileInterface $file */
		$file = new $fileClass;
		$file->open($path);

		return $file;
	}
}
