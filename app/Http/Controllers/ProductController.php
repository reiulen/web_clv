<?php

namespace App\Http\Controllers;

use App\Models\Icons;
use App\Models\Product;
use App\Models\ViewProduct;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\DetailProduct;
use App\Models\SummaryProduct;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.product.create-update');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = $request->all();
        $request->validate([
            'name' => 'required',
            'summaryDetail' => 'required',
            'location' => 'required',
            'status' => 'required',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $summaryDetail = explode(' ', $request->summaryDetail);
        $detailProduct = explode(' ', $request->detailProduct);
        $input['slug'] = Str::slug($request->name);

        if($request->hasFile('foto')) $input['foto'] = upload_image($request->file('foto'), 'Product', Str::slug($request->name));

        $product = Product::create($input);

        $summaryDetailData = SummaryProduct::whereIn('id', $summaryDetail)
                                            ->get();

        $detailProductData = DetailProduct::whereIn('id', $detailProduct)
                                            ->get();

        foreach($summaryDetailData as $data) {
            $data->product_id = $product->id;
            $data->save();
        }

        foreach($detailProductData as $data) {
            $data->product_id = $product->id;
            $data->save();
        }

        return redirect(route('product.index'))
                ->with('success', 'Data berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = Product::with('detailProduct', 'summaryProduct')
                            ->findOrFail($id);

        $detailProduct = implode(' ', $data->detailProduct->pluck('id')->toArray());
        $summaryProduct = implode(' ', $data->summaryProduct->pluck('id')->toArray());

        return view('admin.product.create-update', compact('data', 'detailProduct', 'summaryProduct'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $input = $request->all();
        $product = Product::findOrFail($id);
        $request->validate([
            'name' => 'required',
            'summaryDetail' => 'required',
            'location' => 'required',
            'status' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $summaryDetail = explode(' ', $request->summaryDetail);
        $detailProduct = explode(' ', $request->detailProduct);
        $input['slug'] = Str::slug($request->name);

        if($request->hasFile('foto')) {
            $input['foto'] = upload_image($request->file('foto'), 'Product', Str::slug($request->name));
            File::delete($product->foto);
        }

        $product->update($input);

        $summaryDetailData = SummaryProduct::whereIn('id', $summaryDetail)
                                            ->get();

        $detailProductData = DetailProduct::whereIn('id', $detailProduct)
                                            ->get();

        foreach($summaryDetailData as $data) {
            $data->product_id = $product->id;
            $data->save();
        }

        foreach($detailProductData as $data) {
            $data->product_id = $product->id;
            $data->save();
        }

        return redirect(route('product.index'))
                ->with('success', 'Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Product::with('detailProduct', 'summaryProduct')
                            ->find($id);
        if(!$data) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }

        if(count($data->detailProduct) > 0)
            foreach($data->detailProduct as $detail) {
                File::delete($detail->foto);
                $detail->delete();
            }

        if(count($data->summaryProduct) > 0)
            foreach($data->summaryProduct as $summary) {
                $summary->delete();
            }

        if($data->foto) File::delete($data->foto);
        $data->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil dihapus'
        ]);
    }

    public function dataTable(Request $request)
    {
        $data = Product::select('id', 'name', 'status', 'created_at', 'slug')
                        ->with('views:id,views,product_id')
                        ->latest()
                        ->filter($request);

        return DataTables::of($data)
                            ->addindexColumn()
                           ->addColumn('content', function($data) {
                                $status = '';
                                switch($data->status) {
                                    case 1 :
                                        $status = "<div class='badge badge-primary py-2 px-3 rounded-md' style='border-radius: 20px'>
                                                        Publish
                                                    </div>";
                                        break;
                                    case 2 :
                                        $status = "<div class='badge badge-danger py-2 px-3 rounded-md' style='border-radius: 20px'>
                                                        Draft
                                                    </div>";
                                        break;
                                }
                                $content = "<div class='row align-items-center'>
                                                <div class='col-md-4'>
                                                    <a href='".route('product.edit', $data->id)."' class='text-dark hover-underline'>
                                                        <h6>
                                                            $data->name
                                                        </h6>
                                                    </a>
                                                </div>
                                                <div class='col-md-2 ml-auto d-flex flex-column text-left'>
                                                    <span>Created At</span>
                                                    <strong>".date('Y-m-d', strtotime($data->created_at))."</strong>
                                                </div>
                                                <div class='col-md-2 ml-auto'>
                                                    $status
                                                </div>
                                                <div class='col-md-1 ml-auto text-right'>
                                                    <i class='fas fa-eye pr-1'></i>
                                                   ".($data->views->sum('views') ?? 0)."
                                                </div>
                                                <div class='col-md-1'>
                                                    <button class='btn btn-none' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        <i class='fas fa-ellipsis-v'></i>
                                                    </button>
                                                    <div class='dropdown-menu dropdown-menu-right border-0' aria-labelledby='dropdownMenuButton'>
                                                        <a class='dropdown-item' href='".env('FRONT_URL')."/product/$data->slug' target='_blank'>
                                                            <i class='fas fa-eye text-primary pr-1'></i>
                                                            Pratijau
                                                        </a>
                                                        <a class='dropdown-item' href='".route('request-brosur.index')."?product=$data->id'>
                                                            <i class='fas fa-sticky-note text-success pr-1'></i>
                                                            Request Brosur
                                                        </a>
                                                        <a class='dropdown-item' href='".route('product.edit', $data->id)."'>
                                                            <i class='fas fa-pencil-alt text-success pr-1'></i>
                                                            Ubah
                                                        </a>
                                                        <div role='button' class='dropdown-item btn-hapus' data-id='$data->id' data-title='$data->title'>
                                                            <i class='fas fa-trash text-danger pr-1'></i>
                                                            Hapus
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                                return $content;
                           })->rawColumns(['content'])
                           ->smart(true)
                           ->make(true);

    }

    public function summaryDetailStore(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'icon' => 'required',
            'name' => 'required',
            'detail' => 'required',
        ]);

        if($validator->fails())
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);

        if(isset($request->product_id))
            $input['product_id'] = $request->product_id;

        $data = SummaryProduct::create($input);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
            'data' => $data->id
        ]);
    }

    public function summaryDetailDelete($id)
    {
        $data = SummaryProduct::find($id);
        if(isset($data)) {
            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus'
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function summaryDataTable(Request $request)
    {
        $summaryDetail = $request->summaryDetail;
        $data_id = explode(' ', $summaryDetail);

        $data = SummaryProduct::select('id', 'icon', 'name', 'detail', 'product_id')
                                ->with('icons:id,icon')
                                ->whereIn('id', $data_id)
                                ->latest();

        return DataTables::of($data)
                            ->addindexColumn()
                           ->addColumn('content', function($data) {
                                $content = "<div class='row align-items-start'>
                                                <div class='col-md-5'>
                                                    <div role='button' class='text-dark hover-underline'>
                                                        <div class=''>
                                                            <h6>
                                                                <i class='".$data->icons->icon." align-middle pr-2'></i>
                                                                $data->name
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-md-5 d-flex flex-column text-left'>
                                                    $data->detail
                                                </div>
                                                <div class='col-md-2'>
                                                    <div role='button' data-id='$data->id'
                                                        data-title='$data->name'
                                                        data-sumber='summary'
                                                        class='d-inline-block px-2 py-1 btn-sm text-center btn-trash bg-danger'>
                                                        <i class='fas fa-trash'></i>
                                                    </div>
                                                </div>
                                            </div>";
                                return $content;
                           })->rawColumns(['content'])
                           ->smart(true)
                           ->make(true);

    }

    public function detailStore(Request $request)
    {

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if($validator->fails())
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);


        if($request->hasFile('foto')){
            $input['foto'] = upload_image($request->file('foto'), 'Product', Str::slug($request->name));
        }

        if(isset($request->product_id))
            $input['product_id'] = $request->product_id;

        $data = DetailProduct::create($input);

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
            'data' => $data->id
        ]);
    }

    public function detailDelete($id)
    {
        $data = DetailProduct::find($id);
        if(isset($data)) {
            if($data->foto)
                File::delete($data->foto);

            $data->delete();
            return response()->json([
                'status' => 'success',
                'message' => 'Data berhasil dihapus'
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
        }
    }

    public function detailDataTable(Request $request)
    {
        $detailProduct = $request->detailProduct;
        $data_id = explode(' ', $detailProduct);

        $data = DetailProduct::select('id', 'name', 'foto', 'detail')
                                ->whereIn('id', $data_id)
                                ->latest();

        return DataTables::of($data)
                            ->addindexColumn()
                           ->addColumn('content', function($data) {
                                $content = "<div class='row align-items-start'>
                                                <div class='col-md-5'>
                                                    <div role='button' class='text-dark hover-underline'>
                                                        <div class='d-flex align-items-center'>
                                                            <div class='mr-2'>
                                                                <img src='".asset($data->foto)."' class='img-fluid w-100' style='height: 50px; object-fit: cover;'>
                                                            </div>
                                                            <h6>
                                                                $data->name
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-md-5 d-flex flex-column text-left'>
                                                    $data->detail
                                                </div>
                                                <div class='col-md-2'>
                                                    <div role='button' data-id='$data->id'
                                                        data-title='$data->name'
                                                        data-sumber='detail'
                                                        class='d-inline-block px-2 py-1 btn-sm text-center btn-trash bg-danger'>
                                                        <i class='fas fa-trash'></i>
                                                    </div>
                                                </div>
                                            </div>";
                                return $content;
                           })->rawColumns(['content'])
                           ->smart(true)
                           ->make(true);

    }


    public function getAll(Request $request)
    {
        $data = Product::select('id', 'name', 'foto', 'slug',
                                'status', 'type_product', 'location', 'description','created_at')
                        ->with('summaryProduct:id,product_id,name,icon,detail', 'summaryProduct.icons:id,icon')
                        ->where('status', 1)
                        ->latest();

        if(isset($request->paginate))
            $data = $data->paginate($request->paginate)->toArray();

        if(isset($request->limit))
            $data = $data->limit($request->limit)->get();

        if(empty($request->paginate) && empty($request->limit))
            $data = $data->get();

        return response()->json([
            'data' => $data
        ]);
    }

    public function getDetail(Request $request, $slug)
    {
        $data = Product::with('summaryProduct:id,product_id,name,icon,detail', 'summaryProduct.icons:id,icon', 'detailProduct')
                        ->firstWhere([ 'slug' => $slug, 'status' => 1]);
        if($data) {
            $dateNow = date('Y-m-d');
            $view = ViewProduct::where(['date' => $dateNow, 'product_id' => $data->id])->first() ?? new ViewProduct;
            $view->views = ($view->views ?? 0) + 1;
            $view->product_id = $data->id;
            $view->date = $dateNow;
            $view->save();
        }

        return response()->json($data);
    }
}
