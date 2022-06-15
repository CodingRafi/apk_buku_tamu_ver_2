@extends('mylayouts.main')

@section('tambahancss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.css">
    <style>
        .accordion.accordion-without-arrow .accordion-button::after {
            background-image: url("data:image/svg+xml,%3Csvg width='12' height='12' viewBox='0 0 12 12' xmlns='http://www.w3.org/2000/svg' xmlns:xlink='http://www.w3.org/1999/xlink'%3E%3Cdefs%3E%3Cpath id='a' d='m1.532 12 6.182-6-6.182-6L0 1.487 4.65 6 0 10.513z'/%3E%3C/defs%3E%3Cg transform='translate%282.571%29' fill='none' fill-rule='evenodd'%3E%3Cuse fill='%23435971' xlink:href='%23a'/%3E%3Cuse fill-opacity='.1' fill='%23566a7f' xlink:href='%23a'/%3E%3C/g%3E%3C/svg%3E%0A") !important;
        }

        .swal2-container{
            z-index: 9999 !important;
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
                            <a href="/buku-tamu/create" class="btn btn-primary tombol-buat-user" style="margin-right: 10px">Create Tamu</a>
                            <a href="/excel" class="btn btn-primary tombol-buat-user">Export Excel</a>
                        </div>
                    </div>
                </div>
                <div class="container" style="overflow: auto;min-height: 65vh">
                    <div id="accordionIcon" class="accordion mt-3 accordion-without-arrow">
                        <div class="table-responsive">
                            @if (count($datatamu) > 0)
                                <table class="mt-3 table-hover table" style="font-size: 15px;text-align:center;">
                                    <thead class="">
                                        <tr>
                                            <th class="col-1">#</th>
                                            <th class="col-1">Foto</th>
                                            <th class="col-2">Nama Tamu</th>
                                            <th class="col-2">Instansi</th>
                                            <th class="col-2">Alamat</th>
                                            <th class="col-1">Tanda Tangan</th>
                                            <th class="col-3">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($datatamu as $no => $dt)
                                            <tr>
                                                <td>{{ ($datatamu->currentpage() - 1) * $datatamu->perpage() + $loop->index + 1 }}
                                                </td>
                                                <td>
                                                    <a href="storage/{{ $dt->image }}"
                                                        data-fancybox="gallery{{ $no }}">
                                                        <img src="storage/{{ $dt->image }}" alt=""
                                                            style="object-fit: cover; width: 80px; aspect-ratio: 1/1;margin: 10px;box-shadow: 0 3px 6px #0000001c;" />
                                                    </a>
                                                    {{-- <img src="" style="width: 30px;"> --}}
                                                </td>
                                                <td>{{ $dt->nama }}</td>
                                                <td>{{ $dt->instansi }}</td>
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
                                                    <div class="container-fluid p-0 d-flex justify-content-center align-items-center"
                                                        style="height: 100%">
                                                        <a href="/buku-tamu/{{ $dt->id }}/edit"
                                                            class="btn btn-warning text-white" style="margin-right: 10px;">Edit</a>
                                                        <form action="/buku-tamu/{{ $dt->id }}"
                                                            id="delete{{ $dt->id }}" method="POST"
                                                            class="d-block">
                                                            @csrf
                                                            @method('delete')
                                                            <a href="#" data-id={{ $dt->id }}
                                                                class="btn btn-danger swal-confrim">
                                                                Hapus
                                                            </a>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                            <div class="container-fluid p-0 d-flex justify-content-center align-items-center">
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
