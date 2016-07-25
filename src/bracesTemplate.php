<?php namespace bracesTemplate;

class bracesTemplate {

	private $baseDir;

	/**
	 * bracesTemplate constructor.
	 *
	 * @param null $dir
	 *
	 * @throws \Exception
	 */
	public function __construct($dir = null)
	{
		if ($dir && is_dir($dir))
		{
			$this->baseDir = realpath($dir);
		}
		elseif ($dir)
		{
			$msg = 'Directory "%s" cannot be found.';
			$msg = sprintf($msg, $dir);

			throw new \Exception($msg);
		}
	}

	/**
	 * @param $file
	 *
	 * @return string
	 * @throws \Exception
	 */
	private function getTemplate($file)
	{
		if ($this->baseDir)
		{
			$path = $this->baseDir . '/' . $file;
		}
		else
		{
			$path = $file;
		}

		if (!is_file($path))
		{
			$msg = 'Template "%s" cannot be found.';
			$msg = sprintf($msg, $path);

			throw new \Exception($msg);
		}

		return file_get_contents($path);
	}

	/**
	 * @param      $fileName
	 * @param      $fields
	 * @param bool $formatForXml
	 *
	 * @return mixed|string
	 */
	public function fill($fileName, $fields, $formatForXml = false)
	{
		$template = $this->getTemplate($fileName);

		if ($formatForXml)
		{
			foreach ($fields as $key => $value)
			{
				$fields[ $key ] = $this->formatXmlString($value);
			}
		}

		foreach ($fields as $key => $value)
		{
			$pattern  = '/\{' . str_replace('/', '\/', preg_quote($key)) . '(?:[:](.*))?\}/m';
			$template = preg_replace($pattern, $value, $template);
		}

		preg_match_all('/\{(?:.*)[:](.*)?\}/', $template, $matches);

		foreach ($matches[0] as $key => $subject)
		{
			$template = str_replace($subject, $matches[1][ $key ], $template);
		}

		return $template;
	}

	/**
	 * @param $val
	 *
	 * @return mixed
	 */
	private function formatXmlString($val)
	{
		$findArr = ['&', '<', '>'];
		$repArr  = ['&amp;', '&lt;', '&gt;'];

		return str_replace($findArr, $repArr, $val);;
	}
}