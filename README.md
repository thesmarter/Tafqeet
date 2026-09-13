# Tafqeet [![Packagist Version][packagist-image]][packagist-url] [![PHP 8.1+][php-image]][php-url] [![License][license-image]][license-url] [![CI][build-image]][build-url] [![Total Downloads][downloads-image]][downloads-url]

> Convert numbers into Arabic words – a PHP library for transforming amounts into Arabic text

---

## 📖 What Is Tafqeet?

**Tafqeet** is a PHP library that helps you integrate payments and receipts documents into your project by converting amounts into Arabic words. It makes it easy to add these words anywhere you need.

**Example:**

```php
use thesmarter\Tafqeet\Core\Tafqeet;

echo Tafqeet::arablic(3150.9);
// Output: فقط ثلاثة آلاف ومائة وخمسون ريالاً وتسعة هللات لاغير
```

---

## 🚀 Installation

### Via Composer (Recommended)

```bash
composer require thesmarter/tafqeet
```

[![Packagist][packagist-image]][packagist-url]

### Manual Installation

1. Download the repository or copy the `src/` folder into your project
2. Add autoloading in `composer.json`:

```json
"autoload": {
    "psr-4": {
        "thesmarter\\Tafqeet\\": "path/to/tafqeet/src/"
    }
}
```

3. Run:

```bash
composer dump-autoload
```

---

## ⚡ Usage

### Convert Number to Arabic Words

```php
use thesmarter\Tafqeet\Core\Tafqeet;

// Simple usage (default currency: Saudi Riyal)
echo Tafqeet::arablic(3150.9);
// Output: فقط ثلاثة آلاف ومائة وخمسون ريالاً وتسعة هللات لاغير

// With custom currency
echo Tafqeet::arablic(1500.50, 'usd');
echo Tafqeet::arablic(500.25, 'sdg');
```

### Using the Object Directly

```php
use thesmarter\Tafqeet\Core\Tafqeet;

$tafqeet = new Tafqeet(123456.78);
echo $tafqeet->toWords('sar');
```

### Handling Errors

```php
use thesmarter\Tafqeet\Core\Tafqeet;
use thesmarter\Tafqeet\Exception\TafqeetException;

try {
    echo Tafqeet::arablic('not a number');
} catch (TafqeetException $e) {
    echo 'Error: ' . $e->getMessage();
}
```

---

## 📊 Supported Currencies / العملات المدعومة

### 🌍 Arab Currencies / العملات العربية

| Code | Main | Main Plural | Sub | Sub Plural |
|------|------|-------------|-----|------------|
| `sar` | ريال | ريالاً | هللة | هللات |
| `sdg` | جنيه | جنيهًا | قرش | قروش |
| `egp` | جنيه | جنيهًا | قرش | قروش |
| `syp` | جنيه | جنيهًا | قرش | قروش |
| `lbp` | جنيه | جنيهًا | قرش | قروش |
| `iqd` | دينار | دينارًا | درهم | دراهم |
| `jod` | دينار | دينارًا | درهم | دراهم |
| `omr` | ريال | ريالًا | درهم | دراهم |
| `qar` | ريال | ريالًا | درهم | دراهم |
| `aed` | درهم | درهمًا | فلس | فلوس |
| `kwd` | دينار | دينارًا | درهم | دراهم |
| `bhd` | دينار | دينارًا | درهم | دراهم |

### 🌐 Western Currencies / العملات الغربية

| Code | Main | Main Plural | Sub | Sub Plural |
|------|------|-------------|-----|------------|
| `usd` | دولار | دولاراً | سنت | سنت |
| `eur` | يورو | يوروًا | سنت | سنت |
| `gbp` | جنيه إسترليني | جنيه إسترلينيًا | بيني | بنسات |
| `cad` | دولار | دولارًا | سنت | سنت |
| `aud` | دولار | دولارًا | سنت | سنت |
| `jpy` | ين | ينًا | — | — |
| `chf` | فرنك | فرنكًا | رابم | رابم |

You can easily add new currencies by modifying the `CURRENCIES` constant inside the class.

---

## 🔧 Requirements / المتطلبات

- **PHP 8.1** or higher
- [Composer](https://getcomposer.org/) (recommended)

---

## 📋 Examples / أمثلة إضافية

```php
Tafqeet::arablic(0);           // صفر ريال لاغير
Tafqeet::arablic(1);           // فقط واحد ريال لاغير
Tafqeet::arablic(10);          // فقط عشرة ريال لاغير
Tafqeet::arablic(100);         // فقط مائة ريال لاغير
Tafqeet::arablic(1000);        // فقط ألف ريال لاغير
Tafqeet::arablic(1100);        // فقط ألف ومائة ريال لاغير
Tafqeet::arablic(10000);       // فقط عشرة آلاف ريال لاغير
Tafqeet::arablic(100000);      // فقط مائة ألف ريال لاغير
Tafqeet::arablic(123456);      // فقط مائة وثلاثة وعشرون ألفًا وأربعمائة وستة وخمسون ريالاً لاغير
Tafqeet::arablic(999999.99);   // تسعمائة وتسعة وتسعون ألفًا وتسعمائة وتسعة وتسعون ريالاً وتسعة وتسعون هللة لاغير
```

---

## 🏗️ Project Structure / هيكل المشروع

```
Tafqeet/
├── src/
│   ├── Core/
│   │   └── Tafqeet.php          # Main class
│   └── Exception/
│       └── TafqeetException.php  # Custom exception
├── tests/                        # Tests
├── test.php                      # Quick demo
├── composer.json
├── phpunit.xml
└── README.md
```

---

## 🤍 Contributing / المساهمة

Contributions are welcome! Feel free to open an **Issue** or **Pull Request**.

1. Fork the project
2. Create a feature branch (`git checkout -b feature/amazing-feature`)
3. Commit your changes (`git commit -m 'Add amazing feature'`)
4. Push the branch (`git push origin feature/amazing-feature`)
5. Open a Pull Request

---

## 📄 License / الرخصة

Licensed under the **MIT License**. See the [LICENSE](LICENSE) file for details.

---

## 🔗 Useful Links / روابط مفيدة

[![Packagist][packagist-image]][packagist-url]
[![GitHub][github-image]][github-url]

---

## ⚠️ Note / ملاحظة

The library currently works for numbers up to **999999.99**.

---

<!-- Badge Links / روابط الشارات -->
[packagist-image]: https://img.shields.io/packagist/v/thesmarter/tafqeet.svg?style=flat-square
[packagist-url]: https://packagist.org/packages/thesmarter/tafqeet
[php-image]: https://img.shields.io/badge/PHP-8.1%2B-blue?style=flat-square
[php-url]: https://www.php.net/manual/en/intro.php
[license-image]: https://img.shields.io/packagist/l/thesmarter/tafqeet.svg?style=flat-square
[license-url]: https://packagist.org/packages/thesmarter/tafqeet
[build-image]: https://img.shields.io/github/actions/workflow/status/thesmarter/tafqeet/ci.yml?branch=main&style=flat-square
[build-url]: https://github.com/thesmarter/tafqeet/actions
[downloads-image]: https://img.shields.io/packagist/dt/thesmarter/tafqeet.svg?style=flat-square
[downloads-url]: https://packagist.org/packages/thesmarter/tafqeet
[github-image]: https://img.shields.io/badge/GitHub-thesmarter%2Ftafqeet-blue?style=flat-square&logo=github
[github-url]: https://github.com/thesmarter/tafqeet
