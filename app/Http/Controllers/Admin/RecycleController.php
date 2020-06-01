<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Recycle\CreateAdminRecycleProductRequest;
use App\Http\Requests\Admin\Recycle\UpdateAdminRecycleProductRequest;
use App\Models\RecyclePlace;
use App\Models\RecycleProduct;
use Illuminate\Http\Request;

class RecycleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recyclePlace = RecyclePlace::where('school_id', auth()->user()->school_id)->first();
        if (empty($recyclePlace)) {
            $recyclePlace = new RecyclePlace();
        }
        $recycleProducts = RecycleProduct::with(['parents', 'recyclePlace', 'parents.student'])->where('is_admin', false)->get();

        return view('admin.recycle.index', ['recyclePlace' => $recyclePlace, 'recycleProducts' => $recycleProducts]);
    }

    public function admin()
    {
        $recycleProducts = RecycleProduct::with(['user', 'recyclePlace'])->where('is_admin', true)->get();

        return view('admin.recycle.admin', ['recycleProducts' => $recycleProducts]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $recycleProduct = new RecycleProduct();
        $recycleProduct->prepare();

        return view('admin.recycle.create', ['recycleProduct' => $recycleProduct]);
    }

    public function confirm(CreateAdminRecycleProductRequest $request, RecycleProduct $recycleProduct = null)
    {
        if (is_null($recycleProduct)) {
            $recycleProduct = new RecycleProduct();
        }

        $recycleProduct->confirm($request);

        return view('admin.recycle.confirm')->with(['recycleProduct' => $recycleProduct]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CreateAdminRecycleProductRequest $request)
    {
        if ($request->filled('reject_x')) {
            // only on confirm
            // if user want to edit, redirect back to create page
            return redirect()->route('admin.recycle.create')->withInput();
        }

        $recycleProduct = new RecycleProduct();
        $recycleProduct->createNewAdminProduct($request);
        session()->flash('include', 'admin.recycle.modal.product-created');

        return redirect()->route('admin.recycle.admin');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(RecycleProduct $recycle)
    {
        $recycle->prepare();

        return view('admin.recycle.edit', ['recycleProduct' => $recycle]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateAdminRecycleProductRequest $request, RecycleProduct $recycle)
    {
        $recycle->updateAdminProduct($request);

        session()->flash('include', 'admin.recycle.modal.product-updated');

        return redirect()->route('admin.recycle.admin');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $result = RecycleProduct::destroyProductById($id);
        if (false === $result) {
            session()->flash('include', 'admin.recycle.modal.product-delete-failed');
        } else {
            session()->flash('include', 'admin.recycle.modal.product-deleted');
        }

        return redirect()->back();
    }

    public function massDelete(Request $request)
    {
        if ($request->filled('select_product')) {
            $failed = [];
            foreach ($request->input('select_product', []) as $productId) {
                $result = RecycleProduct::destroyProductById($productId);
                if (false === $result) {
                    $failed[] = $productId;
                }
            }
            if (count($failed) > 0) {
                logger()->warning('Something wrong when deleting products in ['.implode(', ', $failed).'], please check!!');
            }
            session()->flash('include', 'admin.recycle.modal.product-deleted');
        } else {
            session()->flash('include', 'admin.recycle.modal.product-delete-failed');
        }

        return redirect()->back();
    }
}
