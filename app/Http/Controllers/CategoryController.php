<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Alert;
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
    public function index()
    {
        $data = Category::latest()->get();
        return view('backend.category.index', compact('data'));
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
            Alert::success('Success', 'Successfully added new category');
            return redirect(route('category.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::error('Failed', 'Failed added new category!!!');
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
            Alert::success('Success', 'Successfully edit category');
            return redirect(route('category.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::error('Failed', 'Failed edit category!!!');
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
            Category::where('id', $id)->delete();
            DB::commit();
            Alert::success('Success', 'Successfully delete category');
            return redirect(route('category.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::error('Failed', 'Failed delete category!!!');
            return back()->withInput();
        }
    }
}
