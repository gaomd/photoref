<?php namespace SssPhotoLibrary\File;

class File implements FileInterface {

	/** @var \SplFileObject */
	private $file;

	/** @var \SplFileInfo */
	private $fileInfo;

	public function open($path, $mode = 'r', $checkExists = false)
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

	public function seekTo($offset)
	{
		$this->file->fseek($offset);

		return $this;
	}

	public function write($content)
	{
		return $this->file->fwrite($content);
	}

	public function toString()
	{
		$this->file->rewind();

		$content = '';

		while (($c = $this->file->fgetc()) !== false)
		{
			$content .= $c;
		}

		return $content;
	}

	public function sha1()
	{
		return sha1($this->toString());
	}
}
