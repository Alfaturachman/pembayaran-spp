@extends('layouts.student.dashboard')

@section('content')

<section class="section">

    <div class="section-header text-dark">
        <h1>Dashboard Siswa | Halaman Utama</h1>
    </div>

    <div class="row">
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-primary">
                    <i class="fas fa-user"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Siswa</h4>
                    </div>
                    <div class="card-body">
                        {{ DB::table('users')->where('roles', 'STUDENT')->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-danger">
                    <i class="fas fa-user-friends"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Kelas</h4>
                    </div>
                    <div class="card-body">
                        {{ DB::table('classes')->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-warning">
                    <i class="fas fa-chalkboard-teacher"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Petugas</h4>
                    </div>
                    <div class="card-body">
                        {{ DB::table('users')->where('roles', 'STAFF')->count() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6 col-12">
            <div class="card card-statistic-1">
                <div class="card-icon bg-success">
                    <i class="fas fa-dollar-sign"></i>
                </div>
                <div class="card-wrap">
                    <div class="card-header">
                        <h4>Transaksi</h4>
                    </div>
                    <div class="card-body">
                        {{ DB::table('payments')->count() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card" style="width:100%;">
        <div class="card-body">
            <h2 class="card-title text-dark">Melakukan pembayaran?</h2>
            <hr>
            <p class=" card-text">Anda dapat menambahkan transaksi atau pembayaran SPP dengan cepat melalui tombol
                dibawah atau tombol disamping. Transaksi yang telah anda lakukan, akan langsung diproses dan bukti
                laporan akan dapat anda cetak disana. </p>
            <a href="#" class="btn btn-primary">Tambah transaksi ⭢</a>
        </div>
    </div>

</section>

<section class="section">
    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary p-4">
                <div class="table-responsive">
                    <table class="table align-items-center table-flush">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">NISN</th>
                                <th scope="col">NAMA SISWA</th>
                                <th scope="col">BULAN</th>
                                <th scope="col">TAHUN</th>
                                <th scope="col">TOTAL BAYAR</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($items as $item)
                            <tr>
                                <th>
                                    {{ $item->nisn }}
                                </th>
                                <td>
                                    {{ $item->name }}
                                </td>
                                <td>
                                    {{ $item->month }}
                                </td>
                                <td>
                                    {{ $item->year }}
                                </td>
                                <td>
                                    {{ $item->total_payment }}
                                </td>
                            </tr>
                            @empty
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection