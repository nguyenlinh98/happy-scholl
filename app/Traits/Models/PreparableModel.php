<?php

namespace App\Traits\Models;

trait PreparableModel
{
    public function prepare($overrides = [])
    {
        $filled = [];
        foreach ($this->fillable as $fillableAttribute) {
            $filled[] = [
                'field_name' => $fillableAttribute,
                'value' => old($fillableAttribute, $this->{$fillableAttribute}),
            ];
            $this->{$fillableAttribute} = old($fillableAttribute, $this->{$fillableAttribute});
        }
        hsp_debug('filled valued', $filled);
        if (count($overrides) > 0) {
            foreach ($overrides as $override => $value) {
                // logger('override', [$override, $value]);
                $this->{$override} = $value;
            }
        }
    }
}
