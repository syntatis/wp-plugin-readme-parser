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

		$parser = new Parser(__DIR__ . '/fixtures/readme-alt1.txt');

		$this->assertEquals('5.0', $parser->tested);
	}

	/**
	 * Test retrieving the "Tested up to:" value from the Markdown file.
	 *
	 * @return void
	 */
	public function testRetrievingTestedMarkdown() {
		$parser = new Parser(__DIR__ . '/fixtures/readme.md');

		$this->assertEquals('3.0', $parser->tested);

		$parser = new Parser(__DIR__ . '/fixtures/readme-alt1.md');

		$this->assertEquals('6.0', $parser->tested);
	}
}
