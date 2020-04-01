<?php
namespace AmountLanguage\Lang;

use AmountLanguage\AmountLanguage;

/**
 * Class Ko
 *
 * Japanese ( 日本語 / JPY )
 *
 * @package AmountLanguage\Lang
 *
 * @method AmountLanguage setDecode(string $lang, string $type = 'kanji')
 * @method string getEncode(string $type = 'kanji')
 */
class Ja implements LangInterface
{
	use LangTrait;

	/**
	 * @var array $support
	 */
	public array $support = ['kanji'];

	/**
	 * @var array $numbers
	 */
	public array $numbers = [
		'number'    => [
			'', 1, 2, 3, 4, 5, 6, 7, 8, 9
		],
		'kanji'     => [
			'', '壱', '弐', '参', '肆', '伍', '陸', '漆', '捌', '玖'
		]
	];

	/**
	 * @var array $units
	 */
	public array $units = [
		'number'    => [
			'', 10, 100, 1000
		],
		'kanji'     => [
			'', '拾', '百', '阡'
		]
	];

	/**
	 * @var array $scales
	 */
	public array $scales = [
		'number'    => [
			'',
			10000,
			100000000,
			1000000000000,
			10000000000000000,
			100000000000000000000,
		],
		'kanji'     => [
			'', '萬', '億', '兆', '京', '垓'
		]
	];

	/**
	 * @var array $zero
	 */
	public array $zero = [
		'number'    => 0,
		'kanji'     => '零'
	];

	/**
	 * clean
	 *
	 * @param   string  $lang
	 * @param   string  $type   kanji
	 *
	 * @return  string
	 */
	public function clean(string $lang, string $type = 'kanji'): string
	{
		$filter = array_filter(array_merge($this->numbers[$type], $this->units[$type], $this->scales[$type]));
		$lang = preg_replace('/[^' . implode('', $filter) . ']/u', '', $lang);
		return $lang;
	}

	/**
	 * decode
	 *
	 * @param   string  $lang
	 * @param   string  $type   kanji
	 *
	 * @return  int
	 */
	public function decode(string $lang, string $type = 'kanji'): int
	{
		if (!in_array($type, $this->support))
			return 0;

		$lang = $this->clean($lang, $type);
		if (empty($lang))
			return 0;

		$amount = 0;
		$amountUnit = 0;
		$count = mb_strlen($lang);
		for ($i = 0; $i < $count; $i++)
		{
			$char = mb_substr($lang, $i, 1);

			if (in_array($char, $this->numbers[$type]))
				$amountUnit = str_replace($this->numbers[$type], $this->numbers['number'], $char);
			elseif (in_array($char, $this->units[$type]))
			{
				if ($amountUnit === 0)
					$amountUnit = 1;
				$amountUnit *= str_replace($this->units[$type], $this->units['number'], $char);
			}
			elseif (in_array($char, $this->scales[$type]))
			{
				if ($amountUnit === 0)
					$amountUnit = 1;
				$amountUnit *= str_replace($this->scales[$type], $this->scales['number'], $char);
				$amount += $amountUnit;
				$amountUnit = 0;
			}
		}
		return $amount + $amountUnit;
	}

	/**
	 * encode
	 *
	 * @param   int     $amount
	 * @param   string  $type   kanji
	 *
	 * @return  string
	 */
	public function encode(int $amount, string $type = 'kanji'): string
	{
		if (!in_array($type, $this->support))
			return 'Error : Not Support';
		elseif ($amount === 0)
			return $this->zero[$type];

		$hangul = '';
		$tmp = $amount;
		foreach ($this->scales[$type] as $scale)
		{
			$temp = preg_replace('/.*([0-9]{4})$/', '$1', $tmp);
			if (intval($temp) !== 0)
			{
				$hangul = $scale . $hangul;
				$splits = str_split($temp, 1);
				krsort($splits);
				$splits = array_values($splits);
				foreach ($splits as $key => $split)
				{
					if ($split !== '0')
					{
						$hangul = $this->numbers[$type][$split] . $this->units[$type][$key] . $hangul;
					}
				}
			}

			$tmp = preg_replace('/^([0-9]*)' . $temp . '$/', '$1', $tmp);
			if (empty($tmp))
				break;
		}
		return $hangul;
	}
}
