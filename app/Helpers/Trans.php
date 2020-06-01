<?php
/**
 * User: JohnAVu
 * Date: 2019-12-19
 * Time: 14:16
 */

namespace App\Helpers;

use Illuminate\Support\Facades\Cache;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Trans
{
    protected $target;

    protected $trans;

    public function setTarget($target)
    {
        $this->target = $target;
        return $this;
    }

    public function get($text)
    {
        if (!$text) {
            return $text;
        }
        if (Cache::has($this->target . '.' . $text)) {
            return Cache::get($this->target . '.' . $text);
        }
        if (!$this->trans instanceof GoogleTranslate) {
            $this->trans = new GoogleTranslate();
        }
        $transText = $this->trans->setTarget($this->target)->translate($text);
        Cache::put($this->target . '.' . $text, $transText);
        return $transText;
    }
}