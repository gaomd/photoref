<?php namespace SssPhotoLibrary\File;

interface FileInterface {

	/**
	 * @param $path
	 * @param string $mode
	 * @param bool $checkExists
	 * @return $this
	 */
	public function open($path, $mode = 'r', $checkExists = false);

	/**
	 * @param $offset
	 * @return $this
	 */
	public function seekTo($offset);

	/**
	 * @param $content
	 * @return int the number of bytes written, or null on error.
	 */
	public function write($content);

	public function toString();

	public function sha1();
}
