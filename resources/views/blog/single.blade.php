@extends('main')
@section('title', "| $post->title")
@section('content')

  <div class="row">
    <div class="col-md-12">
      <h1>{{ $post->title }}</h1>
      <p>{!! $post->body !!}</p>
      <hr>
      <!-- Object of the Post model, accessing the properties of the method (category())
    This provides access to all the columns in the DB. -->
      <h4>Posted In: {{ $post->category->name }}</h4>
    </div>
  </div>

  <div class="row">
    <div class="col-md-12">
      <h3 class="comments-title"><span class="glyphicon glyphicon-comment"></span>{{ $post->comments()->count() }} Comments</h3>
      <!-- Loop thorugh comments -->
      @foreach($post->comments as $comment)
      <div class="comment">
        <div class="author-info">
          <img src="{{ "https://www.gravatar.com/avatar/" . md5(strtolower(trim($comment->email))) . "?s=50&d=mm" }}" class="author-image">
          <div class="author-name">
            <h4>{{ $comment->name }}</h4>
            <p class="author-time">{{ date('M j Y, H:i', strtotime($comment->created_at)) }}</p>
          </div>
        </div>
        <div class="comment-content">
          {{ $comment->comment }}
        </div>
      </div>
      @endforeach
    </div>
  </div>

  <div class="row">
    <div id="comment-form" class="col-md-12" style="margin-top:50px;">
      {{ Form::open (['route' => ['comments.store', $post->id, 'method' => 'POST']]) }}

        <div class="row">
          <div class="col-md-6">
            {{ Form::label('name', 'Name:') }}
            {{ Form::text('name', null, ['class' => 'form-control']) }}
          </div>
          <div class="col-md-6">
            {{ Form::label('email', 'Email:') }}
            {{ Form::text('email', null, ['class' => 'form-control']) }}
          </div>
          <div class="col-md-12">
              {{ Form::label('comment', 'Comment:') }}
              {{ Form::textarea('comment', null, ['class' => 'form-control', 'rows' => '5']) }}

              {{ Form::submit('Add Comment', ['class' => 'btn btn-success btn-block', 'style' => 'margin-top:15px;']) }}
          </div>
        </div>
      </div>
    </div>

@endsection
