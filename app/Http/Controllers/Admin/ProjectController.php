<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;
use App\Services\ClaudeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProjectController extends Controller
{

    use AuthorizesRequests;
    private ClaudeService $claudeService;

    public function __construct(ClaudeService $claudeService){
        $this->claudeService = $claudeService;
    }
    //End Method 


    public function AllProjects(){
        $projects = Auth::user()->projects()->latest()->get();
        return view('admin.backend.projects.index',compact('projects'));
    }
    // End Method 

    public function CreateProject(){
        return view('admin.backend.projects.create');
    }
      // End Method 

    public function StoreProject(Request $request){

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'api_prompt' => 'nullable|string',
        ]);

        // Create the project 
        $project = Auth::user()->projects()->create([
            'name' => $request->name,
            'description' => $request->description
        ]);

      // If there have any API Prompt is provided then it will be generate the website..




    }
    // End Method 


} 
