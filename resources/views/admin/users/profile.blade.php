@extends('admin.layout.index')

@section('title','Show Users')
@section('contents')

<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Users</h1>
    <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
        For more information about DataTables, please visit the <a target="_blank"
            href="https://datatables.net">official DataTables documentation</a>.</p>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">DataTables Example</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Avatar</th>
                            <th>Vertical Active</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Avatar</th>
                            <th>Vertical Active</th>
                            <th>Action</th>
                        </tr>
                    </tfoot>
                    <tbody>
                        @foreach($users as $item)
                        <tr>
                            <td>{{ $item->id }}</td>
                            <td>
                                <a href="{{route('admin.users.show',['id'=>$item->id])}}">{{$item->name}}</a>
                            </td>
                            <td>{{ $item->email }}</td>
                            <td>
                                <img src="{{ $item->image }}" alt="" width="50px;" height="50px;">
                            </td>
                            <td>{{ $item->email_verified_at }}</td>

                            <td class="center" style="display:flex;">
                                {{-- <a class="btn btn-warning" href=" {{route('admin.users.edit',['category'=>$item->id])}}">
                                    <i class="fa fa-pencil fa-fw"></i>
                                </a> --}}
                                <a class="btn btn-danger" style="margin-left: 5px;"  data-toggle="modal" data-target="#confirm_delete_{{$item->id}}">
                                    <i class="fa fa-trash-o  fa-fw"></i>
                                </a>

                                <div class="modal fade"  id="confirm_delete_{{$item->id}}" tabindex="-1" role="dialog">
                                    <div class="modal-dialog" role="document">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <h4 class="modal-title">Bạn có muốn xoá hay không ?</h4>
                                        </div>
                                        <div class="modal-body">
                                        <p>Xác nhận ?</p>
                                        </div>
                                        <div class="modal-footer">
                                            <form action="{{route('admin.users.delete',['user'=> $item->id])}}" method="post">
                                                @csrf
                                                <button type="button" class="btn btn-default" data-dismiss="modal">No</button>
                                                <button type="submit" class="btn btn-primary">Yes</button>
                                            </form>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

@endsection
