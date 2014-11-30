<?php namespace SssPhotoLibrary\File;

class File implements FileInterface {

	/**
	 * @var string
	 */
	private $openMode;

	/** @var \SplFileObject */
	private $file;

	/** @var \SplFileInfo */
	private $fileInfo;

	public function open($path, $mode = 'r', $checkExists = true)
	{
		$this->openMode = $mode;
		$this->fileInfo = new \SplFileInfo($path);

		if ($checkExists && ! $this->exists())
		{
			throw new \InvalidArgumentException("{$path} does not exist.");
		}

		if ($checkExists && ! $this->fileInfo->isFile())
		{
			throw new \InvalidArgumentException("{$path} exists but is not a file.");
		}

		return $this;
	}

	private function openFile()
	{
		if ( ! $this->exists())
		{
			// @todo: Real Path?
			touch($this->fileInfo->getFilename());
		}

		$this->file = $this->fileInfo->openFile($this->openMode);
	}

	public function exists()
	{
		return file_exists($this->fileInfo->getRealPath());
	}

	private function opened()
	{
		return $this->file instanceof \SplFileObject;
	}

	public function save($content)
	{
		if ( ! $this->opened())
		{
			$this->openFile();
		}

		$this->file->ftruncate(0);
		$this->file->fseek(0);

		return $this->file->fwrite($content);
	}

	public function content()
	{
		if ( ! $this->opened())
		{
			$this->openFile();
		}

		$this->file->fseek(0);

		if (method_exists($this->file, 'fread'))
		{
			$content = $this->file->fread($this->file->getSize());
		}
		else
		{
			// Simulate \SplFileObject::fread
			$content = '';

			while ( ! $this->file->eof())
			{
				$content .= $this->file->fgetc();
			}
		}

		return $content;
	}

	public function sha1()
	{
		return sha1($this->content());
	}

}
