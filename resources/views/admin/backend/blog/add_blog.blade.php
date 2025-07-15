@extends('admin.admin_master')
@section('admin')

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
      </div>

    </div>


        </div> 
    </div> 
</div> 






@endsection