@extends('admin.admin_master')
@section('admin')

<!-- Include Quill CSS -->
<link href="https://cdn.quilljs.com/1.3.7/quill.snow.css" rel="stylesheet">

<!-- Include Quill JS -->
<script src="https://cdn.quilljs.com/1.3.7/quill.js"></script>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header border-buttom border-dashed d-flex align-items-center">
        <h4 class="header-title">Blog Post Generator</h4>
            </div>

    <div class="card-body">
        <div class="row g-2">
        <div class="mb-3 col-md-6">
            <label for="input2" class="form-label">Blog Title</label>
            <input class="form-control" type="text" id="blog-title" placeholder="Enter blog title"> 
        </div>
    
        <div class="col-md-6 mt-4">
           <label for="input2" class="form-label"> </label>
           <button class="btn btn-primary">Generate</button> 
        </div>

        <div class="mb-3 col-md-12">
            <div id="editor" style="height :400px;" > </div> 
        </div>

        <div class="mb-3 col-md-6">
             <label for="category" class="form-label">Category </label>
            <select name="category" id="category" class="form-select">
                <option value="" selected="">Select Category</option>
                <option value="AI">AI</option>
                <option value="Software">Software</option>
                <option value="ChatGpt">ChatGpt</option>
                <option value="Gemini">Gemini</option>
                <option value="Claude">Claude</option> 
            </select>
        </div>

       <div class="mb-3 col-md-6">
            <label for="input2" class="form-label">Image</label>
            <input class="form-control" name="image" type="file" id="image" > 
        </div> 
      </div>

    <button class="btn btn-info">Save to Database</button>

    </div>


        </div> 
    </div> 
</div> 


<script>
     var quill = new Quill('#editor', {
        theme: 'snow',
        modules: {
            toolbar: [
                ['bold', 'italic', 'underline', 'link'],
                [{'list': 'ordered'}, {'list': 'bullet'}],
                ['image']
            ]
        }
    });


</script>



@endsection