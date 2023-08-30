<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\PostCategory;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Alert;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::with(['tag', 'category', 'user'])->latest()->get();
        return view('backend.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $category = Category::all();
        $tags = Tag::all();
        return view('backend.posts.create', compact('category', 'tags'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|unique:posts,title',
            'image' => 'required',
            'body' => 'required',
            'category' => 'required',
            'excerpt' => 'required',
            'tag' => 'required',
            'status' => 'required|in:publish,private'
        ]);

        DB::beginTransaction();
        try {
            $ekstensi = $request->image->extension();
            $nama = $request->image->getClientOriginalName();
            $sekarang = date('mdYHis') . Auth::user()->id;
            $ekstensifile = explode('.', $nama);
            $ekstensifileupload = $ekstensifile[count($ekstensifile) - 1];
            if ($ekstensi == 'bin' and $ekstensi != $ekstensifileupload) {
                $namaok = $sekarang . "." . $ekstensifileupload;
            } else {
                $namaok = $sekarang . "." . $ekstensi;
            }
            Storage::putFileAs('\image', $request->file('image'), $namaok);



            $posts = Post::insertGetId([
                'title' => $request->title,
                'slug' => Str::slug($request->title),
                'image' => $namaok,
                'body' => $request->body,
                'excerpt' => $request->excerpt,
                'meta_description' => $request->meta_description,
                'user_id' => Auth::user()->id,
                'status' => $request->status,
            ]);

            $post = Post::where('id', $posts)->first();
            $postCategory = $request->category;
            $post->category()->attach($postCategory);

            $postTag = $request->tag;
            $post->tag()->attach($postTag);

            DB::commit();
            Alert::success('Success', 'Successfully added new post');
            return redirect(route('posts.index'));
        } catch (\Exception $e) {
            DB::rollBack();
            report($e);
            Alert::error('Failed', 'Failed added new posts!!!');
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
        //
    }
}
