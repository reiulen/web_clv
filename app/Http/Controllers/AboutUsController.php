<?php

namespace App\Http\Controllers;

use App\Models\AboutUs;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class AboutUsController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.about_us.index');
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

        $validasi = Validator::make($input, [
            'title' => 'required',
            'description' => 'required',
        ]);

        if($validasi->fails())
            return response()->json([
                'message' => $validasi->errors()->first()
            ]);

        $data = AboutUs::find($request->id);
        if(isset($data)) {
            $data->update($input);
        }else {
            $data = AboutUs::create($input);
        }

        return response()->json([
            'status' => 'success',
            'message' => "Data $data->title berhasil disimpan" ,
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
        $data = AboutUs::find($id);
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
        $data = AboutUs::find($id);
        if(empty($data))
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ]);

        if($data->id == 1 || $data->id == 2)
            return response()->json([
                'message' => 'Data tidak dapat dihapus'
            ]);

        $data->delete();

        return response()->json([
            'message' => "Data $data->title berhasil dihapus" ,
        ]);
    }

    public function dataTable(Request $request)
    {
        $data = AboutUs::select('id', 'title', 'description', 'created_at')
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
                                                    <div role='button' class='text-dark hover-underline btnEdit' data-id='$data->id'>
                                                        <div class='''>
                                                            <h6>
                                                                $data->title
                                                            </h6>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-md-4 ml-auto d-flex flex-column text-left'>
                                                    ".substr(strip_tags($data->description), 0, 100)."".(strlen(strip_tags($data->description)) > 200 ? '....' : '')."
                                                </div>
                                                <div class='col-md-2 ml-auto d-flex flex-column text-left'>
                                                    <span>Created At</span>
                                                    <strong>".date('Y-m-d', strtotime($data->created_at))."</strong>
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

    public function getData(Request $request) {
        $data = AboutUs::select('id', 'title', 'description')
                        ->orderBy('id', "DESC");
        if($request->first)
            $data = $data->first();

        if($request->all)
            $data = $data->get();

        return response()->json($data);
    }
}
