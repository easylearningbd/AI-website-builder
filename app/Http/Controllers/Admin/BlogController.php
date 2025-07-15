<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Blog;
 
class BlogController extends Controller
{
    public function AllBlog(){
        $blogs = Blog::latest()->get();
        return view('admin.backend.blog.all_blog',compact('blogs'));
    }
    //End Method 

    public function AddBlog(){
        return view('admin.backend.blog.add_blog');
    }
    //End Method 

    public function GenerateBlog($title){

    }
    //End Method 






}
