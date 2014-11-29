<?php namespace SssPhotoLibrary\Photo;

use SssPhotoLibrary\File\FileInterface;

interface PhotoInterface {

	/**
	 * @param \SssPhotoLibrary\File\FileInterface $file
	 * @return $this
	 * @throws \Exception
	 */
	public function openFile(FileInterface $file);

	/**
	 * @return array|null
	 */
	public function getMetadata();

	/**
	 * @param array $metadata
	 * @return $this
	 * @throws \Exception
	 */
	public function setMetadata(array $metadata);

	/**
	 * @param $maxWidth
	 * @param $maxHeight
	 * @return $this
	 */
	public function resize($maxWidth, $maxHeight);

	/**
	 * @return string
	 */
	public function toString();

	/**
	 * @param \SssPhotoLibrary\File\FileInterface $file
	 * @return int the number of bytes written, or null on error.
	 */
	public function saveFile(FileInterface $file);
}
