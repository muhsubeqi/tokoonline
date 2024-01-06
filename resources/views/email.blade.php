<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Verifikasi Email</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <col-md-8 class="col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading text-center"><img class="w-25" src="" alt="">
                    </div>
                    <div class="panel-body">
                        <h2>Hallo !!</h2>
                        <p>Terima kasih atas pendaftaran Anda di website kami. Silahkan klik
                            pada link berikut untuk mengaktifkan akun Anda secara otomatis.</p>
                        <p>Verifikasi : <a
                                href="{{ route('verifikasi', ['token' => $remember_token]) }}">{{ $remember_token }}</a>
                        </p>
                    </div>
                </div>
            </col-md-8>
        </div>
    </div>
    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous">
    </script>
</body>

</html>
