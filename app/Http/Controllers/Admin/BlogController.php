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
use Illuminate\Support\Facades\Log;

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

        $response = $client->post($this->baseUrl . '/vi/messages',[
            'headers' => [
                'x-api-key' => $this->apiKey,
                'content-type' => 'application/json',
                'anthropic-version' => '2023-06-01'
        ],
        'json' => [
            'model' => 'claude-3-5-sonnet-20240620',
            'max_tokens' => 2000,
            'messages' => [
                [
                    'role' => 'user',
                    'content' => "Write a complete, SEO-optimized blog post with the title: '$title'. Include an introduction, 3-5 sections with headings, and a conclusion. Suggest placeholder image URLs where relevant (e.g., https://placehold.co/600x400)."
                ]
            ],
        ],
        'timeout' => 30,
    ]);

    $data = json_decode($response->getBody(), true);
    if (isset($data['content']) && is_array($data['content']) && !empty(
        $data['content'][0]['text'])) {
        $content = $data['content'][0]['text'];
    } else {
        $content = 'Error generating contant: Invalid resosne format';
    }
     
    return response()->json(['success' => true, 'content' => $content]);

    } catch (\Exception $e) {
       return response()->json(['success' => false, 'message' => 'Filed to genearate blog' . $e->getMessage()], 500);
    } 

    }
    //End Method 






}
