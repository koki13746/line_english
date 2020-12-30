@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="card">
      <div class="card-header">{{ $post->user->name }}</div>
      <div class="card-body">
        <p class="card-text">{{ $post->body }}</p>
      </div>
    </div>
  </div>

  <div class="container mt-4">
    @foreach($post->replies as $reply)
      <div class="card">
        <div class="card-header">{{ $reply->user->name }}</div>
        <div class="card-body">
          <p class="card-text">{{ $reply->body }}</p>
        </div>
      </div>
    @endforeach
  </div>
@endsection