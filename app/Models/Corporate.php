<?php

namespace App\Models;

use App\Traits\Models\PreparableModel as TraitsPreparableModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Corporate extends Model
{
    use TraitsPreparableModel;
    protected $fillable = [
        'name',
        'tel',
        'fax',
        'memo',
    ];

    public function makeFromRequest(Request $request)
    {
        $this->fill($request->all());
    }
}
