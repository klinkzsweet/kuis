<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Post;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //mengambil data terahir dan pagination 5 list
        $posts = Post::latest()->paginate(5);

        //mengirimkan variabel @posts kehalaman viws posts/index.blade.php
        //include dengan number index
        return view('posts.index', compact('posts')) 
            ->with('i',(request()->input('page', 1) -1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //menampilkan halaman create
        return view ('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //membuat validasi untuk title dan content wajib di isi
        $request->validate([
            'title'=>'required',
            'content'=>'required',
        ]);
        
        //insert setiap request dari form ke dalam database via model
        //jika menggunakan metode ini, maka nama field dan nama form harus sama
        Post::create($request->all());
        
        //redirect jika sukse menyimpan data
        return redirect()->route('posts.index')
                        ->with('success','Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //dengan memanfaatkan resource,kita sapat memanfaatkan model sebagai parameter
        //berdasarkan id yang dipilih
        //href="{{ route('posts.show', $post->id) }}"
        return view('posts.show',compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        //dengan memanfaatkan resource,kita sapat memanfaatkan model sebagai parameter
        //berdasarkan id yang dipilih
        //href="{{ route('posts.edit', $post->id) }}"
        return view('posts.edit',compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        //membuat validasi untuk title dan kontent wajib di isi
        $request->validate([
            'title'=>'required',
            'content'=>'required',
        ]);
        
        //mengubah data berdasarkan request dan parameter yang dikirimkan
        $post->update($request->all());

        //setelah berhasi mengubah data
        return redirect()->route('posts.index')
                        ->with('success','Post updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        //menghapus data berdasarkan parameter yang dikirimkan
        $post->delete();

        return redirect()->route('posts.index')
                        ->with('success','Post deleted successfully.');
    }
}
