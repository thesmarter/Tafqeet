# تافقيط [![إصدار Packagist][packagist-image]][packagist-url] [![PHP 8.1+][php-image]][php-url] [![الرخصة][license-image]][license-url] [![CI][build-image]][build-url] [![إجمالي التحميلات][downloads-image]][downloads-url]

> تحويل الأرقام إلى كلمات عربية – مكتبة PHP لتحويل المبالغ المالية إلى نصوص باللغة العربية

---

## 📖 ما هو تافقيط؟

**تافقيط** هي مكتبة PHP تساعدك على دمج عمليات الدفع والإيصالات المالية داخل مشاريعك عن طريق تحويل المبالغ إلى كلمات باللغة العربية. تتيح لك إضافة هذه الكلمات في أي مكان تريده.

**مثال:**

```php
use thesmarter\Tafqeet\Core\Tafqeet;

echo Tafqeet::arablic(3150.9);
// المخرج: فقط ثلاثة آلاف ومائة وخمسون ريالاً وتسعة هللات لاغير
```

---

## 🚀 التثبيت

### عبر Composer (موصى به)

```bash
composer require thesmarter/tafqeet
```

[![Packagist][packagist-image]][packagist-url]

### التثبيت اليدوي

1. حمّل المستودع أو انسخ مجلد `src/` إلى مشروعك
2. أضف التحميل التلقائي في `composer.json`:

```json
"autoload": {
    "psr-4": {
        "thesmarter\\Tafqeet\\": "path/to/tafqeet/src/"
    }
}
```

3. شغّل:

```bash
composer dump-autoload
```

---

## ⚡ الاستخدام

### تحويل رقم إلى كلمات عربية

```php
use thesmarter\Tafqeet\Core\Tafqeet;

// استخدام بسيط (العملة الافتراضية: ريال سعودي)
echo Tafqeet::arablic(3150.9);
// المخرج: فقط ثلاثة آلاف ومائة وخمسون ريالاً وتسعة هللات لاغير

// تحديد عملة مخصصة
echo Tafqeet::arablic(1500.50, 'usd');
echo Tafqeet::arablic(500.25, 'sdg');
```

### استخدام الكائن مباشرة

```php
use thesmarter\Tafqeet\Core\Tafqeet;

$tafqeet = new Tafqeet(123456.78);
echo $tafqeet->toWords('sar');
```

### التعامل مع الأخطاء

```php
use thesmarter\Tafqeet\Core\Tafqeet;
use thesmarter\Tafqeet\Exception\TafqeetException;

try {
    echo Tafqeet::arablic('رقم غير صحيح');
} catch (TafqeetException $e) {
    echo 'خطأ: ' . $e->getMessage();
}
```

---

## 📊 العملات المدعومة

| الرمز | العملة الأساسية | العملة الفرعية | الجمع |
|-------|-----------------|----------------|-------|
| `sar` | ريال | هللة | هللات |
| `sdg` | قرش | قرش | قروش |
| `usd` | دولار | سنت | سنت |

يمكنك بسهولة إضافة عملات جديدة عن طريق تعديل الثابت `CURRENCIES` داخل الكلاس.

---

## 🔧 المتطلبات

- **PHP 8.1** أو أحدث
- [Composer](https://getcomposer.org/) (موصى به)

---

## 📋 أمثلة إضافية

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

## 🏗️ هيكل المشروع

```
Tafqeet/
├── src/
│   ├── Core/
│   │   └── Tafqeet.php          # الكلاس الرئيسي
│   └── Exception/
│       └── TafqeetException.php  # استثناء مخصص
├── tests/                        # اختبارات
├── test.php                      # مثال تشغيل سريع
├── composer.json
├── phpunit.xml
└── README.md
```

---

## 🤍 المساهمة

المساهمات مرحب بها! لا تتردد في فتح **Issue** أو **Pull Request**.

1. Fork المشروع
2. أنشئ فرعًا للميزة (`git checkout -b feature/amazing-feature`)
3. Commit التغييرات (`git commit -m 'Add amazing feature'`)
4. ادفع الفرع (`git push origin feature/amazing-feature`)
5. افتح Pull Request

---

## 📄 الرخصة

مرخصة تحت رخصة **MIT**. راجع ملف [LICENSE](LICENSE) لمزيد من التفاصيل.

---

## 🔗 روابط مفيدة

[![Packagist][packagist-image]][packagist-url]
[![GitHub][github-image]][github-url]

---

## ⚠️ ملاحظة

تعمل المكتبة حاليًا للأرقام حتى **999999.99**.

---

<!-- روابط الشارات -->
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
