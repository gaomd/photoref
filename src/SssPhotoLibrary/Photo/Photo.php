<?php namespace SssPhotoLibrary\Photo;

use Endroid\QrCode\QrCode;
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

	/**
	 * @param $text
	 * @return $this
	 */
	public function stampQrCode($text)
	{
		if (strlen($text) !== 40)
		{
			throw new \InvalidArgumentException('QR Code text string length should be exactly 40.');
		}

		$qrCode = new QrCode();

		// Create a 80x80 QR Code image
		// Reference: http://www.qrcode.com/en/about/version.html
		$qrCodeData = $qrCode->setText($text)
		                     ->setErrorCorrection(QrCode::LEVEL_HIGH)
		                     ->setVersion(5)
		                     ->setModuleSize(37)
		                     ->setSize(74)
		                     ->setPadding(3)
		                     ->get();

		$qrCodeImage = new \Imagick();
		$qrCodeImage->readImageBlob($qrCodeData);
		$qrCodeImage->setImageOpacity(0.6);

		// @todo: QR Code should be placed on the top-left, but top-right is going on...
		$success = $this->image->compositeImage($qrCodeImage, \Imagick::COMPOSITE_DEFAULT, 0, 0);

		if ( ! $success)
		{
			throw new \RuntimeException('Unable to add QR Code to the target.');
		}

		return $this;
	}
}
