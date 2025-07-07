@extends('admin.admin_master')
@section('admin')


<div class="row">
<div class="col-xl-12">
    <div class="card">
    <div class="card-header border-bottom justify-content-between d-flex flex-wrap align-items-center gap-2">
    <div class="flex-shrink-0 d-flex align-items-center gap-2">
        <div class="position-relative">
           <h3>All Plans</h3>
        </div>
    </div>

    <a href="{{ route('add.plans') }}" class="btn btn-primary"><i class="ti ti-plus me-1"></i>Add Plans</a>
</div>


        <div class="card-body">
            
            <div class="table-responsive-sm"> 
    <table class="table table-striped mb-0">
        <thead>
            <tr>
                <th>Sl</th>
                <th>Name </th>
                <th>Token Limit</th>
                <th>Template Limit</th>
                <th>Price</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($plan as $key=> $item) 
            <tr>
                <td>{{ $key+1 }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->token_limit }}</td>
                <td>{{ $item->template_limit }}</td>
                <td>{{ $item->price }}</td>
                <td class="text-muted">
<a href="{{ route('edit.plans',$item->id) }}" class="link-reset fs-20 p-1"> <i class="ti ti-pencil"></i></a>
<a href="javascript: void(0);" class="link-reset fs-20 p-1"> <i class="ti ti-trash"></i></a>
                </td>
            </tr>
         @endforeach
                
            
        </tbody>
    </table>
            </div> <!-- end table-responsive-->
        </div> <!-- end card body-->
    </div> <!-- end card -->
</div><!-- end col-->


</div>






@endsection