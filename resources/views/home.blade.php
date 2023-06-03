@extends('layouts.home')

@section('content')
    <div class="container-fluid">
        <!--  Row 1 -->
        @if (session('status'))
            <div class="alert alert-success" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12 d-flex align-items-strech">
                <div class="card w-100">
                    <div class="card-body">
                        <div class="d-sm-flex d-block align-items-center justify-content-between mb-9">
                            <div class="mb-3 mb-sm-0">
                                <h5 class="card-title fw-semibold">Grafik EOQ, ROP & Safety Stock</h5>
                            </div>
                        </div>
                        <div id="chart"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="py-6 px-6 text-center">
            <p class="mb-0 fs-4">Developed by <a href="{{ route('home') }}" class="pe-1 text-primary text-decoration-underline">Aquali IT Tim</a></p>
        </div>
    </div>
@endsection
