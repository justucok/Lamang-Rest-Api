<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use SebastianBergmann\Type\VoidType;

class PostUserController extends Controller
{
    /**
     * index
     *
     * @return void
     */
public function index(){
        //get all posts
        $postUsers = User::latest()->paginate(5);

        //return collection of posts as a resource
        return new PostResource(true, 'List Data Users', $postUsers);
    }

    /**
     * store
     *
     * @param  mixed $request
     * @return void
     */
public function store(Request $request){
        //define validation rules
        $validator = Validator::make($request->all(), [
            'profile_img_url' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|max:120',
            'username' => 'required|unique:users',
            'email' => 'required|email|lowercase',
            'university' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required|max:250',
            'password' => 'required|min:8',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //upload image
        $image = $request->file('profile_img_url');
        $image->storeAs('public/posts/image', $image->hashName());

        //create post
        $postUsers = User::create([
            'profile_img_url' => $image->hashName(),
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'university' => $request->university,
            'phone' => $request->phone,
            'address' => $request->address,
            'password' => Hash::make($request->password),
        ]);

        //return response
        return new PostResource(true, 'Data Users Berhasil Ditambahkan!', $postUsers);
    }

    /**
     * show
     *
     * @param  mixed $post
     * @return void
     */
public function show($id){
        //find post by ID
        $postUsers = User::find($id);

        //return single post as a resource
        return new PostResource(true, 'Detail Data User Berhasil Ditemukan!', $postUsers);
    }

    /**
     * update
     *
     * @param  mixed $request
     * @param  mixed $post
     * @return void
     */


public function update(Request $request, $id){
        //define validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|max:120',
            'username' => 'required|unique:users',
            'email' => 'required|email|lowercase',
            'university' => 'required',
            'phone' => 'required|numeric',
            'address' => 'required|max:250',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find post by ID
        $postUsers = User::find($id);

        //check if image is not empty
        if ($request->hasFile('profile_img_url')) {
            //upload image
            $image = $request->file('profile_img_url');
            $image->storeAs('public/posts/image', $image->hashName());

            //delete old image
            Storage::delete('public/posts/' . basename($postUsers->image));

            //update post with new image
            $postUsers->update([
                'profile_img_url' => $image->hashName(),
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'university' => $request->university,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        } else {
            //update post without image
            $postUsers->update([
                'name' => $request->name,
                'username' => $request->username,
                'email' => $request->email,
                'university' => $request->university,
                'phone' => $request->phone,
                'address' => $request->address,
            ]);
        }

        //return response
        return new PostResource(true, 'Data Users Berhasil Diubah!', $postUsers);
    }

    /**
     * destroy
     *
     * @param  mixed $post
     * @return void
     */
    public function destroy($id)
    {

        //find post by ID
        $postUsers = User::find($id);

        //delete image
        Storage::delete('public/posts/'. $postUsers->image);

        //delete post
        $postUsers->delete();

        //return response
        return new PostResource(true, 'Data Users Berhasil Dihapus!', null);
    }
}
