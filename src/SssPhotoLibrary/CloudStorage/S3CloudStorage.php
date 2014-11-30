<?php namespace SssPhotoLibrary\CloudStorage;

class S3CloudStorage implements CloudStorageInterface {

	/**
	 * @param $uri
	 * @param $content
	 * @return boolean
	 */
	public function upload($uri, $content)
	{
		global $config;

		$s3 = new \S3(
			$config['cloud_storage']['amazon_s3']['access_key'],
			$config['cloud_storage']['amazon_s3']['secret_key']
		);
		$bucket = $config['cloud_storage']['amazon_s3']['bucket'];

		return $s3->putObject($content, $bucket, $uri, \S3::ACL_PRIVATE);
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
