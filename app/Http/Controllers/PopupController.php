<?php

namespace App\Http\Controllers;

use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class PopupController extends Controller
{

    public function getPopup(Request $request)
    {
        $facilities = Popup::select('id', 'name as text', 'image')
                            ->where('name', 'like', '%'.$request->keyword.'%')
                            ->get();
        return $facilities->toJson();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.popup.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.popup.create-update');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'name' => 'required',
        ]);

        $popupModel = new Popup;
        switch($request->type) {
            case 1 :
                $request->validate([
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                if($request->hasFile('image')){
                    $image = upload_image($request->file('image'), 'Popup', 'Popup');
                }
                $popupModel->image = $image;
                break;
            case 2 :
                $request->validate([
                    'title' => 'required',
                    'content' => 'required',
                ]);
                $popupModel->title = $request->title;
                $popupModel->content = $request->content;
                break;
            case 3 :
                $request->validate([
                    'title' => 'required',
                    'content' => 'required',
                    'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                if($request->hasFile('image')){
                    $image = upload_image($request->file('image'), 'Popup', 'Popup');
                }
                $popupModel->image = $image;
                $popupModel->title = $request->title;
                $popupModel->content = $request->content;
                break;
            default :
                return redirect(route('popup.create'))
                            ->with('error', 'Tipe popup tidak ditemukan');
                break;
        }

        $popupModel->name = $request->name;
        $popupModel->type = $request->type;
        $popupModel->status = $request->status;
        $popupModel->link = $request->link;
        $popupModel->save();


        return redirect(route('popup.index'))
                    ->with('success', 'Popup berhasil ditambahkan');

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
        $data = Popup::findOrFail($id);
        return view('admin.popup.create-update', compact('data'));
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
        $request->validate([
            'type' => 'required',
            'name' => 'required',
        ]);

        $popupModel = Popup::findOrFail($id);
        switch($request->type) {
            case 1 :
                $request->validate([
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $image = $popupModel->image;
                if($request->hasFile('image')){
                    $image = upload_image($request->file('image'), 'Popup', 'Popup');
                    File::delete($popupModel->image);
                }
                $popupModel->image = $image;
                break;
            case 2 :
                $request->validate([
                    'title' => 'required',
                    'content' => 'required',
                ]);
                $popupModel->title = $request->title;
                $popupModel->content = $request->content;
                break;
            case 3 :
                $request->validate([
                    'title' => 'required',
                    'content' => 'required',
                    'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                ]);
                $image = $popupModel->image;
                if($request->hasFile('image')){
                    $image = upload_image($request->file('image'), 'Popup', 'Popup');
                    File::delete($popupModel->image);
                }
                $popupModel->image = $image;
                $popupModel->title = $request->title;
                $popupModel->content = $request->content;
                break;
            default :
                return redirect(route('popup.create'))
                            ->with('error', 'Tipe popup tidak ditemukan');
                break;
        }

        $popupModel->name = $request->name;
        $popupModel->type = $request->type;
        $popupModel->status = $request->status;
        $popupModel->link = $request->link;
        $popupModel->save();


        return redirect(route('popup.index'))
                    ->with('success', 'Popup berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Popup::find($id);
        if(empty($data))
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ]);

        if($data->image)
            File::delete($data->image);

        $data->delete();

        return response()->json([
            'message' => "Data $data->name berhasil dihapus" ,
        ]);

    }

    public function dataTable(Request $request)
    {
        $data = Popup::select('id', 'status', 'name', 'type', 'created_at')
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

                                $type = [
                                    1 => 'Foto',
                                    2 => 'Judul & Content',
                                    3 => 'Judul, Content, Foto',
                                ];

                                $content = "<div class='row align-items-center'>
                                                <div class='col-md-3'>
                                                    <a href='".route('popup.edit', $data->id)."' class='text-dark hover-underline'>
                                                        <h6>
                                                            $data->name
                                                        </h6>
                                                    </a>
                                                </div>
                                                <div class='col-md-2 text-center mx-auto d-flex flex-column'>
                                                    <span>Created At</span>
                                                    <strong>".date('Y-m-d', strtotime($data->created_at))."</strong>
                                                </div>
                                                <div class='col-md-2'>
                                                    ".($type[$data->type] ?? '-')."
                                                </div>
                                                <div class='col-md-2 text-center'>
                                                    $status
                                                </div>
                                                <div class='col-md-1'>
                                                    <button class='btn btn-none' id='dropdownMenuButton' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'>
                                                        <i class='fas fa-ellipsis-v'></i>
                                                    </button>
                                                    <div class='dropdown-menu dropdown-menu-right border-0' aria-labelledby='dropdownMenuButton'>
                                                        <a class='dropdown-item' href='/' target='_blank'>
                                                            <i class='fas fa-eye text-primary pr-1'></i>
                                                            Pratijau
                                                        </a>
                                                        <a class='dropdown-item' href='".route('popup.edit', $data->id)."'>
                                                            <i class='fas fa-pencil-alt text-success pr-1'></i>
                                                            Ubah
                                                        </a>
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
}
