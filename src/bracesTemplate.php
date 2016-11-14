<?php namespace bracesTemplate;

//   \{properties\}((.|\n)*)\{\/properties\}

class bracesTemplate {

	/**
	 * @param $file
	 *
	 * @return string
	 * @throws \Exception
	 */
	static private function getTemplate($file)
	{
		if (!is_file($file))
		{
			$msg = 'Template "%s" cannot be found.';
			$msg = sprintf($msg, $file);

			throw new \Exception($msg);
		}

		return file_get_contents($file);
	}

	/**
	 * @param        $file
	 * @param        $fields
	 * @param bool   $formatForXml
	 * @param string $template
	 * @param string $fileType
	 *
	 * @return mixed|string
	 */
	static public function fill($file, $fields, $formatForXml = false, $template = '', $fileType = '')
	{
		if ($file)
		{
			preg_match('/\.([a-z0-9]+)$/', $file, $matches);

			$fileType = $matches[1];
			$template = bracesTemplate::getTemplate($file);
		}

		if ($formatForXml)
		{
			foreach ($fields as $key => $value)
			{
				$fields[ $key ] = bracesTemplate::formatXmlString($value);
			}
		}

		foreach ($fields as $key => $value)
		{
			$key =  str_replace('/', '\/', preg_quote($key));

			if (is_array($value))
			{
				if ($fileType == 'json') {
					$pattern = '';
				} else {
					$pattern = '/\{%s\}((.|\n)*)\{\/%s\}/';
				}
				$pattern = sprintf($pattern, $key);

				preg_match($pattern, $template, $matches);

				$replacement = bracesTemplate::fill(false, $fields[ $key ], $formatForXml, $matches[1], $fileType);

				$template = preg_replace($pattern, $value, $template);
			}
			else
			{
				$pattern  = '/\{%s(?:[:](.*))?\}/m';
				$pattern = sprintf($pattern, $key);
				$template = preg_replace($pattern, $value, $template);
			}
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
	static private function formatXmlString($val)
	{
		$findArr = ['&', '<', '>'];
		$repArr  = ['&amp;', '&lt;', '&gt;'];

		return str_replace($findArr, $repArr, $val);
	}
}