@extends('admin.layout.master')
@section('content')
    <div class="pagetitle">
        <h1>Orders</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard')}}">Home</a></li>
                <li class="breadcrumb-item active">Orders</li>
            </ol>
        </nav>
    </div>

    <section class="section">
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Orders</h5>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">Code</th>
                                <th scope="col">Personal information</th>
                                <th scope="col">Before total</th>
                                <th scope="col">Shipping</th>
                                <th scope="col">After total</th>
                                <th scope="col">Is active</th>
                                <th scope="col">Order details</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($orders))
                                @foreach($orders as $items)
                                    <tr>
                                        <th>{{ $items->order_code }}</th>
                                        <td>{{ $items->name }},{{ $items->phone }}</td>

                                        <td> {{ number_format($items->before_total_amount, 0, ',', '.') }}</td>
                                        <td> {{ number_format($items->shipping, 0, ',', '.') }}</td>
                                        <td> {{ number_format($items->after_total_amount, 0, ',', '.') }}</td>
                                        <td>@if($items->status == 0)
                                                <span class="badge bg-warning">Wait for pay</span>
                                            @else
                                                <span class="badge bg-primary">Delivery</span>
                                            @endif
                                        </td>
                                        <td><a href="/order/{{$items->id}}/detail" class="link-success">View More <i class="ri-arrow-right-line align-middle"></i></a></td>

                                        <td>
                                            <div class="d-flex" style="gap: 10px">
                                                <a href="/{{ $items->id }}/edit"><button class="btn btn-primary">Detail</button></a>
                                            </div>
                                        </td>

                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>
                        <div class="pagination justify-content-center">

                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

@endsection
