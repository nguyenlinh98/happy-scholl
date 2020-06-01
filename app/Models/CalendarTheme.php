<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Database\Eloquent\SoftDeletes;

class CalendarTheme extends Model
{
    // use SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];
    protected $table = 'user_calendar_themes';
    const TYPE_DEFAULT = 'default';
    const TYPE_SELECT = 'select';
    const TYPE_ORIGINAL = 'original';

    //Add relationships if need
    public function getBackGroupImg()
    {
         if($this->background_image)
         {
              return asset($this->background_image);
         }
    }
    public function getListArrImg()
    {
        $listArrImage = [];
        if($this->image1 && file_exists(public_path('storage/uploads/'. $this->image1))) {
            array_push($listArrImage, asset('storage/uploads/' . $this->image1));
        }
        if($this->image2 && file_exists(public_path('storage/uploads/'. $this->image2))) {
            array_push($listArrImage, asset('storage/uploads/' . $this->image2));
        }
        if($this->image3 && file_exists(public_path('storage/uploads/'. $this->image3))) {
            array_push($listArrImage, asset('storage/uploads/' . $this->image3));
        }
         return $listArrImage;
    }
}
