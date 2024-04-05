<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\PostTagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostTagihanController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $postTagihans = PostTagihan::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Tagihan', $postTagihans);

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
            'bill'     => 'required|numeric',
            'penalty'     => 'required|numeric',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //create post
        $postTagihans = PostTagihan::create([
            'bill'     => $request->bill,
            'penalty'   => $request->penalty,
        ]);

        //return response
        return new PostResource(true, 'Data Tagihan Berhasil Ditambahkan!', $postTagihans);
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
        $postTagihans = PostTagihan::find($id);

        //return single post as a resource
        return new PostResource(true, 'Detail Data Tagihan Berhasil Ditemukan!', $postTagihans);
    }
}
