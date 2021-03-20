{{-- layouts/admin.blade.phpを読み込む --}}
@extends('layouts.admin')


{{-- admin.blade.phpの@yield('title')に'投稿の新規作成'を埋め込む --}}
@section('title', '投稿の新規作成')

{{-- admin.blade.phpの@yield('content')に以下のタグを埋め込む --}}
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <h2>投稿新規作成</h2>
                <form action="{{ action('Admin\PostController@create') }}" method="post" enctype="multipart/form-data">
                    <input type="hidden" name="user_id" value="{{ Auth::id() }}"> 
                    @if (count($errors) > 0)
                        <ul>
                            @foreach($errors->all() as $e)
                                <li>{{ $e }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <div class="form-group row">
                        <label class="col-md-2">投稿者</label>
                        <div class="col-md-10">
                                <a>
                                    {{ Auth::user()->username }}
                                </a>
                        </div>
                    </div>                 
                    <div class="form-group row">
                        <label class ="col-md-2">方面</label>
                        <div class="dropdown col-md-10">
                             <select name="direction" id="direction-select">
                                <option value="">--方面を選んでください--</option>
                                <option value="north_america">北アメリカ</option>
                                <option value="south_america">南アメリカ</option>
                                <option value="asia">アジア</option>
                                <option value="europe">ヨーロッパ</option>
                                <option value="africa">アフリカ</option>
                                <option value="oceania">オセアニア</option>
                                <option value="middle_east">中東</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class ="col-md-2">画像</label>
                        <div class="col-md-10">
                                <input type="file" class="form-control-file" name="image">
                        </div>
                    </div>
                    
                    <div class="form-group row">
                        <label class="col-md-2">タイトル</label>
                        <div class="col-md-10">
                            <input type="text" class="form-control" name="title" value="{{ old('title') }}">
                        </div>
                    </div>

                    <div class="form-group row">
                        <label class="col-md-2">本文</label>
                        <div class="col-md-10">
                            <textarea class="form-control" name="body" rows="20">{{ old('body') }}</textarea>
                        </div>
                    </div>
               
                        {{ csrf_field() }}
                        <input type="submit" class="btn btn-primary" value="投稿">
                </form>
            </div>
        </div>
    </div>
@endsection
