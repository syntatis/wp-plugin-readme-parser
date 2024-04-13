<?php

declare(strict_types=1);

namespace Syntatis\WP\PluginReadMeParser\Tests;

use PHPUnit\Framework\TestCase;
use Syntatis\WP\PluginReadMeParser\Parser;

use function gettype;

class ParserTest extends TestCase
{

	/**
	 * Test retrieving the "Tested up to:" value.
	 *
	 * @return void
	 */
	public function testRetrievingTested() {
		$parser = new Parser(__DIR__ . '/fixtures/readme.txt');

		$this->assertEquals('5.4', $parser->tested);
	}
}
