@extends('admin.admin_master')
@section('admin')

<div class="min-vh-100 bg-light">
    <div class="bg-white shadow-sm border-bottom">
        <div class="container-fluid">
            <div class="row py-3 align-items-center">
                <div class="col">
            <h1 class="h4 mb-0 text-dark">{{ $project->name }}</h1>
            <p class="text-muted mb-0">{{ $project->description }}</p>
                </div>
            <div class="col-auto">
                <div class="d-flex gap-2">
                    <button class="btn btn-primary">Preview</button>
                    <a href="" class="btn btn-success">Export</a>
                </div> 
            </div> 
            </div> 
        </div> 
    </div>


<div class="container-fluid">
    <div class="row h-100">
        <!---- Chat Panel Start  --->
    <div class="col-4 border-end bg-white">
        <div class="card h-100">
            <div class="card-header bg-light">
        <h2 class="h6 mb-0 text-dark">AI Assistant</h2>
        <p class="text-muted mb-0 small">Tell me what you want to build or modify</p>
            </div>

<div id="chat-history" class="card-bory p-3 flex-grow-1 overflow-auto" style="max-height: calc(100vh - 200px);">
    @if ($project->chat_history)
     @foreach ($project->chat_history as $message)
     <div class="chat-message {{ $message['role'] === 'user' ? 'text-end' : 'text-start'}} mb-2">
        <div class="d-inline-block {{ $message['role'] === 'user' ? 'bg-primary text-white ms-4' : 'bg-light text-dark me-4'}} p-2 rounded">
            {{ $message['content'] }}
        </div>
        <div class="text-muted small mt-1">
            {{ \Carbon\Carbon::parse($message['timestamp'])->format('H:i') }}
        </div> 
     </div> 
     @endforeach 

    @else
    <div class="text-center text-muted mt-4">
        <p>Start a conversation to generate your website!</p>
        <p class="small mt-2">Try : "Cerate a modern landing page for a teach startup"</p> 
    </div> 
        
    @endif  
</div>

<div class="card-footer bg-light">
    <form id="chat-form" class="d-flex gap-2">
        @csrf
    <input type="text" id="chat-input" placeholder="Describe what you want to change" class="form-control flex-grow-1" required>
    <button type="submit" id="send-button" class="btn btn-primary">Send</button>
    </form> 
</div>




        </div>

    </div>


        <!---- Chat Panel End   --->

    </div> 
</div>






</div>





@endsection