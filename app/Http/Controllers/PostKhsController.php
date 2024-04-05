<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\PostKhs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostKhsController extends Controller
{
    /**
     * index
     *
     * @return void
     */
    public function index()
    {
        //get all posts
        $postKhss = PostKhs::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Khs', $postKhss);

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
            'file_url'     => 'required|file|mimes:pdf|max:2048',
            'semester'     => 'required|numeric',
            'academic_year'   => 'required|numeric',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $pdf = $request->file('file_url');
        $pdf->storeAs('public/posts/pdf', $pdf->hashName());

        //create post
        $postKhss = PostKhs::create([
            'file_url'     => $pdf->hashName(),
            'semester'     => $request->semester,
            'academic_year'   => $request->academic_year,
        ]);

        //return response
        return new PostResource(true, 'Data Khs Berhasil Ditambahkan!', $postKhss);
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
        $postKhss = PostKhs::find($id);

        //return single post as a resource
        return new PostResource(true, 'Detail Data Khs Berhasil Ditemukan!', $postKhss);
    }
}
