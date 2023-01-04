<?php

namespace App\Http\Controllers\Admin;

use App\Models\Page;
use App\Models\TypePage;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\File;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $type_page = TypePage::select('id', 'name', 'status')
                                ->where('status', 1)
                                ->pluck('name', 'id');
        return view('admin.halaman.page.index', compact('type_page'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type_page = TypePage::select('id', 'name', 'status')
                                ->where('status', 1)
                                ->pluck('name', 'id');
        return view('admin.halaman.page.create-update', compact('type_page'));
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
            'status' => 'required'
        ]);

        try {
            $input = $request->all();
            if($request->hasFile('thumbnail')){
                $input['thumbnail'] = upload_image($request->file('thumbnail'), 'Halaman', Str::slug($request->title));
            }
            $input['slug'] = Str::slug($request->title);

            Page::create($input);

            return redirect(route('page.halaman.index'))
                        ->with('success', 'Halaman berhasil ditambahkan');
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
        $data = Page::findOrFail($id);
        $type_page = TypePage::select('id', 'name', 'status')
                                ->where('status', 1)
                                ->pluck('name', 'id');
        return view('admin.halaman.page.create-update', compact('data', 'type_page'));
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
            'status' => 'required'
        ]);

        $data = Page::findOrFail($id);

        try {
            $input = $request->all();
            if($request->hasFile('thumbnail')){
                if(isset($data->thumbnail)) File::delete($data->thumbnail);
                $input['thumbnail'] = upload_image($request->file('thumbnail'), 'Page', Str::slug($request->title));
            }
            $input['slug'] = Str::slug($request->title);

            $data->update($input);

            return redirect(route('page.halaman.index'))
                        ->with('success', 'Halaman berhasil diubah');
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
        $data = Page::find($id);
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
        $data = Page::select('id', 'status', 'title', 'created_at', 'type_page_id')
                        ->with('typePage:id,name')
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
                                                    <a href='".route('page.halaman.edit', $data->id)."' class='text-dark hover-underline'>
                                                        <h6>
                                                            $data->title
                                                        </h6>
                                                    </a>
                                                </div>
                                                <div class='col-md-2 text-center mx-auto d-flex flex-column'>
                                                    <span>Created At</span>
                                                    <strong>".date('Y-m-d', strtotime($data->created_at))."</strong>
                                                </div>
                                                <div class='col-md-2'>
                                                    ".($data->typePage->name ?? '-')."
                                                </div>
                                                <div class='col-md-2'>
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
                                                        <a class='dropdown-item' href='".route('page.halaman.edit', $data->id)."'>
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
        $data = Page::select('id', 'title', 'slug', 'status', 'link_youtube', 'content', 'type_page_id', 'created_at')
                        ->with('typePage:id,name')
                        ->where('status', 1)
                        ->latest();

        if($request->type)
            $data = $data->whereHas('typePage', function($query) use ($request) {
                $query->where('name', $request->type);
            });

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
        $data = Page::select('id', 'title', 'slug', 'link_youtube', 'thumbnail', 'content', 'type_page_id', 'status')
                        ->firstWhere([ 'slug' => $slug, 'status' => 1]);

        return response()->json($data);
    }
}
