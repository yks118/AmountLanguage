# AmountLanguage
갖은자를 변환하는 PHP 7.4+ 라이브러리( https://github.com/yks118/AmountLanguage )입니다.

## 테스트
https://manana.kr/amount-language

## 사용법
### 라이브러리 로드 및 변수 지정
```php
require_once '{YOUR LIB PATH}/AmountLanguage/autoload.php';
$amountLanguage = new \AmountLanguage\AmountLanguage();
```

### 변경 할 데이터를 설정
#### 1. 숫자 지정
```php
/** @var \AmountLanguage\AmountLanguage $amountLanguage */
$amountLanguage->set(100000000);
```

#### 2. 한글(한국) 지정
```php
/** @var \AmountLanguage\AmountLanguage $amountLanguage */
$amountLanguage->ko->setDecode('일억', 'hangul');
```

#### 3. 한자(한국) 지정
```php
/** @var \AmountLanguage\AmountLanguage $amountLanguage */
$amountLanguage->ko->setDecode('壹億', 'hanja');
```

#### 4. 한자(일본) 지정
```php
/** @var \AmountLanguage\AmountLanguage $amountLanguage */
$amountLanguage->ja->setDecode('壱億', 'kanji');
```

### 변경 및 출력
#### 1. 숫자로 출력
```php
/** @var \AmountLanguage\AmountLanguage $amountLanguage */
echo $amountLanguage->get();
```

#### 2. 한글(한국)로 출력
```php
/** @var \AmountLanguage\AmountLanguage $amountLanguage */
echo $amountLanguage->ko->getEncode('hangul');
```

#### 3. 한자(한국)로 출력
```php
/** @var \AmountLanguage\AmountLanguage $amountLanguage */
echo $amountLanguage->ko->getEncode('hanja');
```

#### 4. 한자(일본)로 출력
```php
/** @var \AmountLanguage\AmountLanguage $amountLanguage */
echo $amountLanguage->ja->getEncode('kanji');
```
