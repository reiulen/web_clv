<?php

namespace App\Http\Controllers;

use App\Models\Facilities;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class FacilitiesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.facilities.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
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

        $data = Facilities::find($request->id);

        $validator = Validator::make($input, [
            'name' => 'required',
        ]);

        if($data) {
            if($request->file('foto')) {
                $validator = Validator::make($input, [
                    'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
                ]);
            }
        }else {
            $validator = Validator::make($input, [
                'name' => 'required',
                'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            ]);
        }

        if($validator->fails())
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ]);

        if($data) {
            $input['foto'] = $data->foto;
            if($request->hasFile('foto')) {
                $input['foto'] = upload_image($request->file('foto'), 'Facilities', Str::slug($request->name));
                File::delete($data->foto);
            }
            $data->update($input);
        }else {
            if($request->hasFile('foto'))
                $input['foto'] = upload_image($request->file('foto'), 'Facilities', Str::slug($request->name));

            $data = Facilities::create($input);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
            'data' => $data->id
        ]);
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
        $data = Facilities::find($id);
        if(isset($data)) {
            return response()->json([
                'status' => 'success',
                'data' => $data
            ]);
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan'
            ]);
        }
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Facilities::find($id);
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

    public function dataTable(Request $request)
    {
        $data = Facilities::select('id', 'status', 'name', 'foto', 'created_at')
                            ->latest();
                            // ->filter($request);

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
                                                    <div role='button' class='text-dark hover-underline btnEdit' data-id='$data->id'>
                                                        <div class='d-flex align-items-center' style='gap: 10px;'>
                                                            <div class=''>
                                                                <img src='".asset($data->foto)."' style='height: 90px; width: 120px; object-fit: cover' />
                                                            </div>
                                                            <div>
                                                                <h6>
                                                                    $data->name
                                                                </h6>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-md-3 ml-auto d-flex flex-column text-left'>
                                                    <span>Created At</span>
                                                    <strong>".date('Y-m-d', strtotime($data->created_at))."</strong>
                                                </div>
                                                <div class='col-md-3 ml-auto'>
                                                    $status
                                                </div>
                                                <div class='col-md-1'>
                                                    <button class='btn btn-none' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        <i class='fas fa-ellipsis-v'></i>
                                                    </button>
                                                    <div class='dropdown-menu dropdown-menu-right border-0' aria-labelledby='dropdownMenuButton'>
                                                        <div role='button' class='dropdown-item btnEdit' data-id='$data->id'>
                                                            <i class='fas fa-pencil-alt text-success pr-1'></i>
                                                            Ubah
                                                        </div>
                                                        <div role='button' class='dropdown-item btn-hapus' data-id='$data->id' data-title='$data->name'>
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


    public function getAll(Request $request)
    {
        $data = Facilities::select('id', 'name', 'foto', 'status')
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


    public function getSelect(Request $request)
    {
        $select = explode(',', $request->select);
        try {
            $data = Facilities::select($select)
                        ->where('status', 1)
                        ->latest();

            if(isset($request->limit))
                $data = $data->limit($request->limit)->get();

            if(empty($request->limit))
                $data = $data->get();
        }catch(\Exception $e) {
            $data = [];
        }

        return response()->json([
            'data' => $data
        ]);
    }
}
