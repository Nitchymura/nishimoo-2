<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;
use App\Models\CategoryPost;

class PostController extends Controller
{
    private $category;
    private $post;

    public function __construct(Category $category, Post $post){
        $this->category = $category;
        $this->post = $post;
    }
    
    public function create(){
        $all_categories = $this->category->all();
        return view('user.posts.create', compact('all_categories'));
    }

    public function store(Request $request){
        $request->validate([
            'categories' => 'required|array|between:1,3',
            'description' => 'required|max:1000',
            'image' => 'required|max:1048|mimes:jpg,jpeg,png,gif'
        ]);

        $this->post->description = $request->description;
        $this->post->user_id = Auth::user()->id;
        $this->post->image = "data:image/".$request->image->extension().";base64,".base64_encode(file_get_contents($request->image));
        $this->post->save();

        // $category_posts = [];
        // foreach($request->categories as $category_id){
        //     $category_posts [] = ['category_id'=>$category_id];
        // }
        // $this->post->categoryPosts()->createMany($category_posts);

        foreach($request->categories as $category_id){
            CategoryPost::create([
                'category_id' => $category_id,
                'post_id' => $this->post->id
            ]);
        }
        return redirect()->route('home');
    }

    public function show($id){
        $post_a = $this->post->findOrFail($id);

        return view('user.posts.show')->with('post', $post_a);
    }

    public function edit($id){
        $all_categories = $this->category->all();
        $post_a = $this->post->findOrFail($id);

        $selected_categories = [];
        foreach($post_a->categoryPosts as $category_post){
            $selected_categories [] = $category_post->category_id;
        }
        return view('user.posts.edit')->with('post', $post_a)
                                        ->with('all_categories', $all_categories)
                                        ->with('selected_categories', $selected_categories);
    }

    public function update(Request $request, $id){
        $request->validate([
            'categories' => 'required|array|between:1,3',
            'description' => 'required|max:1000',
            'image' => 'max:1048|mimes:jpg,jpeg,png,gif'
        ]);
        $post_a = $this->post->findOrFail($id);

        $post_a->description = $request->description;
        if($request->image)
            $post_a->image = "data:image/".$request->image->extension().";base64,".base64_encode(file_get_contents($request->image));
        $post_a->save();

        $post_a->categoryPosts()->delete();

        foreach($request->categories as $category_id){
            CategoryPost::create([
                'category_id' => $category_id,
                'post_id' => $post_a->id
            ]);
        }
        return redirect()->route('home');
    }

    public function delete($id){
        // $this->post->destroy($id);
        $this->post->findOrFail($id)->forceDelete();
        return redirect()->route('home');
    }
}
