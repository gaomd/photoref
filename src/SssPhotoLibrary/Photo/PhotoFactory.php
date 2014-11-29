<?php namespace SssPhotoLibrary\Photo;

use SssPhotoLibrary\File\FileInterface;

class PhotoFactory {

	/**
	 * @var \SssPhotoLibrary\Photo\PhotoInterface
	 */
	private $photo;

	public function __construct(PhotoInterface $photo)
	{
		$this->photo = $photo;
	}

	/**
	 * @param \SssPhotoLibrary\File\FileInterface $file
	 * @return \SssPhotoLibrary\Photo\PhotoInterface
	 */
	public function openFile(FileInterface $file)
	{
		$photoClass = get_class($this->photo);

		/** @var \SssPhotoLibrary\Photo\PhotoInterface $photo */
		$photo = new $photoClass;
		$photo->openFile($file);

		return $photo;
	}
}
