@extends('layouts.app')
@section('core-css')
@endsection
@section('vendor-css')
@endsection
@section('helper-js')
@endsection
@section('breadcrumbs')
    {{ Breadcrumbs::render() }}
@endsection
@section('content')
    <div class="card">
        <div class="card-body">
            <table id="perusahaanTables" class="table table-striped table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Perusahaan</th>
                        <th>Tahun Berdiri</th>
                        <th>Alamat</th>
                        <th>Email</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
@endsection
@section('script')
    @vite(['resources/js/LandingPage/admin/AboutUs/Perusahaan/index.js'])
@endsection
