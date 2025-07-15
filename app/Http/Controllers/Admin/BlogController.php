<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Blog;
use App\Services\ClaudeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use GuzzleHttp\Client; 

class BlogController extends Controller
{

    private string $apiKey;
    private string $baseUrl = 'https://api.anthropic.com';

    public function __construct(){
        $this->apiKey = config('services.claude.api_key');
        Log::info('Cladue API KEY BLOG: ' . $this->apiKey);
    }



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
        if (!this->apiKey) {
            return response()->json(['success' => false, 'message' => 'Claude API Key is not configuerd'],500);
        }
      
    $client = new Client();

    try {
        

    } catch (\Throwable $th) {
       
    }


    }
    //End Method 






}
