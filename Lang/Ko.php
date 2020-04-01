<?php
namespace AmountLanguage\Lang;

use AmountLanguage\AmountLanguage;

/**
 * Class Ko
 *
 * Korean ( 한국어 / KRW )
 *
 * @package AmountLanguage\Lang
 *
 * @method AmountLanguage setDecode(string $lang, string $type = 'hangul')
 * @method string getEncode(string $type = 'hangul')
 */
class Ko implements LangInterface
{
	use LangTrait;

	/**
	 * @var array $support
	 */
	public array $support = ['hangul', 'hanja'];

	/**
	 * @var array $numbers
	 */
	public array $numbers = [
		'number'    => [
			'', 1, 2, 3, 4, 5, 6, 7, 8, 9
		],
		'hangul'    => [
			'', '일', '이', '삼', '사', '오', '육', '칠', '팔', '구'
		],
		'hanja'     => [
			'', '壹', '貳', '參', '肆', '伍', '陸', '柒', '捌', '玖'
		]
	];

	/**
	 * @var array $units
	 */
	public array $units = [
		'number'    => [
			'', 10, 100, 1000
		],
		'hangul'    => [
			'', '십', '백', '천'
		],
		'hanja'     => [
			'', '拾', '百', '阡'
		]
	];

	/**
	 * @var array $scales
	 */
	public array $scales = [
		'number'    => [
			'',

			// 만
			10000,

			// 억
			100000000,

			// 조
			1000000000000,

			// 경
			10000000000000000,

			// 해
			100000000000000000000,
		],
		'hangul'    => [
			'', '만', '억', '조', '경', '해'
		],
		'hanja'     => [
			'', '萬', '億', '兆', '京', '垓'
		]
	];

	/**
	 * @var array $zero
	 */
	public array $zero = [
		'number'    => 0,
		'hangul'    => '영',
		'hanja'     => '零'
	];

	/**
	 * clean
	 *
	 * 한글에 불필요한 문자 제거
	 *
	 * @param   string  $lang
	 * @param   string  $type   hangul / hanja
	 *
	 * @return  string
	 */
	public function clean(string $lang, string $type = 'hangul'): string
	{
		$filter = array_filter(array_merge($this->numbers[$type], $this->units[$type], $this->scales[$type]));
		$lang = preg_replace('/[^' . implode('', $filter) . ']/u', '', $lang);
		return $lang;
	}

	/**
	 * decode
	 *
	 * 한글(한자)로 입력된 숫자를 int로 변환
	 * Ex 1. 천원 -> 1000
	 * Ex 2. 오천원 -> 5000
	 *
	 * @param   string  $lang
	 * @param   string  $type   hangul / hanja
	 *
	 * @return  int
	 */
	public function decode(string $lang, string $type = 'hangul'): int
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
	 * 숫자를 한글로 변경
	 * Ex 1. 1000 -> 천원
	 * Ex 2. 5000 -> 오천원
	 *
	 * @param   int     $amount
	 * @param   string  $type   hangul / hanja
	 *
	 * @return  string
	 */
	public function encode(int $amount, string $type = 'hangul'): string
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
