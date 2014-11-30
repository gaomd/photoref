<?php namespace SssPhotoLibrary\CloudStorage;

interface CloudStorageInterface {

	/**
	 * @param $uri
	 * @param $content
	 * @return boolean
	 */
	public function upload($uri, $content);

	/**
	 * @param $id
	 * @return string
	 */
	public function download($id);

	/**
	 * @param $id
	 * @return boolean
	 */
	public function delete($id);

}
