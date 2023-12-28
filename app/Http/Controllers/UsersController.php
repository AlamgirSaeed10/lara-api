<?php

namespace App\Http\Controllers;

use App\Models\Image;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Validator;

class UsersController extends Controller
{
    public function users_list()
    {
        $user = User::all();
        return response()->json([
            'message' => 'Total user found: ' . count($user),
            'data' => $user,
            'status' => true
        ], 200);
    }
    public function store_users(Request $request)
    {
        $user = new User();
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'email' => 'required|email',
            'password' => 'required|min:8'
        ]);
        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please fix the following errors!',
                'data' => $validator->errors(),
                'status' => false
            ], 400);
        } else {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->password = $request->password;
            $user->save();
            return response()->json([
                'message' => 'User Stored Successfully!',
                'data' => $user,
                'status' => true
            ], 200);
        }
    }
    public function update_user(Request $request, $id)
    {
        $user = User::find($id);

        if ($user != null) {
            $user->name = $request->name;
            $user->email = $request->email;
            $user->save();

            return response()->json([
                'message' => 'User Updated Successfully..!',
                'data' => $user,
                'status' => true
            ], 200);
        } else {

            return response()->json([
                'message' => 'User not found!',
                'data' => '',
                'status' => false
            ], 400);
        }
    }
    public function delete_user($id)
    {
        $user = User::find($id);
        if ($user != null) {
            $user->delete();
            return response()->json([
                'message' => 'User with  deleted Successfully!',
                'data' => '',
                'status' => true
            ], 200);
        } else {
            return response()->json([
                'message' => 'User does not found..!',
                'data' => '',
                'status' => ''
            ], 404);
        }
    }
    public function single_user($id)
    {
        $user = User::find($id);
        if ($user != null) {
            return response()->json([
                'message' => 'Single User data!',
                'data' => $user,
                'status' => true
            ], 200);
        } else {
            return response()->json([
                'message' => 'User not found!',
                'data' => '',
                'status' => false
            ], 404);
        }
    }


    public function upload_image(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|mimes:png,jpg,jpeg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'message' => 'Please choose the following format of file.',
                'data' => $validator->errors(),
                'status' => true,
            ], 400);
        }
        $img  = $request->image;
        $ext = $img->getClientOriginalExtension();
        $imageName = time() . '.' . $ext;
        $img->move(public_path() . '/uploads/', $imageName);

        $image = new Image();

        $image->image = $imageName;
        $image->save();

        return response()->json([
            'message' => 'Please choose the following format of file.',
            'path' => asset('uploads/', $imageName),
            'data' => 'Image Uploaded Successfully!',
            'status' => true,
        ], 200);
    }
}
