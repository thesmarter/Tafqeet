<?php

declare(strict_types=1);

namespace thesmarter\Tafqeet\Core;

use thesmarter\Tafqeet\Exception\TafqeetException;

class Tafqeet
{
    private const CONNECTION_TOOL = ' و';

    private const CURRENCIES = [
        // عربي
        'sar' => ['main1' => 'ريال', 'main2' => 'ريالاً', 'single' => 'هللة', 'multi' => 'هللات'],
        'sdg' => ['main1' => 'جنيه', 'main2' => 'جنيهًا', 'single' => 'قرش', 'multi' => 'قروش'],
        'egp' => ['main1' => 'جنيه', 'main2' => 'جنيهًا', 'single' => 'قرش', 'multi' => 'قروش'],
        'syp' => ['main1' => 'جنيه', 'main2' => 'جنيهًا', 'single' => 'قرش', 'multi' => 'قروش'],
        'lbp' => ['main1' => 'جنيه', 'main2' => 'جنيهًا', 'single' => 'قرش', 'multi' => 'قروش'],
        'iqd' => ['main1' => 'دينار', 'main2' => 'دينارًا', 'single' => 'درهم', 'multi' => 'دراهم'],
        'jod' => ['main1' => 'دينار', 'main2' => 'دينارًا', 'single' => 'درهم', 'multi' => 'دراهم'],
        'omr' => ['main1' => 'ريال', 'main2' => 'ريالًا', 'single' => 'درهم', 'multi' => 'دراهم'],
        'qar' => ['main1' => 'ريال', 'main2' => 'ريالًا', 'single' => 'درهم', 'multi' => 'دراهم'],
        'aed' => ['main1' => 'درهم', 'main2' => 'درهمًا', 'single' => 'فلس', 'multi' => 'فلوس'],
        'kwd' => ['main1' => 'دينار', 'main2' => 'دينارًا', 'single' => 'درهم', 'multi' => 'دراهم'],
        'bhd' => ['main1' => 'دينار', 'main2' => 'دينارًا', 'single' => 'درهم', 'multi' => 'دراهم'],
        // غربي
        'usd' => ['main1' => 'دولار', 'main2' => 'دولاراً', 'single' => 'سنت', 'multi' => 'سنت'],
        'eur' => ['main1' => 'يورو', 'main2' => 'يوروًا', 'single' => 'سنت', 'multi' => 'سنت'],
        'gbp' => ['main1' => 'جنيه إسترليني', 'main2' => 'جنيه إسترلينيًا', 'single' => 'بيني', 'multi' => 'بنسات'],
        'cad' => ['main1' => 'دولار', 'main2' => 'دولارًا', 'single' => 'سنت', 'multi' => 'سنت'],
        'aud' => ['main1' => 'دولار', 'main2' => 'دولارًا', 'single' => 'سنت', 'multi' => 'سنت'],
        'jpy' => ['main1' => 'ين', 'main2' => 'ينًا', 'single' => '', 'multi' => ''],
        'chf' => ['main1' => 'فرنك', 'main2' => 'فرنكًا', 'single' => 'رابم', 'multi' => 'رابم'],
    ];

    private const ONES = [
        0 => 'صفر', 1 => 'واحد', 2 => 'اثنان', 3 => 'ثلاثة', 4 => 'أربعة',
        5 => 'خمسة', 6 => 'ستة', 7 => 'سبعة', 8 => 'ثمانية', 9 => 'تسعة',
        10 => 'عشرة', 11 => 'أحد عشر', 12 => 'اثنى عشر',
    ];

    private const TENS = [
        1 => 'عشر', 2 => 'عشرون', 3 => 'ثلاثون', 4 => 'أربعون',
        5 => 'خمسون', 6 => 'ستون', 7 => 'سبعون', 8 => 'ثمانون', 9 => 'تسعون',
    ];

    private const HUNDREDS = [
        0 => 'صفر', 1 => 'مائة', 2 => 'مئتان', 3 => 'ثلاثمائة', 4 => 'أربعمائة',
        5 => 'خمسمائة', 6 => 'ستمائة', 7 => 'سبعمائة', 8 => 'ثمانمائة', 9 => 'تسعمائة',
    ];

    private const SCALE = [
        'thousands' => [1 => 'ألف', 2 => 'ألفان', 39 => 'آلاف', 1199 => 'ألفًا'],
        'millions'  => [1 => 'مليون', 2 => 'مليونان', 39 => 'ملايين', 1199 => 'مليونًا'],
        'billions'  => [1 => 'مليار', 2 => 'ملياران', 39 => 'مليارات', 1199 => 'مليارًا'],
        'trillions' => [1 => 'تريليون', 2 => 'تريليونان', 39 => 'تريليونات', 1199 => 'تريليونًا'],
    ];

    private const OTHERS = [
        1 => 'احد', 2 => 'اثنا', 4 => 'اربع',
    ];

    private string $amount;
    private array $beforeCommaDigits = [];
    private array $afterCommaDigits = [];
    private int $beforeCommaLength = 0;
    private int $afterCommaLength = 0;
    private string $afterCommaSum = '';
    private bool $isMain1Currency = true;
    private string $resultBeforeComma = '';
    private string $resultAfterComma = '';

    public function __construct(int|float|string $amount)
    {
        if (!is_numeric($amount)) {
            throw new TafqeetException('The provided amount is not a valid number.');
        }

        $this->amount = (string) $amount;
    }

    public static function arablic(int|float|string $amount = 0, string $currency = 'sar'): string
    {
        return (new self($amount))->toWords($currency);
    }

    public function toWords(string $currency = 'sar'): string
    {
        $this->parse();
        $this->compute();

        return $this->buildResult($currency);
    }

    private function parse(): void
    {
        $parts = explode('.', $this->amount);
        $this->beforeCommaDigits = array_map('intval', str_split($parts[0]));
        $this->beforeCommaLength = count($this->beforeCommaDigits);

        if (count($parts) >= 2) {
            $after = array_map('intval', str_split($parts[1]));
            if (count($after) >= 3) {
                $after = [$after[0], $after[1]];
            }
            $this->afterCommaDigits = $after;
            $this->afterCommaLength = count($this->afterCommaDigits);
            $this->afterCommaSum = implode('', $this->afterCommaDigits);
        } else {
            $this->afterCommaDigits = [];
            $this->afterCommaLength = 0;
            $this->afterCommaSum = '';
        }
    }

    private function compute(): void
    {
        $this->resultBeforeComma = $this->runBeforeComma();
        $this->resultAfterComma = $this->runAfterComma();
    }

    private function runBeforeComma(): string
    {
        $class = $this->detectClass($this->beforeCommaLength);
        if ($class === null) {
            return 'عفوا هذا الرقم خارج نطاقنا حاليا حاول لاحقاً';
        }

        return $this->computeClass('Class' . $class, $this->beforeCommaDigits, $this->beforeCommaLength);
    }

    private function runAfterComma(): string
    {
        if ($this->afterCommaLength === 0) {
            return '';
        }

        $class = $this->detectClass($this->afterCommaLength);
        if ($class === null) {
            return 'عفوا هذا الرقم خارج نطاقنا حاليا حاول لاحقاً';
        }

        return $this->computeClass('Class' . $class, $this->afterCommaDigits, $this->afterCommaLength);
    }

    private function detectClass(int $length): ?string
    {
        return match ($length) {
            1 => 'A',
            2 => 'B',
            3 => 'C',
            4 => 'D',
            5 => 'E',
            6 => 'F',
            default => null,
        };
    }

    private function computeClass(string $methodName, array $digits, int $length): string
    {
        return match ($methodName) {
            'ClassA' => $this->classA($digits),
            'ClassB' => $this->classB($digits),
            'ClassC' => $this->classC($digits),
            'ClassD' => $this->classD($digits),
            'ClassE' => $this->classE($digits),
            'ClassF' => $this->classF($digits),
            default => '',
        };
    }

    private function classA(array $arr): string
    {
        return self::ONES[$arr[0]] ?? '';
    }

    private function classB(array $arr): string
    {
        if ($this->beforeCommaLength >= 2) {
            $tenIdx = $this->beforeCommaLength - 2;
            $singleIdx = $this->beforeCommaLength - 1;
            $detected = [$this->beforeCommaDigits[$tenIdx], $this->beforeCommaDigits[$singleIdx]];
            if ($arr === $detected) {
                if ($arr[0] === 0 && $arr[1] >= 1 && $arr[1] <= 10) {
                    $this->isMain1Currency = true;
                } elseif ($arr[0] >= 1 && $arr[1] >= 1 && $arr[1] <= 9) {
                    $this->isMain1Currency = false;
                } elseif ($arr[0] >= 2) {
                    $this->isMain1Currency = false;
                }
            }
        }

        if ($arr[0] === 0 && $arr[1] === 0) {
            return '';
        }

        if ($arr[0] === 0) {
            return self::ONES[$arr[1]];
        }

        if ($arr[0] === 1 && $arr[1] === 1) {
            return self::ONES[11];
        }

        if ($arr[0] === 1 && $arr[1] === 0) {
            return self::ONES[10];
        }

        if ($arr[1] === 0) {
            return self::TENS[$arr[0]];
        }

        if ($arr[0] > 1) {
            return self::ONES[$arr[1]] . self::CONNECTION_TOOL . self::TENS[$arr[0]];
        }

        if (in_array($arr[1], [1, 2], true)) {
            return self::OTHERS[$arr[1]] . ' ' . self::TENS[$arr[0]];
        }

        return self::ONES[$arr[1]] . ' ' . self::TENS[$arr[0]];
    }

    private function classC(array $arr): string
    {
        if ($arr[0] === 0 && $arr[1] === 0 && $arr[2] === 0) {
            return '';
        }

        if ($arr[0] === 0 && $arr[1] === 0) {
            return self::ONES[$arr[2]];
        }

        if ($arr[0] === 0) {
            return $this->classB([$arr[1], $arr[2]]);
        }

        if ($arr[2] === 0 && $arr[1] === 0) {
            return self::HUNDREDS[$arr[0]];
        }

        if ($arr[1] !== 0) {
            return self::HUNDREDS[$arr[0]] . self::CONNECTION_TOOL . $this->classB([$arr[1], $arr[2]]);
        }

        return self::HUNDREDS[$arr[0]] . self::CONNECTION_TOOL . self::ONES[$arr[2]];
    }

    private function classD(array $arr): string
    {
        $classC = [$arr[1], $arr[2], $arr[3]];

        if ($arr[0] <= 2) {
            $thousands = self::SCALE['thousands'][$arr[0]];
        } else {
            $thousands = self::ONES[$arr[0]] . ' ' . self::SCALE['thousands'][39];
        }

        if ($arr[1] === 0 && $arr[2] === 0 && $arr[3] === 0) {
            return $thousands;
        }

        return $thousands . self::CONNECTION_TOOL . $this->classC($classC);
    }

    private function classE(array $arr): string
    {
        $classC = [$arr[2], $arr[3], $arr[4]];

        if ($arr[0] !== 0) {
            $conn = ' ';

            if ($arr[1] >= 2 && $arr[0] > 1) {
                $conn = self::CONNECTION_TOOL;
            }

            if (in_array($arr[1], [1, 2], true)) {
                $thousands = self::OTHERS[$arr[1]] . $conn . self::TENS[$arr[0]];
            } else {
                $thousands = self::ONES[$arr[1]] . $conn . self::TENS[$arr[0]];
            }

            if ($arr[1] === 0) {
                if ($arr[0] === 1) {
                    $thousands = self::ONES[10];
                    $thousands .= ' ' . self::SCALE['thousands'][39];
                } else {
                    $thousands = self::TENS[$arr[0]];
                    $thousands .= ' ' . self::SCALE['thousands'][1];
                }
            } else {
                if ($arr[2] === 0 && $arr[3] === 0 && $arr[4] === 0) {
                    $thousands .= ' ' . self::SCALE['thousands'][1];
                } else {
                    $thousands .= ' ' . self::SCALE['thousands'][1199];
                }
            }
        } else {
            if (in_array($arr[1], [1, 2], true)) {
                $thousands = self::OTHERS[$arr[1]] . ' ';
            } else {
                $thousands = self::ONES[$arr[1]] . ' ';
            }

            if ($arr[1] === 0) {
                $thousands = self::TENS[$arr[2]];
            }

            $thousands .= ' ' . self::SCALE['thousands'][39];
        }

        if ($this->classC($classC) !== '') {
            return $thousands . self::CONNECTION_TOOL . $this->classC($classC);
        }

        return $thousands;
    }

    private function classF(array $arr): string
    {
        $classC = [$arr[3], $arr[4], $arr[5]];

        if ($arr[0] !== 0) {
            if ($arr[1] === 0 && $arr[2] === 0) {
                $thousands = self::HUNDREDS[$arr[0]] . ' ' . self::SCALE['thousands'][1];
            } else {
                if ($arr[1] === 0) {
                    $thousands = self::HUNDREDS[$arr[0]] . self::CONNECTION_TOOL
                        . self::ONES[$arr[2]] . ' ' . self::SCALE['thousands'][1];
                } elseif ($arr[2] === 0) {
                    if ($arr[3] === 0 && $arr[4] === 0 && $arr[5] === 0) {
                        $thousands = self::HUNDREDS[$arr[0]] . self::CONNECTION_TOOL
                            . self::TENS[$arr[1]] . ' ' . self::SCALE['thousands'][1];
                    } else {
                        $thousands = self::HUNDREDS[$arr[0]] . self::CONNECTION_TOOL
                            . self::TENS[$arr[1]] . ' ' . self::SCALE['thousands'][1199];
                    }
                } else {
                    if ($arr[1] === 0 && $arr[2] >= 1 && $arr[1] <= 10) {
                        $thousandsLang = self::SCALE['thousands'][1];
                    } elseif ($arr[1] >= 1 && $arr[2] >= 1 && $arr[1] <= 9) {
                        $thousandsLang = self::SCALE['thousands'][1199];
                    } else {
                        $thousandsLang = self::SCALE['thousands'][1199];
                    }

                    $thousands = $this->classC([$arr[0], $arr[1], $arr[2]], 3) . ' ' . $thousandsLang;
                }
            }
        } else {
            return $this->classE([$arr[1], $arr[2], $arr[3], $arr[4], $arr[5]]);
        }

        if ($this->classC($classC) !== '') {
            return $thousands . self::CONNECTION_TOOL . $this->classC($classC);
        }

        return $thousands;
    }

    private function buildResult(string $currency): string
    {
        $currencyConfig = self::CURRENCIES[$currency] ?? self::CURRENCIES['sar'];

        $result = 'فقط ';

        if ($this->isMain1Currency) {
            $result .= $this->resultBeforeComma . ' ' . $currencyConfig['main1'];
        } else {
            $result .= $this->resultBeforeComma . ' ' . $currencyConfig['main2'];
        }

        if ($this->afterCommaLength >= 1) {
            $fractionalWord = in_array((int) $this->afterCommaSum, [3, 4, 5, 6, 7, 8, 9, 10], false)
                ? $currencyConfig['multi']
                : $currencyConfig['single'];

            if ($fractionalWord !== '') {
                $result .= self::CONNECTION_TOOL . $this->resultAfterComma . ' ' . $fractionalWord;
            }
        }

        $result .= ' لاغير';

        return preg_replace('/\s{2,}/', ' ', $result);
    }
}
