<?php namespace bracesTemplate;

use PHPUnit\Framework\TestCase;
use bracesTemplate\bracesTemplate as bt;

class bracesTemplateTest extends TestCase {

	public function testLoadingFileInDefinedDir()
	{
		$file   = __DIR__ . '/sampleTemplates/basic-status.xml';
		$fields = [
			'fromStatus'  => 1,
			'toStatus'    => 2,
			'datetime'    => '2016-07-25 12:00:00',
			'description' => 'order approved',
		];
		$result = bt::fill($file, $fields);

		$this->assertEquals($result, file_get_contents('tests/sampleOutcome/basic-status.xml'));
	}

	public function testLoadingFileWithOutTemplateDir()
	{
		$file   = __DIR__ . '/sampleTemplates/basic-status.xml';
		$fields = [
			'fromStatus'  => 1,
			'toStatus'    => 2,
			'datetime'    => '2016-07-25 12:00:00',
			'description' => 'order approved',
		];
		$result = bt::fill($file, $fields);

		$this->assertEquals($result, file_get_contents('tests/sampleOutcome/basic-status.xml'));
	}

	public function testLoadingWithDefaults()
	{
		$file   = __DIR__ . '/sampleTemplates/defaults-uspsAddressValidation.xml';
		$fields = [
			'userId'   => '12345',
			'address2' => '2 E Bay St',
			'city'     => 'Savannah',
			'state'    => 'GA',
			'zip5'     => '31401',
		];
		$result = bt::fill($file, $fields);

		$this->assertEquals($result, file_get_contents('tests/sampleOutcome/defaults-uspsAddressValidation.xml'));
	}

	public function testRepeating()
	{
		$file   = __DIR__ . '/sampleTemplates/defaults-uspsAddressValidation.xml';
		$fields = [
			'userId'   => '12345',
			'address2' => '2 E Bay St',
			'city'     => 'Savannah',
			'state'    => 'GA',
			'zip5'     => '31401',
		];
		$result = bt::fill($file, $fields);

		$this->assertEquals($result, file_get_contents('tests/sampleOutcome/defaults-uspsAddressValidation.xml'));
	}

}