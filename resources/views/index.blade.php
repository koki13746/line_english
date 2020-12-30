@extends('layouts.app')

@section('content')
  <div class="container">
    @foreach($posts as $post)
      <div class="card">
        <div class="card-header">{{ $post->user->name }}</div>
        <div class="card-body">
          <p class="card-text">{{ $post->body }}</p>
          @if(Auth::id() === $post->user_id)
            <form method="POST" action="{{ route('posts.delete', $post->id) }}">
                @csrf
                <button type="submit" class="btn btn-danger">削除</button>
            </form>
          @endif
        </div>
      </div>
    @endforeach
  </div>
@endsection
