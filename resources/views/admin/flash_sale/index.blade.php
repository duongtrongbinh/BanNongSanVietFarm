@extends('admin.layout.master')
@php
    $created = session('created');
@endphp
@section('content')
    <div class="pagetitle">
        <h1>Flash Sales</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Flash Sales</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">
                            <a href="{{ route('flash-sales.create') }}">
                                <i class="bi bi-plus-circle"></i>
                                Create Sale
                            </a>
                        </h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Applicable product</th>
                                <th scope="col">is active</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($flashSale))
                                @foreach($flashSale as $items)
                                    <tr>
                                        <th>{{ $items->start_date }}</th>
                                        <td>{{ $items->end_date }}</td>
                                        <td>
                                        @foreach($items->flashSaleProducts as $items2)
                                            <span class="badge bg-secondary">{{ $items2->product->name}}</span>
                                        @endforeach
                                        </td>
                                        <td>@if($items->status == 1)
                                                <span class="badge bg-success">yes</span>
                                            @else
                                                <span class="badge bg-danger">no</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex" style="gap: 10px">
                                                <a href=" {{ route('flash-sales.show',$items->id) }}"><button class="btn btn-outline-primary">Detail</button></a>
                                                <a href="{{ route('flash-sales.edit',$items->id) }}"><button class="btn btn-outline-warning">Edit</button></a>
                                                <form action="{{ route('flash-sales.destroy', $items->id) }}" method="post" class="deleteFlashSale" data-url="{{ route('flash-sales.destroy', $items->id) }}">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-outline-danger">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <!-- End Table with stripped rows -->
                        <div class="pagination justify-content-center">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/assets/js/showMessage/message.js') }}"></script>
    <script>
        $(document).ready(function(){
            let status = @json($created);
            console.log(status);
            let title = 'Thêm mới';
            let message = status;
            let icon = 'success';

            if (status) {
                showMessage(title, message, icon);
            }
        });
    </script>
@endsection


