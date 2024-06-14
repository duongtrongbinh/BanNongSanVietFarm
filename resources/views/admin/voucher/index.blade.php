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
                        <h5 class="card-title">Vouchers</h5>
                        <div class="d-flex justify-content-between">
                            <p>title</p>
                            <div>
                                <a href="/vouchers/create">
                                    <button type="button" class="btn btn-success"><i class="bi bi-plus"></i> add new voucher</button>
                                </a>
                                <a href="/deleted/vouchers">
                                    <button type="button" class="btn btn-primary"><i class="bi bi-plus"></i>remove</button>
                                </a>
                            </div>
                        </div>
                        <!-- Table with stripped rows -->
                        <table class="table datatable">
                            <thead>
                            <tr>
                                <th scope="col">Title</th>
                                <th scope="col">Quantity</th>
                                <th scope="col">Amount</th>
                                <th scope="col">Start Date</th>
                                <th scope="col">End Date</th>
                                <th scope="col">Is active</th>
                                <th scope="col">Action</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if(isset($vouchers))
                                @foreach($vouchers as $items)
                                    <tr>
                                        <th>{{ $items->title }}</th>
                                        <td>{{ $items->quantity }}</td>
                                        <td>@if($items->type_unit == 0)
                                             {{ number_format($items->amount, 0, ',', '.') }} đ
                                            @else
                                             {{ rtrim(rtrim($items->amount, '0'), '.') }} %
                                        @endif
                                        </td>
                                        <th>{{ $items->start_date }}</th>
                                        <td>{{ $items->end_date }}</td>
                                        <td>@if($items->is_active == 1)
                                                <span class="badge bg-success">true</span>
                                            @else
                                                <span class="badge bg-danger">false</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="d-flex" style="gap: 10px">
                                                <a href="/vouchers/{{ $items->id }}"><button class="btn btn-outline-secondary">Detail</button></a>
                                                <a href="/vouchers/{{ $items->id }}/edit"><button class="btn btn-outline-warning">edit</button></a>
                                                <form action="/vouchers/{{$items->id}}" method="post" class="deleteVouchers" data-url="{{ route('vouchers.destroy', $items->id) }}">
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
