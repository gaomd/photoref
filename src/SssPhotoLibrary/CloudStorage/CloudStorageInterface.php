<?php namespace SssPhotoLibrary\CloudStorage;

interface CloudStorageInterface {

	/**
	 * @param $id
	 * @param $content
	 * @return boolean
	 */
	public function upload($id, $content);

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
