<?php namespace SssPhotoLibrary\Console;

use SssPhotoLibrary\CloudStorage\S3CloudStorage;
use SssPhotoLibrary\Console\Command\PushCommand;
use SssPhotoLibrary\File\File;
use SssPhotoLibrary\File\FileFactory;
use SssPhotoLibrary\Photo\Photo;

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
		$file = new File();
		$fileFactory = new FileFactory($file);
		$photo = new Photo();
		$s3CloudStorage = new S3CloudStorage();

		return new PushCommand($fileFactory, $photo, $s3CloudStorage);
	}

}
