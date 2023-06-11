@extends('layouts.login')

@section('content')

    <div class="post-form">
       <div class="user-image">
    <!-- ログインユーザーの画像を表示 -->
        <img src="{{ asset('storage/' . Auth::user()->images) }}" alt="User Image" class="user-image">
        </div>

    <form action="/posts" method="post">
    @csrf
      <div class="form-group">
      <textarea class="form-control @error('post') is-invalid @enderror" name="post" rows="3" placeholder="投稿内容を入力してください。"></textarea>
    @error('post')
      <span class="invalid-feedback" role="alert">
      <strong>{{ $message }}</strong>
      </span>
      @enderror
      </div>
          <button type="submit" class="btn btn-primary">
          <!-- 画像をボタンにする -->
          <img src="/images/post.png" alt="Submit">
          </button>
    </form>
      </div>

<!-- 投稿一覧画面 -->
    @foreach ($posts as $post)
    <li class="post-block">
        <figure><img src="{{ asset('storage/' . $post->user->images) }}" alt="{{ $post->user->username }}" class="user-image"></figure>
        <div class="post-content">
            <div class="post-header">
                <div class="post-name">{{ $post->user->username }}</div>
                <div>{{ $post->created_at->format('Y/m/d H:i') }}</div> <!--時間も表示されるように変更 -->
            </div>
            <div class="post-body">
                <div>{{ $post->post }}</div>
                <!-- 編集ボタン（自分の投稿のみ表示） -->
                @if (Auth::id() === $post->user_id)
                    <div class="post-buttons">
                        <button class="btn btn-primary edit-button" data-id="{{ $post->id }}">
                            <img src="/images/edit.png" alt="Edit">
                        </button>
                        <!-- 削除ボタンのHTML -->
                        <button class="btn btn-danger delete-post" data-postid="{{ $post->id }}">
                            <img src="/images/trash.png" alt="trash">
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </li>
    @endforeach



<!-- 編集用モーダル -->
    <div id="edit-modal" class="modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
           <div class="modal-content">
             <div class="modal-header">
                <h5 class="modal-title">投稿編集</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- 編集フォーム。初めは非表示にしておく -->
                <form id="edit-form" method="post" style="display: none;">
                    @csrf
                    @method('PATCH')
                    <!-- textareaにIDを追加 -->
                    <textarea id="edit-post-text" name="post" rows="3"></textarea>
                    <button type="submit">更新</button>
                </form>
             </div>
           </div>
        </div>
     </div>

     <!-- 削除用モーダル -->
    <div id="delete-modal" class="modal fade" tabindex="-1" role="dialog">
       <div class="modal-dialog">
           <div class="modal-content">
               <div class="modal-header">
                   <h5 class="modal-title">投稿削除</h5>
                   <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                   </button>
               </div>
               <div class="modal-body">
                   この投稿を削除します。よろしいですか？
               </div>
               <div class="modal-footer">
                   <button type="button" class="btn btn-secondary" data-dismiss="modal">キャンセル</button>
                   <button type="button" class="btn btn-danger" id="delete-confirm">OK</button>
               </div>
          </div>
       </div>
    </div>

    @endsection

@push('scripts') <!-- スクリプトをpushする -->
 <script>
$(document).ready(function() {
    $('.edit-button').on('click', function() {
        let id = $(this).data('id');
        console.log('edit button clicked, id:', id);  // 追加

        $.ajax({
            type: 'GET',
            url: '/posts/' + id + '/edit',  // URLのパスを修正
            dataType: 'json',
            success: function(data) {
                console.log('ajax request success, data:', data);  // 追加
                $('#edit-post-text').val(data.post);
                $('#edit-form').attr('action', '/posts/' + data.id);
                $('#edit-form').show();  // 編集フォームを表示
                $('#edit-modal').modal('show');
            },
            error: function(xhr, status, error) {
                console.log('ajax request error, status:', status, 'error:', error);  // 追加
            }
        });
    });
});
 </script>

 <script>
$(document).ready(function() {
    let postId;

    $('.delete-post').on('click', function() {
        $(this).find('img').attr('src', '/images/trash-h.png');
        postId = $(this).data('postid');
        $('#delete-modal').modal('show');
    });

     // モーダルが閉じられたときに元の画像に戻す
    $('#delete-modal').on('hidden.bs.modal', function () {
        $('.delete-post img').attr('src', '/images/trash.png');
    });

    $('#delete-confirm').on('click', function() {
        $.ajax({
            type: 'POST',
            url: '/posts/' + postId,
            data: {_method: 'DELETE'},
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(data) {
                console.log('delete request success, data:', data);
                location.reload();
            },
            error: function(xhr, status, error) {
                console.log('delete request error, status:', status, 'error:', error);
            }
        });
    });
});


</script>
@endpush
