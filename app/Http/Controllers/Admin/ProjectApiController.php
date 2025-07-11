<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Project;
use App\Services\ClaudeService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Log;

class ProjectApiController extends Controller
{
    use AuthorizesRequests;
    private ClaudeService $claudeService;

    public function __construct(ClaudeService $claudeService){
        $this->claudeService = $claudeService;
    }
    //End Method 


    public function Chat(Request $request, Project $project){

        $this->authorize('update',$project);

        $request->validate([
            'message' => 'required|string'
        ]);

    try {
       $context = [
            'html_content' => $project->html_content,
            'css_content' => $project->css_content,
            'js_content' => $project->js_content,
       ];

       $generated = $this->claudeService->generateWebsite($request->message, $context);

        $project->update([
            'html_content' => $generated['html'],
            'css_content' => $generated['css'],
            'js_content' => $generated['js'],
        ]);

        // Add to check history 

        $project->addChatMessage('user',$request->message);
        $project->addChatMessage('assistant', 'website updated successfully!');        

        Log::info('Webtie generated successfully', ['project_id' => $project->id]);
    
        return response()->json([
            'success' => true,
            'project' => $project->fresh(),
            'generated' => $generated
        ]);
    } catch (\Exception $e) {
        return response->sjon([
            'success' => false,
            'message' =>  $e->getMessage()
        ],500);
    } 

    }
    //End Method 

 public function getPreview(Project $project){
    Log::info('Preview data request', ['project_id' => $project->id]);

    $this->authorize('view',$project);

    $html = $project->html_content ?? '<html><body></body><h1>No Content Yet</h1><p>Start a conversation to generate your website!</p></html>';
    $css = $project->css_content ?? '';
    $js = $project->js_content ?? '';

    // Ensure a complete html docucment 
    if (!str_contains($html, '<html>')) {
        $html = "<!DOCTYPE html><html><head><title>Preview - {$project->name} </title></head><body>$html</body></html>";
    }
    if ($css) {
       $html = str_replace('</head>',"<style>$css</style></head>", $html);
    }

    if ($js) {
       $html = str_replace('</body>',"<script>$js</script></body>", $html);
    }

    return response()->json(['html' => $html]);  
}
 //End Method 







}
