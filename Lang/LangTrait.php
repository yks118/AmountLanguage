<?php
namespace AmountLanguage\Lang;

use AmountLanguage\AmountLanguage;

/**
 * Trait LangTrait
 *
 * @package AmountLanguage\Lang
 *
 * @method AmountLanguage setDecode(string $lang, string $type)
 * @method string getEncode(string $type)
 */
trait LangTrait
{
	/**
	 * @var AmountLanguage $amountScale
	 */
	private AmountLanguage $amountScale;

	/**
	 * LangExtend constructor.
	 *
	 * @param AmountLanguage|null $amountScale
	 */
	public function __construct(AmountLanguage $amountScale = null)
	{
		$this->amountScale = $amountScale;
	}

	/**
	 * __call
	 *
	 * @param   string  $method
	 * @param   array   $params
	 *
	 * @return  AmountLanguage|string|null
	 *          AmountLanguage     prefix 'set'
	 *          string          prefix 'get'
	 *          null            not method
	 */
	public function __call(string $method, array $params)
	{
		switch ($method)
		{
			case 'setDecode' :
				return $this->amountScale->set($this->decode(...$params));
				break;
			case 'getEncode' :
				return $this->encode($this->amountScale->get(), ...$params);
				break;
		}
		return null;
	}
}
