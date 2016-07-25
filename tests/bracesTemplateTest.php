<?php namespace bracesTemplate;

use PHPUnit\Framework\TestCase;

class bracesTemplateTest extends TestCase {

	public function testExceptionForBasicConstruction()
	{
		new bracesTemplate();
	}

	public function testExceptionForDirectoryConstruction()
	{
		new bracesTemplate(__DIR__ . '/sampleTemplates');
	}

	public function testLoadingFileInDefinedDir()
	{
		$bt       = new bracesTemplate(__DIR__ . '/sampleTemplates');
		$fields   = [
			'fromStatus'  => 1,
			'toStatus'    => 2,
			'datetime'    => '2016-07-25 12:00:00',
			'description' => 'order approved',
		];
		$template = $bt->fill('basic-status.xml', $fields);

		$this->assertEquals($template, file_get_contents('tests/sampleOutcome/basic-status.xml'));
	}

	public function testLoadingFileWithOutTemplateDir()
	{
		$bt       = new bracesTemplate();
		$file     = __DIR__ . '/sampleTemplates/basic-status.xml';
		$fields   = [
			'fromStatus'  => 1,
			'toStatus'    => 2,
			'datetime'    => '2016-07-25 12:00:00',
			'description' => 'order approved',
		];
		$template = $bt->fill($file, $fields);

		$this->assertEquals($template, file_get_contents('tests/sampleOutcome/basic-status.xml'));
	}

	public function testLoadingWithDefaults()
	{
		$bt       = new bracesTemplate();
		$file     = __DIR__ . '/sampleTemplates/defaults-uspsAddressValidation.xml';
		$fields   = [
			'userId'   => '12345',
			'address2' => '2 E Bay St',
			'city'     => 'Savannah',
			'state'    => 'GA',
			'zip5'     => '31401',
		];
		$template = $bt->fill($file, $fields);

		$this->assertEquals($template, file_get_contents('tests/sampleOutcome/defaults-uspsAddressValidation.xml'));
	}

}