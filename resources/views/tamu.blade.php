<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/css/bootstrap.min.css"
        integrity="sha384-zCbKRCUGaJDkqS1kPbPd7TveP5iyJE0EjAuZQTgFLD2ylzuqKfdKlfG/eSrtxUkn" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/css/iziToast.min.css"
        integrity="sha512-O03ntXoVqaGUTAeAmvQ2YSzkCvclZEcPQu1eqloPaHfJ5RuNGiS4l+3duaidD801P50J28EHyonCV06CUlTSag=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/izitoast/1.4.0/js/iziToast.min.js"
        integrity="sha512-Zq9o+E00xhhR/7vJ49mxFNJ0KQw1E1TMWkPTxrWcnpfEFDEXgUiwJHIKit93EW/XxE31HSI5GEOW06G6BF1AtA=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <title>SMK Taruna Bhakti</title>
</head>

<body
    style="background: url(img/background_tb_tamu.jpg);background-size: cover;background-position: center;overflow: hidden;">
    <div class="row justify-content-center align-items-center" style="min-height: 100vh">
        <div class="col-md-4">
            <div class="card text-center shadow">
                <div class="card-body" style="padding: 2rem">
                    <div class="container d-flex justify-content-center">
                        <img src="{{ asset('img/logo1.png') }}" class="rounded float-left" alt="SMK TARUNA BHAKTI"
                            style="width: 15rem;">
                    </div>
                    <h5 class="card-title">Selamat Datang <br>Di SMK TARUNA BHAKTI</h5>
                    <a href="{{ route('tamu.create') }}" class="btn btn-primary w-100">Buat data pengunjung</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-fQybjgWLrvvRgtW6bFlB7jaZrFsaBXjsOMm/tB9LTS58ONXgqbR9W8oWht/amnpF" crossorigin="anonymous">
    </script>
    <script>
        function showAlert(message, type) {
            if (type == 'success') {
                iziToast.success({
                    title: 'Success',
                    message: message,
                    position: 'topRight'
                });
            } else {
                iziToast.error({
                    title: 'Failed',
                    message: message,
                    position: 'topRight'
                });
            }
        }
        @if (session()->has('success')) showAlert("{{ session('success') }}", 'success')
        @elseif(session()->has('error')) showAlert("{{ session('error') }}", 'error')
        @endif
    </script>
</body>

</html>