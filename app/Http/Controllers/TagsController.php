<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Alert;

class TagsController extends Controller
{
    /**
     * Show the form for creating the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $data = Tag::latest()->get();
        return view('backend.tags.index', compact('data'));
    }
    public function create()
    {
        return view('backend.tags.create');
    }

    /**
     * Store the newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|unique:tags,title'
        ]);

        DB::beginTransaction();
        try {

            Tag::create($data);
            DB::commit();
            Alert::success('Success', 'Successfully added new tags');
            return redirect(route('tags.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::error('Failed', 'Failed added tags!!!');
            return back()->withInput();
        }
    }

    /**
     * Display the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        //
    }

    /**
     * Show the form for editing the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $tag = Tag::where('id', $id)->first();

        return view('backend.tags.edit', compact('tag'));
    }

    /**
     * Update the resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'title' => 'required|unique:tags,title,' . $id
        ]);

        DB::beginTransaction();
        try {

            Tag::where('id', $id)
                ->update($data);
            DB::commit();
            Alert::success('Success', 'Successfully edit tags');
            return redirect(route('tags.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::error('Failed', 'Failed edit tags!!!');
            return back()->withInput();
        }
    }

    /**
     * Remove the resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            Tag::where('id', $id)->delete();
            DB::commit();
            Alert::success('Success', 'Successfully delete tags');
            return redirect(route('tags.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::error('Failed', 'Failed delete tags!!!');
            return back()->withInput();
        }
    }
}
