<?php

namespace App\Traits\Models;

use Carbon\Carbon;

trait LocalizeDateTimeTrait
{
    protected $localizeDateTimeFormat = 'Y年M月D日（ddd）HH:mm';
    protected $localizeDateFormat = 'Y年M月D日（ddd）';
    protected $localizeTimeFormat = 'H:i';

    public function checkAttributeSupport(string $attributeName)
    {
        if (blank($this->attributes[$attributeName])) {
            return '';
        }
        $attribute = $this->attributes[$attributeName];

        if (is_object($attribute)) {
            if ('Carbon' === !class_basename($attribute)) {
                return "Unsupported class {$attributeName}";
            }
        }
        if (is_string($attribute)) {
            $attribute = Carbon::parse($attribute);
        }

        return $attribute;
    }

    public function toLocalizeDateTime(string $attributeName, $format = '')
    {
        $attribute = $this->checkAttributeSupport($attributeName);
        if (is_object($attribute)) {
            if ('' === $format) {
                return $attribute->locale('ja')->isoFormat($this->localizeDateTimeFormat);
            }

            return $attribute->format($format);
        }

        return $attribute;
    }

    public function toLocalizeDate(string $attributeName)
    {
        $attribute = $this->checkAttributeSupport($attributeName);
        if (is_object($attribute)) {
            return $attribute->locale('ja')->isoFormat($this->localizeDateFormat);
        }

        return $attribute;
    }

    public function toLocalizeTime(string $attributeName)
    {
        $attribute = $this->checkAttributeSupport($attributeName);
        if (is_object($attribute)) {
            return $attribute->locale('ja')->isoFormat($this->localizeTimeFormat);
        }

        return $attribute;
    }

    public function parseFromLocalizeDateTime(string $dateTime)
    {
        return Carbon::parse($dateTime);
    }

    public function parseFromJapaneseDateTime(string $dateTime)
    {
        return Carbon::createFromFormat('Y年m月d日 H:i', $dateTime);
    }

    public function parseFromLocalizeDate(string $dateTime)
    {
        return Carbon::createFromFormat('Y年m月d日', $dateTime);
    }
}
