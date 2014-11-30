<?php namespace SssPhotoLibrary\File;

class File implements FileInterface {

	/** @var \SplFileObject */
	private $file;

	/** @var \SplFileInfo */
	private $fileInfo;

	public function open($path, $mode = 'r', $checkExists = true)
	{
		$this->fileInfo = new \SplFileInfo($path);

		if ($checkExists && ! file_exists($path))
		{
			throw new \InvalidArgumentException("{$path} does not exist.");
		}

		if ($checkExists && ! $this->fileInfo->isFile())
		{
			throw new \InvalidArgumentException("{$path} exists but is not a file.");
		}

		$this->file = $this->fileInfo->openFile($mode);

		return $this;
	}

	public function save($content)
	{
		$this->file->ftruncate(0);
		$this->file->fseek(0);

		return $this->file->fwrite($content);
	}

	public function content()
	{
		if (method_exists($this->file, 'fread'))
		{
			return $this->file->fread($this->file->getSize());
		}

		// Simulate \SplFileObject::fread
		$content = '';

		$this->file->fseek(0);
		while ( ! $this->file->eof())
		{
			$content .= $this->file->fgetc();
		}

		return $content;
	}

	public function sha1()
	{
		return sha1($this->content());
	}

}
