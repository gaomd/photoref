<?php namespace SssPhotoLibrary\Photo;

use SssPhotoLibrary\File\FileInterface;

class Photo implements PhotoInterface {

	/**
	 * @var \Imagick
	 */
	protected $image;

	/**
	 * @var array
	 */
	protected $metadata;

	/**
	 * @param \SssPhotoLibrary\File\FileInterface $file
	 * @return $this
	 * @throws \Exception
	 */
	public function openFile(FileInterface $file)
	{
		$this->image = $imagick = new \Imagick();
		if ( ! $imagick->readImageBlob($file->content()))
		{
			throw new \InvalidArgumentException('Unable to recognize image file format.');
		}
	}

	/**
	 * @return array
	 */
	public function getMetadata()
	{
		$metadata = json_decode($this->image->getImageProperty('comment'));

		return is_array($metadata) ? $metadata : [];
	}

	/**
	 * @param array $metadata
	 * @return $this
	 * @throws \Exception
	 */
	public function setMetadata(array $metadata)
	{
		$success = $this->image->commentImage(json_encode($metadata));

		if ( ! $success)
		{
			throw new \Exception('Unable to set metadata.');
		}

		return $this;
	}

	/**
	 * @param $maxWidth
	 * @param $maxHeight
	 * @return $this
	 */
	public function resize($maxWidth, $maxHeight)
	{
		$this->image->resizeImage($maxWidth, $maxHeight, \Imagick::FILTER_LANCZOS, 1, true);

		return $this;
	}

	/**
	 * @param \SssPhotoLibrary\File\FileInterface $file
	 * @return int the number of bytes written, or null on error.
	 */
	public function saveToFile(FileInterface $file)
	{
		$file->save($this->blob());
	}

	/**
	 * @return string
	 */
	public function blob()
	{
		$this->image->setImageFormat('jpeg');

		return $this->image->getImageBlob();
	}

}
