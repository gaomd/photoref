<?php namespace SssPhotoLibrary\File;

interface FileInterface {

	public function open($path);

	public function write($content);

	public function close();

	public function toString();

}
