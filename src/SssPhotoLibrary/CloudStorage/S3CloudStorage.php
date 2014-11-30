<?php namespace SssPhotoLibrary\CloudStorage;

class S3CloudStorage implements CloudStorageInterface {

	/**
	 * @param $id
	 * @param $content
	 * @return boolean
	 */
	public function upload($id, $content)
	{
		return true;
	}

	/**
	 * @param $id
	 * @return string
	 */
	public function download($id)
	{
		// TODO: Implement download() method.
	}

	/**
	 * @param $id
	 * @return boolean
	 */
	public function delete($id)
	{
		// TODO: Implement delete() method.
	}
}
