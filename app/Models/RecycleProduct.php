<?php

namespace App\Models;

use App\Traits\Models\GetConstantsTrait;
use App\Traits\Models\HasImagesTrait;
use App\Traits\Models\LocalizeDateTimeTrait;
use App\Traits\Models\PreparableModel;
use App\Traits\Models\SchoolScopeTrait;
use Exception;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
//use function foo\func;

class RecycleProduct extends Model
{
    use LocalizeDateTimeTrait;
    use GetConstantsTrait;
    use PreparableModel;
    use SchoolScopeTrait;
    use HasImagesTrait;

    const TOTAL_IMAGES = 5;

    const DELETE = 0;
    const SELLING = 1;
    const WAITING_BRING = 2;
    const WAITING_CARRY = 3;
    const WAITING_RECEIPT = 4;
    const COMPLETED = 6;

    const PAGE_SIZE = 12;
    const PRODUCT_STATUS_NEW = 1; // 新品、未使用
    const PRODUCT_STATUS_LIKE_NEW = 2; // 未使用に近い
    const PRODUCT_STATUS_FAIRY_NEW = 3;  // 目立った傷や汚れあり
    const PRODUCT_STATUS_USED = 4;  //やや傷や汚れあり
    const PRODUCT_STATUS_WEAR_OUT = 5; // 傷や汚れあり
    const PRODUCT_STATUS_BAD_CONDITION = 6;  // 全体的に状態が悪い

    const STATUS_DELETE = 0; // 削除
    const STATUS_SELLING = 1; // 出品中
    const STATUS_WAITING_BRING = 2; // 持込予定待ち
    const STATUS_WAITING_CARRY = 3; // 持込待ち
    const STATUS_WAITING_RECEIPT = 4; // 受取待ち
    const STATUS_COMPLETED = 5; // 受け取り完了

    protected $fillable = ['detail', 'product_status', 'school_id', 'status', 'user_id', 'carrying_from_datetime', 'carrying_to_datetime', 'recycle_place_id', 'name', 'image1', 'image2', 'image3', 'image4', 'image5'];

    protected $table = 'recycle_products';

    protected $guarded = [];

    public function applyStatus()
    {
        return $this->hasMany(RecycleProductApplyStatus::class, 'recycle_product_id');
    }

    public function getSellingProduct($schoolId, $userId, $page = 1)
    {
       return $this->select('recycle_products.*')
            ->leftJoin('recycle_apply_statuses', 'recycle_products.id', '=', 'recycle_apply_statuses.recycle_product_id')
            ->where(function ($q) use($userId, $schoolId) {
                $q->where(function ($query) use ($schoolId) {
                    $query->where('status', 1)
                        ->where('school_id', $schoolId);
                })->where(function ($query) use ($userId) {
                    $query->where('recycle_apply_statuses.apply_status', '<>', 0)
                        ->where('recycle_apply_statuses.user_id', $userId);
                });
            })->orWhere(function ($q) use ($schoolId){
               $q->where('status', 1)
                   ->where('school_id', $schoolId);
           })->whereNotIn('recycle_products.id', function($query) use ($userId){
               $query->select('recycle_product_id')
                   ->from('recycle_apply_statuses')
                   ->where('user_id', $userId);
           })->orderBy('created_at', 'DESC')->paginate(self::PAGE_SIZE, ['*'], 'page', $page);
    }


    /**
     * Relation to model App\Models\User
     * by column 'user_id'.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get parent model from user_id.
     */
    public function parents()
    {
        return $this->belongsTo(Parents::class, 'user_id');
    }

    /**
     * Relation to model App\Models\RecyclePlace
     * by column 'recycle_place_id'.
     */
    public function recyclePlace()
    {
        return $this->belongsTo(RecyclePlace::class);
    }

    public function getThumbnailImage()
    {
        $listImg = $this->getImageUrl();
        if (empty($listImg)) {
            return asset('images/front/thumb-reload.png');
        }
        foreach ($listImg as $img) {
            return $img;
        }
    }

    public function getImageUrl()
    {
        $urls = [];

        for ($idx = 1; $idx <= 5; ++$idx) {
            $attribute = "image$idx";

            if (!$this->$attribute) {
                continue;
            }
//            $urls[] = rotate_image(public_path('storage/uploads/' . $this->getTable() . '/' . $this->id . '/' . 'images/' . $this->$attribute));

            // $urls[] = \Storage::disk('public')->url('uploads/'.$this->getTable().'/'.$this->id.'/'.'images/'.$this->$attribute);
            $urls[] = asset('storage/uploads/'.$this->getTable().'/'.$this->id.'/'.'images/'.$this->$attribute);
        }

        return $urls;
    }

    /**
     * Get all image as array.
     */
    public function getImages()
    {
        $images = [];
        foreach (range(1, 5) as $index) {
            $image = data_get($this->attributes, 'image'.$index);
            if (filled($image)) {
                $images[] = $image;
            }
        }

        return $images;
    }

    /**
     * Prepare data for confirm view.
     *
     * @version 1.0.0
     */
    public function confirm(Request $request)
    {
        $this->name = $request->name;
        $this->detail = $request->input('detail');
        $this->product_status = $request->product_status;

        $this->confirmImages = $this->prepareImageForConfirm($request, 'images');
    }

    /**
     * Create new admin product.
     *
     * @version 1.0.0
     */
    public function createNewAdminProduct(Request $request)
    {
        $recyclePlace = hsp_school()->recyclePlaces()->first();
        $this->fill($request->only($this->fillable));
        $this->user_id = auth()->user()->id;
        $this->recycle_place_id = $recyclePlace ? $recyclePlace->id : 1;
        $this->is_admin = 1;
        // we need to save first in order to get id of current name
        $this->save();

        $this->saveImages($request, 'images_paths');

        // save again to update image path
        $this->save();
    }

    /**
     * Update admin  product.
     *
     * @version 1.1.0
     */
    public function updateAdminProduct(Request $request)
    {
        $this->fill($request->only($this->fillable));
        if ($request->filled('images_paths')) {
            $this->deleteImages();
            $this->saveImages($request, 'images_paths');
        }

        $this->save();
    }

    /**
     * Destroying product data and resources.
     *
     * if $strict is true, throw exception when $id not found
     *
     * @version 1.2.0
     */
    public static function destroyProductById(int $id, bool $strict = false)
    {
        $product = $strict ? self::findOrFail($id) : self::find($id);
        if ($product) {
            try {
                $product->clearImageFolder();
                $product->delete();

                return true;
            } catch (Exception $e) {
                logger()->error($e->getMessage());
            }
        }

        return false;
    }

    public function getStatusConstant()
    {
        return Str::after(
            array_search($this->status, $this->getPredefinedConstants('STATUS_')),
            'STATUS_');
    }

    public function getStatusClassAttribute()
    {
        return strtolower($this->getStatusConstant());
    }

    /**
     * Return image attribute from 1 to 5 as array
     * access by `image_array` attribute.
     *
     * @version 1.0.0
     */
    public function getImageArrayAttribute()
    {
        $imageArray = [];
        foreach (range(1, 5) as $index) {
            $imageAttribute = "image{$index}";
            $imageArray[$imageAttribute] = $this->$imageAttribute;
        }

        return $imageArray;
    }

    public function getRecycleHasPlace($parent, $updated_at)
    {
        return $this->with('recyclePlace')->whereHas('applyStatus', function ($q) use ($parent) {
            $q->where('user_id', $parent->id);
            $q->where('apply_status', 1);
        })->where('status', '<', '5')
            ->where('status', '<>', '0')
            ->where('recycle_products.updated_at', '>=', $updated_at)
            ->where('recycle_place_id', '<>', NULL)->get();
    }
}
