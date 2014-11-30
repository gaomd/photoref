<?php namespace SssPhotoLibrary\File;

interface FileInterface {

	/**
	 * @param $path
	 * @param string $mode
	 * @param bool $checkExists
	 * @return $this
	 * @throws \InvalidArgumentException
	 */
	public function open($path, $mode = 'r', $checkExists = true);

	/**
	 * @param $content
	 * @return int the number of bytes written, or null on error.
	 */
	public function save($content);

	/**
	 * @return string
	 */
	public function content();

	/**
	 * @return string
	 */
	public function sha1();
}
