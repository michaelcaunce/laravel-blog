@extends('main')
@section('title', '| Homepage')
@section('content')

  <div class="row">
    <div class="col-md-6">
      <h1>welcome to all things web</h1>
      <p>Based in the North West, I am a recent graduate from Edge Hill with aspirations of becoming a front-end web developer. I have recently completed a BSc in Web Design & Development, where I achieved an overall first class classification.

        I am an ambitious, personable and driven individual with a track record demonstrating passion, resilience and determination, shown by recently being awarded the ‘Academic Achievement Award’. Over the course of my degree, I have acquired knowledge and experience in HTML5, CSS3, JavaScript, PHP, Laravel, Ember, version control, Gulp, Sass, and mySQL.

        I am now actively seeking a junior or graduate role in web design and development, where I can demonstrate my passion for all things creative and technological. As an aspiring web developer, I am eager to utilise my interpersonal skills and enhance the foundation of knowledge I have acquired throughout my degree.</p>
    </div>
    <div class="col-md-5 col-md-offset-1">
      <h1>recent blogs</h1>

      @foreach($posts as $post)
        <div class="post">
          <h3>{{ $post->title }}</h3>
          <p>{{ substr(strip_tags($post->body), 0, 300) }}{{ strlen(strip_tags($post->body)) > 300 ? "..." : "" }}</p>
          <a href="{{ route('blog.single', $post->slug) }}" class="btn btn-primary">Read More</a>
        </div>
        <hr>

      @endforeach
    </div>
  </div>
@endsection
