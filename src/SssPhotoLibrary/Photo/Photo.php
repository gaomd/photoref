<?php namespace SssPhotoLibrary\Photo;

use SssPhotoLibrary\File\FileInterface;

class Photo implements PhotoInterface {

	/**
	 * @param \SssPhotoLibrary\File\FileInterface $file
	 * @return $this
	 * @throws \Exception
	 */
	public function openFile(FileInterface $file)
	{
		// TODO: Implement read() method.
	}

	/**
	 * @return array|null
	 */
	public function getMetadata()
	{
		// TODO: Implement getMetadata() method.
	}

	/**
	 * @param array $metadata
	 * @return $this
	 * @throws \Exception
	 */
	public function setMetadata(array $metadata)
	{
		// TODO: Implement setMetadata() method.
	}

	/**
	 * @param $maxWidth
	 * @param $maxHeight
	 * @return $this
	 */
	public function resize($maxWidth, $maxHeight)
	{
		// TODO: Implement resize() method.
	}

	/**
	 * @return string
	 */
	public function toString()
	{
		// TODO: Implement toString() method.
	}

	/**
	 * @param \SssPhotoLibrary\File\FileInterface $file
	 * @return int the number of bytes written, or null on error.
	 */
	public function saveFile(FileInterface $file)
	{
		// TODO: Implement saveFile() method.
	}
}
