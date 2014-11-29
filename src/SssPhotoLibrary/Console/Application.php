<?php namespace SssPhotoLibrary\Console;

use SssPhotoLibrary\CloudStorage\S3CloudStorage;
use SssPhotoLibrary\Console\Command\PushCommand;
use SssPhotoLibrary\File\File;
use SssPhotoLibrary\File\FileFactory;
use SssPhotoLibrary\Photo\Photo;
use SssPhotoLibrary\Photo\PhotoFactory;

class Application extends \Symfony\Component\Console\Application {

	public function __construct()
	{
		parent::__construct('S3 Photo Library', 'developing');
	}

	public function getDefaultCommands()
	{
		$defaultCommands = parent::getDefaultCommands();

		$defaultCommands[] = $this->getPushCommand();

		return $defaultCommands;
	}

	public function getPushCommand()
	{
		$fileFactory = new FileFactory(new File());
		$photo = new PhotoFactory(new Photo());
		$s3CloudStorage = new S3CloudStorage();

		return new PushCommand($fileFactory, $photo, $s3CloudStorage);
	}

}
