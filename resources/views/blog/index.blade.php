@extends('main')
@section('title', '| Blog')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>all blog posts</h1>
    </div>
  </div>

  @foreach ($posts as $post)
    <div class="row">
      <div class="col-md-12">
        <h3>{{ $post->title }}</h3>
        <h5>Published: {{ date('M j Y', strtotime($post->created_at)) }}</h5>
        <p>{{ substr(strip_tags($post->body), 0, 250) }}{{ strlen(strip_tags($post->body)) > 250 ? '...' : "" }}</p>
        <a href="{{ route('blog.single', $post->slug) }}" class="btn btn-primary">Read More</a>
        <hr>
      </div>
    </div>
  @endforeach

@endsection
