<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;

class ProjectController extends Controller
{
    public function AllProjects(){
        $projects = Auth::user()->projects()->latest()->get();
        return view('admin.backend.projects.index',compact('projects'));
    }
    // End Method 

    public function CreateProject(){
        return view('admin.backend.projects.create');
    }
      // End Method 


} 
