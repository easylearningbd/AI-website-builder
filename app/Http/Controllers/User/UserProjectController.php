<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;
use App\Services\ClaudeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class UserProjectController extends Controller
{

    use AuthorizesRequests;
    private ClaudeService $claudeService;

    public function __construct(ClaudeService $claudeService){
        $this->claudeService = $claudeService;
    }
    //End Method 



     public function UserAllProjects(){
        $projects = Auth::user()->projects()->latest()->get();
        return view('client.backend.projects.index',compact('projects'));
    }
    // End Method 


}
