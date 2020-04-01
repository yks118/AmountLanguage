<?php
namespace AmountLanguage\Lang;

/**
 * Interface LangInterface
 *
 * @package AmountLanguage\Lang
 */
interface LangInterface
{
	/**
	 * clean
	 *
	 * @param   string  $lang
	 * @param   string  $type
	 *
	 * @return  string
	 */
	public function clean(string $lang, string $type): string;

	/**
	 * decode
	 *
	 * @param   string  $lang
	 * @param   string  $type
	 *
	 * @return  int
	 */
	public function decode(string $lang, string $type): int;

	/**
	 * encode
	 *
	 * @param   int     $amount
	 * @param   string  $type
	 *
	 * @return  string
	 */
	public function encode(int $amount, string $type): string;
}
