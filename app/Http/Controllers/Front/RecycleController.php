<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreOverTimeRequest;
use App\Models\Parents;
use App\Models\RecyclePlace;
use App\Models\RecycleProduct;
use App\Models\RecycleProductApplyStatus;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Session;

class RecycleController extends Controller
{
    protected $recycleProduct;

    protected $parent;

    protected $recycleProductApplyStatus;

    protected $recyclePlace;


    public function __construct(
        RecycleProduct $recycleProduct,
        RecycleProductApplyStatus $recycleProductApplyStatus,
        Parents $parent,
        RecyclePlace $recyclePlace
    )
    {
        $this->recycleProduct = $recycleProduct;
        $this->recycleProductApplyStatus = $recycleProductApplyStatus;
        $this->parent = $parent;
        $this->recyclePlace = $recyclePlace;
    }

    public function notice()
    {
        Log::info('[RecycleController.index] Start...');
        $parent = Auth::guard('parents')->user();
        $provides = $this->recycleProduct->whereHas('applyStatus', function ($q) use ($parent) {
            $q->where('apply_status', 1)->where('user_id', $parent->id);
        })->where('status', '<', '5')
            ->where('status', '<>', '0')
            ->where('school_id', getSchool()->id)
            ->where('recycle_products.updated_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->get();
        $list = $this->recycleProduct
            ->where('status', '!=', 0)
            ->where('status', '!=', 5)
            ->where('user_id', $parent->id)
            ->where('school_id', getSchool()->id)
            ->where('updated_at', '>', Carbon::now()->subMonth()->toDateTimeString())
            ->get();
        Log::info('[RecycleController.index] End...');

        return view('front.recycles.notice', compact('provides', 'list'));
    }

    public function provide()
    {
        Log::info('[RecycleController.provide] Start...');
        $parent = Auth::guard('parents')->user();

        $list = $this->recycleProduct
            ->where('status', '!=', 0)
            ->where('status', '!=', 5)
            ->where('school_id', getSchool()->id)
            ->where('user_id', $parent->id)
            ->where('updated_at', '>', Carbon::now()->subMonth()->toDateTimeString())
            ->get();

        Log::info('[RecycleController.index] End...');
        return view('front.recycles.product_provide', compact('list'));
    }

    public function cancelProvide($id)
    {
        Log::info('[RecycleController.cancelProvide] Start...');
        $recycleProduct = $this->recycleProduct->find($id);
        \DB::transaction(function () use ($recycleProduct) {
            $recycleProduct->status = 1;
            $recycleProduct->save();

            $recycleProductApplyStatus = $this->recycleProductApplyStatus->where('recycle_product_id', $recycleProduct->id)->first();
            if (!is_null($recycleProductApplyStatus)) {
                $recycleProductApplyStatus->apply_status = 0;
                $recycleProductApplyStatus->save();
            }
        });
        Log::info('[RecycleController.cancelProvide] End...');

        return view('front.recycles.cancel-provide');
    }

    public function confirmProvide($id)
    {
        Log::info('[RecycleController.confirmProvide] Start...');
        $product = $this->recycleProduct->find($id);
        Log::info('[RecycleController.confirmProvide] End...');
        return view('front.recycles.confirm-provide', compact('product'));
    }

    public function confirmProvidePost($id)
    {
        Log::info('[RecycleController.confirmProvidePost] Start...');
        $product = $this->recycleProduct->find($id);
        \DB::transaction(function () use ($product) {
            $product->status = 4;
            $product->save();
        });
        Log::info('[RecycleController.confirmProvidePost] Start...');
        return view('front.recycles.confirm_provide_success');
    }

    public function deleteProvide($id)
    {
        Log::info('[RecycleController.deleteProvide] Start...');
        $recycleProduct = $this->recycleProduct->find($id);
        \DB::transaction(function () use ($recycleProduct) {
            $recycleProduct->status = 0;
            $recycleProduct->save();
        });
        Log::info('[RecycleController.deleteProvide] End...');

        return view('front.recycles.delete-provide');
    }

    public function listProvide()
    {
        Log::info('[RecycleController.listProvide] Start...');
        $parent = Auth::guard('parents')->user();
        $provides = $this->recycleProduct->whereHas('applyStatus', function ($q) use ($parent) {
            $q->where('user_id', $parent->id);
        })->where('status', '5')
            ->where('school_id', getSchool()->id)
            ->where('recycle_products.updated_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->get();
        Log::info('[RecycleController.listProvide] End...');
        return view('front.recycles.list_provide', compact('provides'));
    }

    public function listReceive()
    {
        Log::info('[RecycleController.listReceive] Start...');
        $parent = Auth::guard('parents')->user();
        $lists = $this->getRecycleProduct(5, Carbon::now()->subMonth()->toDateTimeString(), $parent->id);
        Log::info('[RecycleController.listReceive] End...');
        return view('front.recycles.list_receive', compact('lists', $lists));
    }

    public function productDelete()
    {
        Log::info('[RecycleController.productDelete] Start...');
        $parent = Auth::guard('parents')->user();
        $product_deletes = $this->getRecycleProduct(0, Carbon::now()->subMonth()->toDateTimeString(), $parent->id);
        Log::info('[RecycleController.productDelete] End...');
        return view('front.recycles.product_delete', compact('product_deletes'));
    }

    public function productRegister()
    {
        Log::info('[RecycleController.productRegister] Start...');
        $parent = Auth::guard('parents')->user();;
        $provides = $this->recycleProduct->whereHas('applyStatus', function ($q) use ($parent) {
            $q->where('apply_status', 1)
                ->where('user_id', $parent->id);
        })->where('status', '<', '5')
            ->where('status', '<>', '0')
            ->where('school_id', getSchool()->id)
            ->where('recycle_products.updated_at', '>=', Carbon::now()->subMonth()->toDateTimeString())->get();

        $lists = $this->recycleProduct->getRecycleHasPlace($parent, Carbon::now()->subMonth()->toDateTimeString());
        Log::info('[RecycleController.productRegister] Start...');
        return view('front.recycles.product_register', compact('provides', 'lists'));
    }

    public function showProduct($id)
    {
        Log::info('[RecycleController.showProduct] Start...');
        $recycleProduct = $this->recycleProduct->find($id);
        Log::info('[RecycleController.showProduct] End...');
        return view('front.recycles.show', compact('recycleProduct'));
    }

    public function apply(Request $request, $id)
    {
        Log::info('[RecycleController.apply] Start...');
        $user = Auth::guard('parents')->user();
        DB::transaction(function () use ($user, $id) {
            $recycleProduct = $this->recycleProduct->find($id);
            $recycleProduct->status = $this->recycleProduct::WAITING_BRING;
            $recycleProduct->save();

            $recycleProductApplyStatus = $this->recycleProductApplyStatus->where('recycle_product_id', $recycleProduct->id)->first();
            if (!$recycleProductApplyStatus) {
                $recycleProductApplyStatus = $this->recycleProductApplyStatus;
                $recycleProductApplyStatus->recycle_product_id = $recycleProduct->id;
                $recycleProductApplyStatus->user_id = $user->id;

            }

            $recycleProductApplyStatus->apply_status = 1;
            $recycleProductApplyStatus->save();
        });
        Log::info('[RecycleController.apply] End...');

        return view('front.recycles.apply');
    }

    public function productCreate()
    {
        Log::info('[RecycleController.productCreate] Start...');
        return view('front.recycles.create');
    }

    public function productEdit($id)
    {
        Log::info('[RecycleController.productEdit] Start...');
        $recycle = $this->recycleProduct->find($id);
        $listImg = $recycle->getImageUrl();
        Log::info('[RecycleController.productEdit] End...');

        return view('front.recycles.edit', compact('recycle', 'listImg'));
    }

    public function productStore(Request $request)
    {
        Log::info('[RecycleController.productStore] Start...');
        $validatedData = $request->validate([
            'product.images' => 'required|array',
            'product.images.*' => 'required|mimes:jpeg,bmp,png|max:10230',
            'product.product_status' => 'required|numeric|between:1,6',
            'product.detail' => 'required|string',
            'product.name' => 'required|string',
        ]);

        $productData = Arr::except($validatedData['product'], ['images']);

        // Normalize array index.
        $fileArr = $validatedData['product']['images'];

        $fileArr = array_combine(range(1, count($fileArr)), array_values($fileArr));

        foreach ($fileArr as $idx => $file) {
            $productData["image" . $idx] = $file->hashName();
        }

        $productData['school_id'] = Session::get('school_id');

        $productData['user_id'] = Auth::guard('parents')->user()->id;

        // Todo: Remove transaction
        // Decouple logic of saving file info from uploading proccesses.
        // To speed up time of responding requests.
        \DB::transaction(function () use ($productData, $fileArr) {
            $recyclePlace = RecyclePlace::where('school_id', Session::get('school_id'))->first();
            if ($recyclePlace) {
                $productData['recycle_place_id'] = $recyclePlace->id;
            }else{
                $productData['recycle_place_id'] = 0;
            }
            $recycleProduct = RecycleProduct::create($productData);
            event(new \App\Events\FileInfoSavedToDatabase($recycleProduct, $fileArr));
        });
        Log::info('[RecycleController.productStore] End...');

        return redirect()->route('recycle.product.sent');
    }

    public function productUpdate(Request $request, $id)
    {
        Log::info('[RecycleController.productUpdate] Start...');
        $validatedData = $request->validate([
            'product.images' => 'required|array',
//            'product.images.*' => 'sometimes|file|mimes:jpeg,bmp,png|max:2046',
            'product.product_status' => 'required|numeric|between:1,6',
            'product.detail' => 'required|string',
            'product.name' => 'required|string',
        ]);

        $recycleProduct = $this->recycleProduct->select(DB::raw('image1, image2, image3, image4, image5'))->where('id', $id)->first();
        $uploadDataArray = [];
        $images = $request->all()['product']['images'];
        $fileArr = [];
        foreach ($recycleProduct->toArray() as $key => $value) {
            if (in_array($key, $images)) {
                $uploadDataArray[$key] = $value;
            } else {
                $uploadDataArray[$key] = NULL;
                foreach ($images as $idx => $item) {
                    if ($item instanceof UploadedFile && is_null($uploadDataArray[$key])) {
                        $uploadDataArray[$key] = $item->hashName();
                        array_push($fileArr, $item);
                        unset($images[$idx]);
                    }
                }
            }
        }
        $productData['name'] = $validatedData['product']['name'];
        $productData['status'] = $validatedData['product']['product_status'];
        $productData['detail'] = $validatedData['product']['detail'];
        $productData = array_merge($productData, $uploadDataArray);
        $recycleProduct = $this->recycleProduct->find($id);


        // Todo: Remove transaction
        // Decouple logic of saving file info from uploading proccesses.
        // To speed up time of responding requests.
        \DB::transaction(function () use ($recycleProduct, $productData, $fileArr) {
            $recycleProduct->update($productData);
            event(new \App\Events\FileInfoSavedToDatabase($recycleProduct, $fileArr));
        });
        Log::info('[RecycleController.productUpdate] End...');

        return redirect()->route('recycle.product.complete');

    }

    public function productComplete()
    {
        Log::info('[RecycleController.productComplete] Start...');
        return view('front.recycles.complete');
    }

    public function UpdateComplete()
    {
        Log::info('[RecycleController.UpdateComplete] Start...');
        return view('front.recycles.completeUpdate');
    }

    public function getRecycleProduct($status, $updated_at, $user_id)
    {
        Log::info('[RecycleController.getRecycleProduct] Start...');
        return $this->recycleProduct->where('status', $status)
            ->where('updated_at', '>=', $updated_at)
            ->where('school_id', getSchool()->id)
            ->where('user_id', $user_id)->get();
    }

    public function confirmRegister($id)
    {
        Log::info('[RecycleController.confirmRegister] Start...');
        $recycle = $this->recycleProduct->find($id);
        Log::info('[RecycleController.confirmRegister] End...');
        return view('front.recycles.comfirm_recycle', compact('recycle'));
    }

    public function confirmRecycle($id)
    {
        Log::info('[RecycleController.confirmRecycle] Start...');
        $recycle = $this->recycleProduct->find($id);
        $recycle->status = 5;
        $recycle->update();
        Log::info('[RecycleController.confirmRecycle] End...');

        return view('front.recycles.complete');
    }

    public function dateCarry($id)
    {
        Log::info('[RecycleController.dateCarry] Start...');
        $product = $this->recycleProduct->find($id);
        $listPlace = $this->recyclePlace->getListPlaceBySchool(getSchool()->id);
        Log::info('[RecycleController.dateCarry] End...');

        return view('front.recycles.confirm_date_carry', compact('product', 'listPlace'));
    }

    public function confirmDateCarry(StoreOverTimeRequest $request, $id)
    {
        Log::info('[RecycleController.confirmDateCarry] Start...');
        $data = $request->all();
        Log::info('[RecycleController.confirmDateCarry] Start...');
        return view('front.recycles.date_carry', compact('data', 'id'));
    }

    public function successDateCarry(Request $request, $id)
    {
        Log::info('[RecycleController.successDateCarry] Start...');
        $data = $request->all();
        $product = $this->recycleProduct->find($id);
        \DB::transaction(function () use ($product, $data) {
            $product->status = 3;
            $product->carrying_from_datetime = $data['carrying_from_datetime'] . ' ' . $data['carrying_from_datetime_hour'];
            $product->carrying_to_datetime = $data['carrying_to_datetime'] . ' ' . $data['carrying_to_datetime_hour'];
            $product->recycle_place_id = $data['recycle_place_id'];
            $product->save();
        });
        Log::info('[RecycleController.successDateCarry] Start...');
        return view('front.recycles.success_date_carry');
    }

    public function listPlace($id)
    {
        Log::info('[RecycleController.listPlace] Start...');
        $lists = $this->recyclePlace->where('school_id', $id)->get();
        Log::info('[RecycleController.listPlace] End...');

        return view('front.recycles.list_place', compact('lists'));
    }

    public function showPlace($id)
    {
        Log::info('[RecycleController.showPlace] Start...');
        $recycle = $this->recycleProduct->find($id);
        $recycle_place = $this->recyclePlace->find($recycle->recycle_place_id);
        Log::info('[RecycleController.showPlace] End...');

        return view('front.recycles.show_place', compact('recycle_place'));
    }


}
