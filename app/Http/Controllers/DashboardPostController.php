<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Services\SlugService;

class DashboardPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
     //view semua data post mengikut user tertentu
     //GET
     public function index()
    {
        
        //dapatkan data post berdasrkan userid oleh user yg tengah online
        return view('dashboard.posts.index', [
            'posts' => Post::where('user_id', auth()->user()->id)->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

     //halaman tambah posting baru
    public function create()
    {
        return view('dashboard.posts.create', [
            'categories' => Category::all() //ambil data dari Model Category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

     //menjalankan fungsi tambah posting
     //POST
    public function store(Request $request)
    {   
        //rq abil isi file, panggil method nama store, store ke dlm folder 'post-image'
        // return $request->file('image')->store('post-images');
        
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required|unique:posts', //slug dari table posts
            'category_id' => 'required',   //dikirim
            'image' => 'image|file|max:1024',   //1024kb
            'body' => 'required'
            //'excerpt' kita buat manual
            //'user_id'
        ]);

        //if user ada isi image execute this condition
        //if user tiada isi image, ignore this condition
        //if requesst dari file yg nama nya image..
        //req ambil file image dan kita simpan/store di post-images
        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('post-images');
        }
        //bila file image berjaya di store dlm file post-image..insert ke dalam db seperti command dibawah

        // ['user_id'] ambil dari id user yg tengah online / ada akses session
        $validatedData['user_id'] = auth()->user()->id;
        // strip_tags kasi hilang script html
        $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);

        //insert data ke Db
        Post::create($validatedData);

        //bila berjaya create post, redirect halaman ke create page dengan flash message
        return redirect ('/dashboard/posts')->with('success', 'New Post has been Added! ');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

     //view detail posting
    public function show(Post $post)
    {

        //kita tidak boleh melihat dan mengubah post buatan author lain
        if($post->author->id !== auth()->user()->id) {
            abort(403);
        }

        //di halaman posts/show..dlm nya akan dikirim data post (1), yg diambil dari $post
        return view ('dashboard.posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

    //ubah data
    public function edit(Post $post)
    {   
        //kita tidak boleh melihat dan mengubah post buatan author lain
        if($post->author->id !== auth()->user()->id) {
            abort(403);
        }
        
        return view('dashboard.posts.edit', [
            'post' => $post,    //tambah ini utk title di hala
            'categories' => Category::all() 
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */

     //PUT
     //update data
     //$request ini apa yg kita tulis/edit baru. $post adalah data lama yg sudah ada dlm table dlm db
    public function update(Request $request, Post $post)
    {
        
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required',   //dikirim
            'image' => 'image|file|max:1024',
            'body' => 'required'
            //'excerpt' kita buat manual
            //'user_id'
        ];
        
            //jika value slug yg baru = value slug yg lama, jangan kasi validate/lolos
             //jika value slug yg baru != value slug yg lama, sebab kita kasi update, kasi validate!

        if($request->slug != $post->slug) {
            $rules['slug'] = 'required|unique:posts'; //$rules yg key nya 'slug', diisi dengan aturan required (klu data x diisi akan keluar error message)
        }

        $validatedData = $request->validate($rules);//$valiateddata diisi dengan $request valiidate $rules
        
        //update image baru jika ada
        if($request->file('image')) {
            //kalau gambar lama ada, kita delete gambar dari file storage post-image
            if($request->oldImage) {
                Storage::delete($request->oldImage); 
            }
            //gambar baru akan diganti gambar lama
            $validatedData['image'] = $request->file('image')->store('post-images');
        }

        // BILA VALIDATE DATA SUDAH CONFIRM
        
        // ['user_id'] ambil dari id user yg tengah online / ada akses session
         $validatedData['user_id'] = auth()->user()->id;
        // strip_tags kasi hilang script html
         $validatedData['excerpt'] = Str::limit(strip_tags($request->body), 200);
        
        //insert data ke Db
        //update validatedData, where user id = post id
        Post::where('id', $post->id )
        ->update($validatedData);
        
        //bila berjaya update data post, redirect halaman ke create page dengan flash message
        return redirect ('/dashboard/posts')->with('success', 'Post has been Updated! ');
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    
     //DELETE
     //delete post
    public function destroy(Post $post)
    {
        //delete gambar dari db dan file storage
            if($post->image) {
                Storage::delete($post->image); 
            }
        //delete data post dari table berdasarkan id, delete from Posts where id = id
        Post::destroy($post->id);

        //bila berjaya delete post, redirect halaman ke post page dengan flash message
        return redirect ('/dashboard/posts')->with('success', 'Post has been Deleted! ');
        
    }

    //ambil rwuest, didapatkan ambil dari isi input title
    public function checkSlug (Request $request)
    {
       $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
       return response()->json(['slug' => $slug]);
    }

    
}
