<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;

class BlogController extends Controller
{

    public function getIndex () {
      //Displays 10 per page.
      $posts = Post::paginate(10);
      return view('blog.index')->withPosts($posts);

    }

    //Pass in the parameter slug from routes.
    //Allows users to enter slug as a URL to access post.
    public function getSingle($slug) {
      //Fetch from the DB based on slug. Display the first slug.
      $post = Post::where('slug', '=', $slug)->first();

      // Return the view and pass in the post object.
      return view('blog.single')->withPost($post);

    }


}
