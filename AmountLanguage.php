<?php
namespace AmountLanguage;

use AmountLanguage\Lang\Ja;
use AmountLanguage\Lang\Ko;

/**
 * Class AmountLanguage
 *
 * @package AmountLanguage
 *
 * @property Ko $ko
 * @property Ja $ja
 */
class AmountLanguage
{
	/**
	 * @var int $amount
	 */
	public int $amount = 0;

	public function __get(string $name)
	{
		if (isset($this->$name))
			return $this->$name;
		else
		{
			$class = '\AmountLanguage\Lang\\' . ucfirst($name);
			return $this->$name = new $class($this);
		}
	}

	/**
	 * set
	 *
	 * @param   string  $amount Ex. 1,000 or 1000
	 *
	 * @return  AmountLanguage
	 */
	public function set(string $amount): AmountLanguage
	{
		$this->amount = (int) preg_replace('/[^0-9]/', '', $amount);
		return $this;
	}

	/**
	 * get
	 *
	 * @return  int
	 */
	public function get(): int
	{
		return $this->amount;
	}
}
