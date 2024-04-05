<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\PostPiket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostPiketController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $postPikets = PostPiket::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Piket', $postPikets);

    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'before_img_url'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'after_img_url'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'date'   => 'required|date',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $before_img = $request->file('before_img_url');
        $before_img->storeAs('public/posts/image', $before_img->hashName());

        $after_img = $request->file('after_img_url');
        $after_img->storeAs('public/posts/image', $after_img->hashName());

        //create post
        $postPikets = PostPiket::create([
            'before_img_url'     => $before_img->hashName(),
            'after_img_url'     => $after_img->hashName(),
            'date'   => $request->date,
        ]);

        //return response
        return new PostResource(true, 'Data Piket Berhasil Ditambahkan!', $postPikets);
    }

     /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
    public function show($id)
    {
        //find post by ID
        $postPikets = PostPiket::find($id);

        //return single post as a resource
        return new PostResource(true, 'Detail Data Piket Berhasil Ditemukan!', $postPikets);
    }
}
