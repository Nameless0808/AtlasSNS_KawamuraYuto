<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FollowsController extends Controller
{
    //
public function followList() {
    $user = Auth::user();
    $followings = $user->followings;

    // followingsがnullでなく、空でないことを確認する
    if ($followings->isEmpty()) {
        return view('follows.followList')->with('message', 'You are not following anyone yet.');
    }

    // 以下の各項目の最新投稿を取得する
    foreach ($followings as $following) {
        $following->latest_post = $following->posts()->latest()->first();
    }

        return view('follows.followList', compact('followings'));
    }



    public function follow(Request $request)
    {
        $user = User::find($request->id);

        DB::table('follows')->insert([
            'following_id' => Auth::user()->id,  // 'follower_id' を 'following_id' に変更
            'followed_id' => $user->id,
        ]);

        return response()->json(['status' => 'success']);
    }

    public function unfollow(Request $request)
    {
        $user = User::find($request->id);

        DB::table('follows')
            ->where('following_id', Auth::user()->id)  // 'follower_id' を 'following_id' に変更
            ->where('followed_id', $user->id)
            ->delete();

            return response()->json(['status' => 'success']);
        }

    public function followerList() {
        $user = Auth::user();
        $followers = $user->followers;

   // フォロワーがnullでなく、空でないことを確認する。
        if ($followers->isEmpty()) {
            return view('follows.followerList')->with('message', 'No one is following you yet.');
        }

        // 各フォロワーの最新投稿を取得
        foreach ($followers as $follower) {
            $follower->latest_post = $follower->posts()->latest()->first();
        }

        return view('follows.followerList', compact('followers'));
    }

}
