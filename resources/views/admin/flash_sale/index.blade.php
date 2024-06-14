@extends('admin.layout.master')
@section('js')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('admin/assets/js/deleteAll/deleteSoft.js') }}"></script>
@endsection
@section('content')
    <div class="pagetitle">
        <h1>Dashboard</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Vouchers</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Flash Sale</h5>
                        <div class="d-flex justify-content-between">
                                <p>title</p>
                                <div>
                                    <a href="/flash-sales/create">
                                        <button type="button" class="btn btn-success"><i class="bi bi-plus"></i> add new flash sale</button>
                                    </a>
                                    <a href="/flash-sales/">
                                        <button type="button" class="btn btn-primary"><i class="bi bi-plus"></i>remove</button>
                                    </a>
                                </div>
                        </div>
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
                                                <a href="flash-sales/{{ $items->id }}"><button class="btn btn-outline-primary">Detail</button></a>
                                                <a href="flash-sales/{{ $items->id }}/edit"><button class="btn btn-outline-warning">Edit</button></a>
                                                <form action="/flash-sales/{{$items->id}}" method="post" class="deleteFlashSale" data-url="{{ route('flash-sales.destroy', $items->id) }}">
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
