@extends('layouts.admin')
@section('title', '登録済みの投稿一覧')

@section('content')
    <div class="container">
        <div class="row">
            <h2>投稿一覧</h2>
        </div>
        <div class="row">
            <div class="col-md-4">
                <a href="{{ action('Admin\PostController@add') }}" role="button" class="btn btn-primary">新規作成</a>
            </div>
            <div class="col-md-8">
                <form action="{{ action('Admin\PostController@index') }}" method="get">
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="cond_title" value="{{ $cond_title }}">
                        </div>
                        <div class="col-md-2">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="検索">
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
        @php $count = 1 @endphp
        
        @foreach($posts as $post)
            <div class="box1 col-md-3">
                <div class="card w-100">
                    @if ($post->image_path)
                        <img class="card-img-top" src="{{ asset('storage/image/' . $post->image_path) }}" alt="Card image cap">
                    @endif
                    <div class="card-body bg-secondary">
                        <h4 class="card-title">{{ str_limit($post->title, 70) }}</h4>
                        <p class="card-text">{{ str_limit($post ->user->username, 20) }}</p>
                        <p class="card-text">{{ str_limit($post->direction, 20) }}</p>
                        <p class="card-text">{{ str_limit($post->body, 650) }}</p>
                        <p class="card-text">{{ $post->updated_at->format('Y年m月d日 H:i') }}</p>
                        
                        {{-- ログインしているユーザーと投稿者のIDが一致したら編集ボタン、削除ボタンを表示 --}}
                        @if(Auth::id() === ($post->user_id))
                        <a href="{{ action('Admin\PostController@edit', ['id' => $post->id]) }}" type="button" class="btn btn-primary">編集</a>
                        <a href="{{ action('Admin\PostController@delete',['id' => $post->id]) }}" type="button" class="btn btn-primary">削除</a>
                        @endif
                    </div>
                </div>
            </div>
                @php $count +=1 @endphp
            @if($count > 4)
        </div>
        <hr color="#c0c0c0">
            <div class = "row">
                @php $count = 1 @endphp
            @endif
            @endforeach
            </div>
        
    </div>
@endsection