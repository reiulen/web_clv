<?php

namespace App\Http\Controllers;

use App\Models\Slider;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\Validator;

class SliderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.slider.index');
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

        $data = Slider::find($request->id);

        $validator = Validator::make($input, [
            'foto' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if(empty($data)) {
            $validator = Validator::make($input, [
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
                $input['image'] = upload_image($request->file('foto'), 'Slider', Str::slug($request->name), 1360, 670);
                File::delete($data->image);
            }
            $data->update($input);
        }else {
            $count_data = Slider::count();
            if($count_data == 0)
                $input['order'] = 0;
            else
                $input['order'] = $count_data + 1;
            if($request->hasFile('foto'))
                $input['image'] = upload_image($request->file('foto'), 'Slider', Str::slug($request->name),  1360, 670);

            $data = Slider::create($input);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
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
        $data = Slider::find($id);
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
        $data = Slider::find($id);
        if(isset($data)) {
            if($data->image)
                File::delete($data->image);

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

    public function updown(Request $request, $id)
    {
        if($request->type == 'up') {
            $data = Slider::find($id);
            $data2 = Slider::where('order', '<', $data->order)->orderBy('order', 'DESC')->first();
            if($data2) {
                $data->order = $data2->order;
                $data2->order = $data2->order + 1;
                $data->save();
                $data2->save();
            }
        }elseif($request->type == 'down') {
            $data = Slider::find($id);
            $data2 = Slider::where('order', ($data->order + 1))->orderBy('order', 'DESC')->first();
            if($data2) {
                $data->order = $data2->order;
                $data2->order = $data2->order - 1;
                $data->save();
                $data2->save();
            }
        }else {
            return response()->json([
                'status' => 'error',
                'message' => 'Data tidak ditemukan',
            ]);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data berhasil disimpan',
        ]);
    }


    public function dataTable(Request $request)
    {
        $slider = Slider::select('id', 'name', 'image', 'description', 'order')
                        ->orderBy('order', 'ASC');

        return DataTables::of($slider)
                            ->addindexColumn()
                           ->addColumn('content', function($data) use ($slider) {
                                $order = $slider->get()->toArray();
                                $first = $order[0];
                                $last = end($order);

                                $slideUp = '';
                                $slideDown = '';
                                if($data->id != $first['id']) {
                                    $slideUp = "<button class='btn btn-success btn-sm p-1 shadow-sm btnUp' data-id='$data->id'>
                                                    <i class='fas fa-arrow-up'></i>
                                                </button>";
                                }

                                if($data->id != $last['id']) {
                                    $slideDown = "<button class='btn btn-success btn-sm p-1 shadow-sm btnDown' data-id='$data->id'>
                                                    <i class='fas fa-arrow-down'></i>
                                                  </button>";
                                }

                                $content = "<div class='row align-items-start'>
                                                <div class='col-md-7'>
                                                    <div role='button' class='text-dark hover-underline btnEdit' data-id='$data->id'>
                                                        <div class='d-flex align-items-center' style='gap: 10px;'>
                                                            <div class='mr-2'>
                                                                <img src='".asset($data->image)."'
                                                                     class='img-fluid w-100' style='height: 100px; object-fit: cover;'>
                                                            </div>
                                                            <div>
                                                                <h6>
                                                                    $data->name
                                                                </h6>
                                                                <div>
                                                                    $data->description
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class='col-md-2 ml-auto'>
                                                    <div class='d-flex align-items-center'>
                                                        <div>
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
                                                        <div class='d-flex align-items-center' style='gap: 10px'>
                                                            $slideUp
                                                            $slideDown
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>";
                                return $content;
                           })->rawColumns(['content'])
                           ->smart(true)
                           ->make(true);

    }

    public function getAll()
    {
        $slider = Slider::select('id', 'name', 'image', 'description', 'order', 'link')
                        ->orderBy('order', 'ASC')
                        ->get();

        return response()->json([
            'status' => 'success',
            'data' => $slider
        ]);
    }

}
