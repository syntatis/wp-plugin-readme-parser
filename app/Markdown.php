<?php

declare(strict_types=1);

namespace Syntatis\WPPluginReadMeParser;

use Michelf\MarkdownExtra;

use function array_flip;
use function get_html_translation_table;
use function preg_replace;
use function preg_replace_callback;
use function str_replace;
use function strtr;
use function trim;

use const HTML_ENTITIES;

/**
 * WordPress.org Plugin Readme Parser Markdown.
 *
 * Relies on \Michaelf\Markdown_Extra
 */
class Markdown extends MarkdownExtra
{
	/**
	 * @param string $text
	 *
	 * @return string
	 */
	public function transform($text)
	{
		$text = $this->code_trick(trim($text));

		// Convert any `= Section =` headers into a real header.
		$text = preg_replace('/^[\s]*=[\s]+(.+?)[\s]+=/m', "\n" . '<h4>$1</h4>' . "\n", $text);

		$text = parent::transform(trim($text));

		return trim($text);
	}

	/**
	 * @param string $text
	 *
	 * @return string
	 *
	 * @access protected
	 */
	protected function code_trick($text)
	{
		/*
		 * When doing markdown, first take any user formatted code blocks and turn them into backticks so that
		 * markdown will preserve things like underscores in code blocks.
		 */
		$text = preg_replace_callback('!(<pre><code>|<code>)(.*?)(</code></pre>|</code>)!s', [$this, 'code_trick_decodeit_cb'], $text);
		$text = str_replace(["\r\n", "\r"], "\n", $text);

		// Markdown can do inline code, we convert bbPress style block level code to Markdown style.
		$text = preg_replace_callback("!(^|\n)([ \t]*?)`(.*?)`!s", [$this, 'code_trick_indent_cb'], $text);

		return $text;
	}

	/**
	 * @param array $matches
	 *
	 * @return string
	 *
	 * @access protected
	 */
	protected function code_trick_indent_cb($matches)
	{
		$text = $matches[3];
		$text = preg_replace('|^|m', $matches[2] . '    ', $text);

		return $matches[1] . $text;
	}

	/**
	 * @param array $matches
	 *
	 * @return string
	 *
	 * @access protected
	 */
	protected function code_trick_decodeit_cb($matches)
	{
		$trans_table = array_flip(get_html_translation_table(HTML_ENTITIES));

		$text = $matches[2];
		$text = strtr($text, $trans_table);
		$text = str_replace('<br />', '', $text);
		$text = str_replace('&#38;', '&', $text);
		$text = str_replace('&#39;', "'", $text);

		if ($matches[1] === '<pre><code>') {
			$text = "\n$text\n";
		}

		return "`$text`";
	}
}
