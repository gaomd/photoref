<?php namespace SssPhotoLibrary\Console\Command;

use SssPhotoLibrary\CloudStorage\CloudStorageInterface;
use SssPhotoLibrary\File\FileFactory;
use SssPhotoLibrary\Photo\PhotoFactory;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class PushCommand extends Command {

	/**
	 * @var string
	 */
	protected $filePath;

	/**
	 * @var string
	 */
	protected $outputFilePath;

	/**
	 * @var \SssPhotoLibrary\CloudStorage\CloudStorageInterface
	 */
	private $cloudStorage;

	/**
	 * @var \SssPhotoLibrary\File\FileFactory
	 */
	private $file;

	/**
	 * @var \SssPhotoLibrary\Photo\PhotoFactory
	 */
	private $photo;

	public function __construct(FileFactory $file, PhotoFactory $photo, CloudStorageInterface $cloudStorage)
	{
		parent::__construct();

		$this->cloudStorage = $cloudStorage;
		$this->file = $file;
		$this->photo = $photo;
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
		$this->sanitizeParameters($input);

		$file = $this->file->open($this->filePath);

		if ( ! $this->cloudStorage->upload($file->sha1(), $file->content()))
		{
			$output->writeln("Uploading {$this->filePath}... <error>[FAILED]</error>");

			return;
		}

		$metadata = ['id' => $file->sha1()];

		$photo = $this->photo->openFile($file)
		                     ->resize(512, 512)
		                     ->stampQrCode($file->sha1())
		                     ->setMetadata($metadata);

		if ($this->isStdOut())
		{
			$output->writeln($photo->blob());

			return;
		}

		// Output to file
		$outputFile = $this->file->open($this->outputFilePath, 'r+', false);
		$photo->saveToFile($outputFile);
		$output->writeln("Uploading {$this->filePath}... <info>[SUCCESS]</info>, thumbnail: {$this->outputFilePath}");
	}

	public function isStdOut()
	{
		return $this->outputFilePath === '-';
	}

	private function sanitizeParameters(InputInterface $input)
	{
		$this->filePath = $filePath = $input->getArgument('file');

		$this->outputFilePath = $outputFilePath = $input->getOption('output');

		if ($outputFilePath === null)
		{
			$this->outputFilePath = $filePath . '.s3pl.jpg';
		}
	}

}
