<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Alert;
use Brian2694\Toastr\Facades\Toastr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use PhpParser\Node\Stmt\Catch_;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function data()
    {
        $data = Category::orderBy('title', 'asc')->get();

        return datatables()
            ->of($data)
            ->addIndexColumn()
            ->addColumn('action', function ($data) {
                return '<a href="' . route('category.edit', $data->id) . '" class="btn btn-sm btn-success"><i class="fa fa-edit"></i></a>
                <button onclick="modalHapus(`' . route('category.destroy', $data->id) . '`)"  class="btn btn-sm btn-danger"><i class="fas fa-trash-alt"></i></button>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }
    public function index()
    {
        return view('backend.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('backend.category.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = $request->validate([
            'title' => 'required|unique:categories,title',
            'slug' => 'required'
        ]);

        DB::beginTransaction();
        try {
            $category = new Category();
            $category->title = $request->title;
            $category->slug = $request->slug;
            $category->save();

            DB::commit();
            Toastr::success('Successfully added new category', 'Success');
            return redirect(route('category.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Failed added new category', 'Error');
            return back()->withInput();
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
        $data = Category::where('id', $id)->first();
        return view('backend.category.edit', compact('data'));
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
        $data = $request->validate([
            'title' => 'required|unique:categories,title,' . $id,
            'slug' => 'required'
        ]);

        DB::beginTransaction();
        try {

            $category = Category::where('id', $id)
                ->update([
                    'title' => $request->title,
                    'slug' => $request->slug
                ]);
            DB::commit();
            Toastr::success('Successfully updated category', 'Success');
            return redirect(route('category.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Failed updated category', 'Error');
            return back()->withInput();
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
        DB::beginTransaction();
        try {
            $data = Category::where('id', $id)->delete();
            DB::commit();
            Toastr::success('Successfully deleted category', 'Success');
            if (!$data) {
                return response()->json(['error' => 'Data not found'], 404);
            }
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Toastr::error('Failed deleted category', 'Error');
            return back()->withInput();
        }
    }
}
