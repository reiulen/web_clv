<?php

namespace App\Http\Controllers;

use App\Models\Sosmed;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SosmedController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.sosmed.index');
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

        $data = Sosmed::find($request->id);
        if(isset($data)) {
            $validasi = Validator::make($input, [
                'status' => 'required',
                'name' => 'required|unique:sosmeds,name,'.$data->id,
            ]);

            if($validasi->fails())
                return response()->json([
                    'status' => 'error',
                    'message' => $validasi->errors()->first()
                ]);

            $data->update($input);
        }else {
            $validasi = Validator::make($input, [
                'status' => 'required',
                'name' => 'required|unique:sosmeds,name',
            ]);

            if($validasi->fails())
                return response()->json([
                    'status' => 'error',
                    'message' => $validasi->errors()->first()
                ]);

            $data = Sosmed::create($input);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Data $data->name berhasil disimpan" ,
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
        //
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
        $data = Sosmed::find($id);
        if(empty($data))
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ]);

        $data->delete();

        return response()->json([
            'message' => "Data $data->name berhasil dihapus" ,
        ]);
    }

    public function dataTable(Request $request)
    {
        $data = Sosmed::select('id', 'status', 'name', 'link', 'created_at')
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
                                                <div class='col-md-3'>
                                                    <div role='button' class='text-dark hover-underline btnEdit' data-id='$data->id' data-name='$data->name' data-status='$data->status' data-link='$data->link'>
                                                        <div class='''>
                                                            <h6>
                                                                $data->name
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-md-3 ml-auto d-flex flex-column text-left'>
                                                    <span>Link</span>
                                                    $data->link
                                                </div>
                                                <div class='col-md-2 ml-auto d-flex flex-column text-left'>
                                                    <span>Created At</span>
                                                    <strong>".date('Y-m-d', strtotime($data->created_at))."</strong>
                                                </div>
                                                <div class='col-md-2 ml-auto'>
                                                    $status
                                                </div>
                                                <div class='col-md-1'>
                                                    <button class='btn btn-none' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        <i class='fas fa-ellipsis-v'></i>
                                                    </button>
                                                    <div class='dropdown-menu dropdown-menu-right border-0' aria-labelledby='dropdownMenuButton'>
                                                        <div role='button' class='dropdown-item btnEdit' data-id='$data->id' data-name='$data->name' data-status='$data->status' data-link='$data->link'>
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

    public function getData() {
        $data = Sosmed::select('id', 'name', 'link', 'status')
                        ->orderBy('id', "DESC")
                        ->where('status', 1)
                        ->get();
        return response()->json($data);
    }
}
