@extends('main')

@section('title', '| Create New Post')

@section('stylesheets')
  {!! Html::style('css/parsley.css') !!}
  {!! Html::style('css/select2.min.css') !!}
  <script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/5/tinymce.min.js"></script>

  <script>
    tinymce.init({
      selector: 'textarea'
    });
  </script>

@endsection

@section('content')

  <div class="row">
    <div class="col-md-12">
      <h1>create new blog post</h1>
      <hr>

      {!! Form::open(array('route' => 'posts.store', 'data-parsley-validate' => '', 'files' => true)) !!}
        {{ Form::label('title', 'Title:') }}
        {{ Form::text('title', null, array('class' => 'form-control', 'required' => '')) }}

        {{ Form::label('slug', 'Slug:') }}
        {{ Form::text('slug', null, array('class' => 'form-control', 'required' => '', 'minlength' => '5', 'maxlength' => '255')) }}

        {{ Form::label('category_id', 'Category:') }}
        {!! Form::select('category_id', $categories, null, ['class' => 'form-control']) !!}﻿

        {{ Form::label('tags', 'Tags:') }}
        <select class="form-control select2-multi" name="tags[]" multiple='multiple'>
          @foreach($tags as $tag)
            <option value="{{ $tag->id }}">{{ $tag->name }}</option>
          @endforeach
        </select>

        {{ Form::label('body', 'Post:', ['class' => 'form-spacing-top']) }}
        {{ Form::textarea('body', null, array('class' => 'form-control')) }}

        {{ Form::submit('Create Post', array('class' => 'btn btn-success btn-lg btn-block', 'style' => 'margin-top:20px;')) }}
      {!! Form::close() !!}

    </div>
  </div>



@endsection

@section('scripts')

{!! Html::script('js/parsley.min.js') !!}
{!! Html::script('js/select2.min.js') !!}

<script type="text/javascript">
  $('.select2-multi').select2();
</script>

@endsection
