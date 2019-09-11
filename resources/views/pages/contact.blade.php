@extends('main')
@section('title', '| Contact')
@section('content')
  <div class="row">
    <div class="col-md-12">
      <h1>contact me</h1>
      <hr>
      {!! Form::open(['url' => 'contact', 'method' => "POST"]) !!}
      {{ csrf_field() }}

      {{ Form::label('email', 'Email:') }}
      {{ Form::email('email', null, ['class' => 'form-control']) }}

      {{ Form::label('subject', 'Subject:') }}
      {{ Form::text('subject', null, ['class' => 'form-control']) }}

      {{ Form::label('message', 'Message:') }}
      {{ Form::textarea('message', null, ['class' => 'form-control']) }}

      {{ Form::submit('Send Message', ['class' => 'btn btn-primary form-spacing-top']) }}

      {!! Form::close() !!}

    </div>
  </div>
@endsection
