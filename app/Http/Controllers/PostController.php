<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Post;
use App\Category;
use App\Tag;
use Session;
use Purifier;
use Image;
use Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct() {
       $this->middleware('auth');
     }

    public function index()
    {
        // create a variable and store all the blog posts in it.
        // OrderBy and paginate enables all posts are paginated and ordered with the latest first.
        $posts = Post::orderBy('id', 'desc')->paginate(10);
        // return a view and pass in the above variable
        return view ('/posts/index')->withPosts($posts);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $categories = Category::pluck('name', 'id');
        $tags = Tag::all();
        return view('/posts/create')->withCategories($categories)->withTags($tags);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //

        $this->validate($request, array(
          'title'       => 'required|max:255',
          'slug'        => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
          'category_id' => 'required|integer',
          'body'        => 'required',
          // 'featured_image' => 'sometimes|image'

        ));

        $post = new Post;

        $post->title = $request->title;
        $post->slug = $request->slug;
        $post->category_id = $request->category_id;
        $post->body = Purifier::clean($request->body);

        if ($request->hasFile('featured_image')) {
          $image = $request->file('featured_image');
          $filename = time() . '.' . $image->getClientOriginalExtension();
          $location = public_path('images/' . $filename);
          Image::make($image)->resize(800, 400)->save($location);

          $post->image = $filename;
        }

        $post->save();

        // Passing the tag array into the sync to associate to a specific post.
        // False tells it not add the association and not override.
        $post->tags()->sync($request->tags, false);

        Session::flash('success', 'The blog post was successfully saved!');

        return redirect()->route('posts.show', $post->id);



    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $post = Post::find($id);
        return view('/posts/show')->withPost($post);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $post = Post::find($id);
        $categories = Category::all();
        $cats = [];
        foreach ($categories as $category) {
          $cats[$category->id] = $category->name;
        }

        $tags = Tag::all();
        $tags2 = array();
        foreach ($tags as $tag) {
          $tags2[$tag->id] = $tag->name;
        }
        return view ('posts.edit')->withPost($post)->withCategories($cats)->withTags($tags2);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //Checking to see if the slug has been changed, as the slug has to be unique.
        //Comparing to see if the slug remains the same.
        //Grab the new post and use the if statement to see if the slugs equal, remain the same. Everything except the slug is validated.
        $post = Post::find($id);

        if ($request->input('slug') == $post->slug) {
          $this->validate($request, array(
            'title' => 'required|max:255',
            'category_id' => 'required|integer',
            'body' => 'required'
          ));
        }
        //If it has changed, the new slug requires validating.
         else {
          $this->validate($request, array(
            'title' => 'required|max:255',
            'slug' => 'required|alpha_dash|min:5|max:255|unique:posts,slug',
            'category_id' => 'required|integer',
            'body' => 'required',
            // 'featured_image' => 'image'

          ));
       }

        $post = Post::Find($id);

        $post->title = $request->input('title');
        $post->slug = $request->input('slug');
        $post->category_id = $request->input('category_id');
        $post->body = Purifier::clean($request->input('body'));

        // if ($request->hasFile('featured_image')) {
        //   // Add a new photo
        //   $image = $request->file('featured_image');
        //   $filename = time() . '.' . $image->getClientOriginalExtension();
        //   $location = public_path('images/' . $filename);
        //   Image::make($image)->resize(800, 400)->save($location);
        //
        //   // Find old image
        //   $oldImage = $post->image;
        //
        //   // Update the database
        //   $post->image = $filename;
        //
        //   // Delete old photo
        //   Storage::delete($oldImage);
        //
        // }

        $post->save();

        // If else allowing the edit form to enter an empty tag field.
        If (isset($request->tags)) {
          $post->tags()->sync($request->tags);

        } else {
          $post->tags()->sync(array());
        }


        Session::flash('success', 'This post was successfully saved.');

        return redirect()->route('posts.show', $post->id);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = Post::find($id);
        $post->tags()->detach();

        $post->delete();

        Session::flash('success', 'The post was successfully deleted.');
        return redirect()->route('posts.index');




    }
}
