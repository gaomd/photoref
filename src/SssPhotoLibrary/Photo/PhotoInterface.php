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
	 * @return array
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
	 * @param $text
	 * @return $this
	 */
	public function stampQrCode($text);

	/**
	 * @return string
	 */
	public function blob();

	//public function saveTo($path);

	/**
	 * @param \SssPhotoLibrary\File\FileInterface $file
	 * @return int the number of bytes written, or null on error.
	 */
	public function saveToFile(FileInterface $file);
}
