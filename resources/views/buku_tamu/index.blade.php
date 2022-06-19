@extends('mylayouts.main')

@section('tambahancss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css">
    <style>
        .swal2-container {
            z-index: 9999 !important;
        }

        .dropdown-toggle::after{
            display: none;
        }
    </style>
@endsection

@section('container')

    <div class="content-wrapper">
        <!-- Content -->

        <div class="container-xxl flex-grow-1 container-p-y">

            <div class="card">
                <div class="container-fluid p-0">
                    <div class="row">
                        <div class="col-md-8">
                            <h5 class="card-header">Buku Tamu</h5>
                        </div>
                        <div class="col-md-4 d-flex justify-center align-items-center p-0">
                            <a href="/buku-tamu/create" class="btn btn-primary tombol-buat-user"
                                style="margin-right: 10px">Create Tamu</a>
                            @can('buku_tamu_ekspor')
                                <a href="/excel" class="btn btn-primary tombol-buat-user">Export Excel</a>
                            @endcan
                        </div>
                    </div>
                </div>
                <div class="container" style="overflow: auto;min-height: 65vh">
                    <div id="accordionIcon" class="accordion accordion-without-arrow">
                        <div class="table-responsive">
                            @if (count($datatamu) > 0)
                                <table class="table-hover table" style="font-size: 15px;text-align:center;">
                                    <thead class="">
                                        <tr>
                                            <th class="col-1">#</th>
                                            <th class="col-1">Foto</th>
                                            <th class="col-2">Nama Tamu</th>
                                            <th class="col-2">Instansi</th>
                                            <th class="col-2">Kategori</th>
                                            <th class="col-2">Alamat</th>
                                            <th class="col-1">Tanda Tangan</th>
                                            @can('edit_buku_tamu', 'delete_buku_tamu')
                                                <th>Actions</th>
                                            @endcan
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datatamu as $no => $dt)
                                            <tr>
                                                <td>{{ ($datatamu->currentpage() - 1) * $datatamu->perpage() + $loop->index + 1 }}
                                                </td>
                                                <td>
                                                    <a href="image/{{ $dt->image }}"
                                                        data-fancybox="gallery{{ $no }}">
                                                        <img src="image/{{ $dt->image }}" alt=""
                                                            style="object-fit: cover; width: 80px; aspect-ratio: 1/1;margin: 10px;box-shadow: 0 3px 6px #0000001c;" />
                                                    </a>
                                                    {{-- <img src="" style="width: 30px;"> --}}
                                                </td>
                                                <td>{{ $dt->nama }}</td>
                                                <td>{{ $dt->instansi }}</td>
                                                <td>{{ $dt->kategori == 'khusus' ? 'Tamu Khusus' : 'Tamu Umum' }}</td>
                                                <td>{{ $dt->alamat }}</td>
                                                <td>
                                                    <a href="tandaTangan/{{ $dt->signed }}"
                                                        data-fancybox="gallery{{ $no }}">
                                                        <img src="tandaTangan/{{ $dt->signed }}" alt=""
                                                            style="object-fit: cover; width: 80px; aspect-ratio: 1/1;margin: 10px;box-shadow: 0 3px 6px #0000001c;" />
                                                    </a>

                                                    {{-- <img src="" style="width: 90px;"> --}}
                                                </td>
                                                <td class="">
                                                    <div class="dropdown">
                                                        <button class="btn btn-primary dropdown-toggle" type="button"
                                                            id="dropdownMenuButton1" data-bs-toggle="dropdown">:
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                            <li>
                                                                @can('edit_buku_tamu')
                                                                    <a href="/buku-tamu/{{ $dt->id }}/edit"
                                                                        class="dropdown-item"
                                                                        style="margin-right: 10px;">Edit</a>
                                                                @endcan
                                                            </li>
                                                            <li>
                                                                @can('delete_buku_tamu')
                                                                    <form action="/buku-tamu/{{ $dt->id }}"
                                                                        id="delete{{ $dt->id }}" method="POST"
                                                                        class="d-block">
                                                                        @csrf
                                                                        @method('delete')
                                                                        <a href="#" data-id={{ $dt->id }}
                                                                            class="dropdown-item swal-confrim">
                                                                            Hapus
                                                                        </a>
                                                                    </form>
                                                                @endcan
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="container-fluid p-0 d-flex justify-content-center align-items-center"
                                    style="height: 10rem;">
                                    <div class="alert alert-info text-center" role="alert" style="width: 50%;">
                                        Maaf, tidak ada data ditemukan
                                    </div>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- / Content -->
        <!-- Modal -->

        <div class="content-backdrop fade"></div>
    </div>
@endsection

@section('tambahanjs')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js"></script>
    <script>
        $(".swal-confrim").click(function(e) {
            id = e.target.dataset.id;
            Swal.fire({
                title: 'Apakah anda yakin ingin hapus data ini?',
                text: "Data yang terhapus tidak dapat dikembalikan",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'

            }).then((result) => {
                if (result.isConfirmed) {
                    $(`#delete${id}`).submit();
                } else {

                }

            })

        });
    </script>

    <script>
        const alertNontifikasi = document.querySelector('.alert-nontifikasi');
        const myTimeout = setTimeout(myGreeting, 5000);

        function myGreeting() {
            if (alertNontifikasi) {
                alertNontifikasi.style.display = 'none';
            }
        }
    </script>
@endsection
