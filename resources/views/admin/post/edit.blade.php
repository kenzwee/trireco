@extends('layouts.admin')
@section('title', '投稿内容の編集')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>投稿内容編集</h2>
                <form action="{{ action('Admin\PostController@update') }}" method="post" enctype="multipart/form-data">
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2" for="image">画像</label>
                        <div class="col-md-10 ">
                            <input type="file" class="form-control-file" name="image">
                            {{-- ビューに現在設定中の画像を表示 --}}
                            <img class = "col-md-10" src="{{secure_asset('storage/image/'.$post_form->image_path)}}">
                            <div class="form-text text-info">
                                設定中: {{ $post_form->image_path }}
                            </div>
                            <div class="form-check">
                                <label class="form-check-label">
                                    <input type="checkbox" class="form-check-input" name="remove" value="true">画像を削除
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="direction">方面</label>
                        <div class="dropdown col-md-10">
                            <select name="direction" id="direction-select" value="{{ $post_form->direction }}">
                                <option value="">--方面を選んでください--</option>
                                <option value="north_america" {{ ($post_form->direction == "north_america") ? "selected" : "" }}>北アメリカ</option>
                                <option value="south_america" {{ ($post_form->direction == "south_america") ? "selected" : "" }}>南アメリカ</option>
                                <option value="asia" {{ ($post_form->direction == "asia") ? "selected" : "" }}>アジア</option>
                                <option value="europe" {{ ($post_form->direction == "europe") ? "selected" : "" }}>ヨーロッパ</option>
                                <option value="africa" {{ ($post_form->direction == "africa") ? "selected" : "" }}>アフリカ</option>
                                <option value="oceania" {{ ($post_form->direction == "oceania") ? "selected" : "" }}>オセアニア</option>
                                <option value="middle_east" {{ ($post_form->direction == "middle_east") ? "selected" : "" }}>中東</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="title">タイトル</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title" value="{{ $post_form->title }}">
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-md-2" for="body">本文</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="body" rows="20">{{ $post_form->body }}</textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-10">
                            <input type="hidden" name="id" value="{{ $post_form->id }}">
                            {{ csrf_field() }}
                            <input type="submit" class="btn btn-primary" value="更新">
                        </div>
                    </div>
                </form>
                <div class="row mt-5">
                    <div class="col-md-4 mx-auto">
                        <h2>編集履歴</h2>
                        <ul class="list-group">
                            @if($post_form ->histories != NULL)
                                @foreach($post_form->histories as $history)
                                <li class="list-group-item">{{ $history->edited_at }}</li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection