<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\RequestBrosur;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class RequestBrosurController extends Controller
{

    public function index(Request $request)
    {
        $product_id = $request->product;
        $product = null;
        if($product_id && intval($product_id)) {
            $product = Product::find($product_id);
            if(!$product)
                return redirect(route('product.index'));
        }
        return view('admin.request_brosur.index', compact('product'));
    }

    public function dataTable(Request $request)
    {
        $data = RequestBrosur::select('id', 'name', 'email', 'phone', 'product_id', 'created_at')
                                ->with('product:id,name,slug')
                                ->filter($request)
                                ->latest();

        return DataTables::of($data)
                            ->addindexColumn()
                           ->addColumn('action', function($data) {
                                $phone = $data->phone;
                                if(substr($data->phone, 0, 1) == '0') {
                                    $phone = str_replace('0', '62', $data->phone);
                                }
                                $data = "
                                <div class='d-flex align-items-center' style='gap: 5px;'>
                                    <a href='https://api.whatsapp.com/send?phone=$phone&text='
                                        target='_blank'
                                        class='d-inline-block px-2 py-1 rounded-sm text-center btn-success bg-success'>
                                        <i class='fab fa-whatsapp'></i>
                                    </a>
                                    <a href='mailto:$data->email'
                                        class='d-inline-block px-2 py-1 rounded-sm text-center btn-primary bg-primary'>
                                        <i class='fas fa-envelope'></i>
                                    </a>
                                </div>
                                ";
                                return $data;
                           })->addColumn('created_at', function($data) {
                                return date('d F Y', strtotime($data->created_at));
                           })->addColumn('product_name', function($data) {
                                $data = "
                                    <a target='_blank'
                                        class='hover-underline text-dark'
                                        href='".env('FRONT_URL')."/product/".$data->product->slug."'>
                                        ".$data->product->name."
                                    </a>
                                ";
                                return $data;
                           })
                           ->rawColumns(['action', 'product_name'])
                           ->smart(true)
                           ->make(true);

    }

    public function getStore(Request $request, $slug)
    {
        $product = Product::firstWhere('slug', $slug);
        if(!$product) {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan, mohon coba kembali'
            ]);
        }

        $input = $request->all();
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required|email|unique:request_brosurs,email',
            'phone' => 'required|unique:request_brosurs,phone|min:11|max:13',
        ]);

        if($validator->fails())
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);

        $input['product_id'] = $product->id;
        $brosur = RequestBrosur::create($input);

        return response()->json([
            'status' => 'success',
            'message' => 'Permintaan telah diterima,
                         tunggu admin untuk mengirimkan brosur ke email ataupun no whatsapp. Terima kasih!'
        ]);

    }
}
