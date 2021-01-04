<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WordController extends Controller
{
    public function index()
    {
        return view('word');
    }

    public function edit()
    {
        return view('word');
    }

    public function update()
    {
        return view('word');
    }
}

/*
public function show($id)
    {
        $user = User::find($id); // ユーザーID:1 のユーザー情報を取得して $user 変数に代入する
        return view('users.show', ['user' => $user]);
    }

    public function edit()
    {
        $user = Auth::user();
        return view('users.edit', ['user' => $user]);
    }

    public function update(UpdateRequest $request)
    {
        $user = Auth::user();
        $user->fill($request->all());
        $user->save();
        return redirect()->back()->with(['message'=>'更新しました']);
    }
*/