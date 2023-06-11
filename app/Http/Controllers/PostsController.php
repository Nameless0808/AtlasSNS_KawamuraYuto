<?php

namespace App\Http\Controllers;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // 追加

class PostsController extends Controller
{
    public function index()
   {
    $user = Auth::user(); // ユーザー情報を取得

    // 自分の投稿とフォローしている人の投稿を取得
    $posts = $user->posts()->orderBy('created_at', 'desc')->get();

    foreach ($user->followings as $following) {
        $following_posts = $following->posts()->orderBy('created_at', 'desc')->get();
        $posts = $posts->concat($following_posts);
    }

    // 新しい順に並べ替え
    $posts = $posts->sortByDesc('created_at');

    return view('posts.index', compact('posts', 'user'));
    }


    public function store(Request $request)
    {

         $request->validate([
            'post' => 'required|max:150'
        ]);

        $post = new Post;
        $post->user_id = Auth::user()->id;
        $post->post = $request->post;
        $post->save();

        return redirect('/top');
    }


   public function edit(Request $request, $id)
   {
       $post = Post::find($id);

       if ($request->ajax()) {
           // JSON形式で必要なデータを返す
           return response()->json($post);
       } else {
           // 通常のHTMLビューを返す
           return view('posts.edit', ['post' => $post]);
       }
   }


   public function update(Request $request, Post $post)
   {
    // 自分の投稿でなければ403エラー
       if ($post->user_id !== Auth::user()->id) {
           abort(403);
       }

       $request->validate([
        'post' => 'required|max:150',
       ]);

       $post->post = $request->post;
       $post->save();

       return redirect('/top');
   }

public function destroy(Request $request, $id)
{
    $post = Post::find($id);

    // ユーザーが投稿の所有者であることを確認
    if (Auth::id() !== $post->user_id) {
        return response()->json(['error' => 'You are not authorized to delete this post.'], 403);
    }

    $post->delete();
    return response()->json(['success' => 'Post deleted successfully.']);
}

}
