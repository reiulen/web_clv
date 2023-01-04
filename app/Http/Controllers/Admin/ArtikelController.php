<?php

namespace App\Http\Controllers\Admin;

use App\Models\Artikel;
use App\Models\ViewArtikel;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;

class ArtikelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.blog.artikel.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.blog.artikel.create-update');
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
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required'
        ]);

        try {
            $input = $request->all();
            if($request->hasFile('thumbnail')){
                $input['thumbnail'] = upload_image($request->file('thumbnail'), 'Artikel', Str::slug($request->title));
            }
            $input['slug'] = Str::slug($request->title);

            Artikel::create($input);

            return redirect(route('blog.artikel.index'))
                        ->with('success', 'Artikel berhasil ditambahkan');
        }catch(\Exception $e) {
            return back()
                    ->with('error', $e->getMessage())
                    ->withInput();
        }
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
        $data = Artikel::findOrFail($id);
        return view('admin.blog.artikel.create-update', compact('data'));
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
            'title' => 'required',
            'content' => 'required',
            'thumbnail' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'required'
        ]);

        $data = Artikel::findOrFail($id);

        try {
            $input = $request->all();
            if($request->hasFile('thumbnail')){
                if(isset($data->thumbnail)) File::delete($data->thumbnail);
                $input['thumbnail'] = upload_image($request->file('thumbnail'), 'Artikel', Str::slug($request->title));
            }
            $input['slug'] = Str::slug($request->title);

            $data->update($input);

            return redirect(route('blog.artikel.index'))
                        ->with('success', 'Artikel berhasil diubah');
        }catch(\Exception $e) {
            return back()
                    ->with('error', $e->getMessage())
                    ->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = Artikel::find($id);
        if(empty($data))
            return response()->json([
                'message' => 'Data tidak ditemukan'
            ]);

        if($data->thumbnail)
            File::delete($data->thumbnail);

        $data->delete();

        return response()->json([
            'message' => "Data $data->title berhasil dihapus" ,
        ]);

    }

    public function dataTable(Request $request)
    {
        $data = Artikel::select('id', 'status', 'title', 'created_at', 'slug')
                        ->with('views:id,views,artikel_id')
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
                                                <div class='col-md-5'>
                                                    <a href='".route('blog.artikel.edit', $data->id)."' class='text-dark hover-underline'>
                                                        <h6>
                                                            $data->title
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
                                                        <a class='dropdown-item' href='".env('FRONT_URL')."/artikel/$data->slug' target='_blank'>
                                                            <i class='fas fa-eye text-primary pr-1'></i>
                                                            Pratijau
                                                        </a>
                                                        <a class='dropdown-item' href='".route('blog.artikel.edit', $data->id)."'>
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

    public function getAll(Request $request)
    {
        $data = Artikel::select('id', 'title', 'slug', 'thumbnail',
                                'status', 'content', 'created_at')
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
        $data = Artikel::firstWhere([ 'slug' => $slug, 'status' => 1]);

        if($data) {
            $dateNow = date('Y-m-d');
            $view = ViewArtikel::where(['date' => $dateNow, 'artikel_id' => $data->id])->first() ?? new ViewArtikel;
            $view->views = ($view->views ?? 0) + 1;
            $view->artikel_id = $data->id;
            $view->date = $dateNow;
            $view->save();
        }

        return response()->json($data);
    }
}
