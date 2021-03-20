<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use App\Http\Controllers\Controller;
use App\Post;
use App\History;


use Carbon\carbon;

class PostController extends Controller
{
    public function add()
    {
        return view('admin.post.create');
    }
    
    public function create(Request $request)
    {
        //validationを行う
        $this->validate($request, Post::$rules);
        
        $post = new Post;
        $form = $request->all();
        
        //フォームから画像が送信されてきたら、保存して$post->image_pathに画像のパスを保存する
        if(isset($form['image'])){
        $path = $request->file('image')->store('public/image');
        $post->image_path = basename($path);
        } else {
            $photo->image_path = null;
        }     
        
        //フォームから送信されてきた_tokenを削除
        unset($form['_token']);
        //フォームから送信されてきたimageを削除
        unset($form['image']);
        
        //データベースに保存
        $post->fill($form);
        $post->save();
        
        return redirect('admin/post/create');
    }
    
    public function index(Request $request)
    {   
        $cond_title = $request->cond_title;
        if($cond_title != ''){
            //検索されたら検索結果を取得する
            $posts = Post::where('title', $cond_title)->get();
                
        } else {
            //それ以外は全てのニュースを取得する
            $posts = Post::all()->sortByDesc('updated_at');
        }
        
        return view('admin.post.index', ['posts' => $posts, 'cond_title' => $cond_title]);
    }
    
    public function edit(Request $request)
    {
        $post = Post::find($request->id);
        if(empty($post)){
            abort(404);
        }
        
        return view('admin.post.edit', ['post_form' => $post]);
    }
    
    public function update(Request $request)
    {
        //validationをかける ::→クラス変数を呼び出し
        $this->validate($request, Post::$updateRules);
        //Post modelからデータを取得
        $post = Post::find($request->id);
        //送信されてきたフォームデータを格納
        $post_form = $request->all();
        
        //画像を削除した場合はimage_pathも削除する
        if($request->remove == 'ture'){
            $post_form['image_path'] = null;
        //画像が更新されたら。。
        }elseif($request->file('image')){
            //上はpublic/imageに画像を保存
            //下はファイル名からpathを作成して(左辺)、image_pathに（右辺に）代入
            $path = $request->file('image')->store('public/image');
            $post_form['image_path'] = basename($path);
        }else{
            //画像は変わってない時
            $post_form['image_path'] = $post->image_path;
        }
        
        unset($post_form['image']);
        //削除というチェックボックスからチェックを外す（初期化してる）
        unset($post_form['remove']);
        unset($post_form['_token']);
        
        //該当するデータを上書き保存
        $post->fill($post_form)->save();
        
        $history = new History;
        $history ->post_id = $post->id;
        $history ->edited_at = Carbon::now();
        $history ->save();
        
        return redirect('admin/post/');
    }
    
    public function delete(Request $request)
    {
        //該当するPostmodelを取得
        $post = Post::find($request->id);
        //削除する
        $post->delete();
        return redirect('admin/post/');
    }
}
