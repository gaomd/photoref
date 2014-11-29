<?php namespace SssPhotoLibrary\Console\Command;

use SssPhotoLibrary\CloudStorage\CloudStorageInterface;
use SssPhotoLibrary\File\FileFactory;
use SssPhotoLibrary\Photo\PhotoInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PushCommand extends Command {

	/**
	 * @var \SssPhotoLibrary\CloudStorage\CloudStorageInterface
	 */
	private $cloudStorage;

	public function __construct(FileFactory $file, PhotoInterface $photo, CloudStorageInterface $cloudStorage)
	{
		parent::__construct();

		$this->file = $file;
		$this->photo = $photo;
		$this->cloudStorage = $cloudStorage;
	}

	protected function configure()
	{
		$this->setName('push')
		     ->setDescription('Push a photo to the S3')
		     ->addArgument(
			     'file',
			     InputArgument::REQUIRED,
			     'The file to be uploaded'
		     )
		     ->addOption(
			     'output',
			     'O',
			     InputOption::VALUE_REQUIRED,
			     'If unset, the slave photo will saved as .spl.jpg'
		     );
	}

	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$filePath = $input->getArgument('file');
		$outputFilePath = $input->getOption('output');

		$file = $this->file->open($filePath);
		$id = sha1($file->toString());
		if ($this->cloudStorage->upload($id, $file->toString()))
		{
			$metadata = ['id' => $id];

			$photo = $this->photo->read($file);
			$photo->setMetadata($metadata)->resize(512, 512);

			// Output to STDOUT
			if ($outputFilePath === '-')
			{
				$output->writeln($photo->toString());

				return;
			}

			$outputFilePath = $outputFilePath ?: $this->getDefaultOutputFilePath($filePath);
			$outputFile = $this->file->open($outputFilePath);
			$outputFile->write($photo->toString());

			$output->writeln("Successfully write thumbnail to {$outputFilePath}.");
		}
	}

	private function getDefaultOutputFilePath($filePath)
	{
		return $filePath . '.s3pl.jpg';
	}
}
