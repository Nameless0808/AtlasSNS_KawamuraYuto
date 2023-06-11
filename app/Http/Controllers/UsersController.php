<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{


    public function search(){
        return view('users.search');
    }



    public function index()
    {
        $users = User::where('id', '!=', Auth::id())->get();
        return view('users.search', ['users' => $users]);
    }

    public function searchResult(Request $request)
    {
        $query = $request->input('query');
        $users = User::query();

        if($query) {
            $users = $users->where('username', 'LIKE', "%{$query}%");
        }

        $users = $users->where('id', '!=', Auth::id())->get();
        $currentUser = Auth::user();

        // ユーザーデータを正しくフィールドと対応付ける
        $users = $users->map(function($user) use ($currentUser) {
            return [
                'id' => $user->id,
                'name' => $user->username,
                'avatar' => $user->images ? "/images/{$user->images}" : '/path/to/default/avatar.png',
                'isFollowing' => $currentUser->isFollowing($user->id),
            ];
        });

        return response()->json($users);
    }

    public function profile(){

    $user = Auth::user(); // ログインユーザーを取得
    return view('users.profile', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $user = Auth::user(); // 現在のユーザーを取得します
        $request->validate([
        'username' => 'required|min:2|max:12',
        'mail' => 'required|email|min:5|max:40|unique:users,mail,' . $user->id,
        'password' => 'nullable|alpha_num|min:8|max:20|confirmed',
        'bio' => 'max:150',
        'images' => 'nullable|image|mimes:jpeg,png,bmp,gif,svg'
    ]);

    if($request->hasFile('images')) {
        $imageName = $user->id.'_image'.time().'.'.request()->images->getClientOriginalExtension();
        $request->images->storeAs('images', $imageName, 'public');  // ディスクを 'public' に指定
        $user->images = $imageName;
    }


    $user->username = $request->username;
    $user->mail = $request->mail;
    $user->bio = $request->bio;

    if (!empty($request->password)) {
        $user->password = Hash::make($request->password);
    }

    $user->save();

    return redirect()->route('profile');
}


    public function show($id = null)
    {
        $user = $id ? User::findOrFail($id) : Auth::user();
        $user->posts = $user->posts()->orderBy('created_at', 'desc')->get();

        return view('users.profile', compact('user'));
    }

}
