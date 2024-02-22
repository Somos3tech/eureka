<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Eureka by VEPAGOS| Inicio Sesión</title>
    <link href="https://fonts.googleapis.com/css?family=Nunito:300,400,400i,600,700,800,900" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/styles/css/themes/lite-purple.min.css') }}">
    @toastr_css
</head>

<body>
    <div class="auth-layout-wrap" style="background-image: url({{ asset('assets/images/wallpaper-eureka.jpg') }})">
        <div class="auth-content">
            <div class="card o-hidden">
                <div class="row">
                    <div class="col-md-6">
                        <div class="p-4">
                            <div class="text-center mb-4">
                                <img src="{{ asset('assets/images/logo-eureka.png') }}" alt="">
                            </div>
                            <h1 class="mb-3 text-18">Iniciar Sesión</h1>
                            <form method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="form-group">
                                    <label for="email">Usuario</label>
                                    <input id="email"
                                        class="form-control form-control-rounded @error('email') is-invalid @enderror"
                                        name="email" value="{{ old('email') }}" required autocomplete="email"
                                        autofocus>
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group">
                                    <label for="password">Contraseña</label>
                                    <input id="password" type="password"
                                        class="form-control form-control-rounded @error('password') is-invalid @enderror"
                                        name="password" required autocomplete="current-password">
                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>
                                <div class="form-group ">
                                    <div class="">
                                        <div class=" form-check">
                                            <input class="form-check-input" type="checkbox" name="remember"
                                                id="remember" {{ old('remember') !== null ? 'checked' : '' }}>
                                            {{-- Se modifica el label de "Recordar Credenciales" a "Mantener Sesión Abierta", ya que la funcionalidad de remember en laravel permite que la sesión se mantenga abierta por 2 horas al no checkear por el remember_token, pero al contener el token, "teoricamente" la sesion se mantendra abierta durante 5 años --}}
                                            <label class="form-check-label" for="remember">
                                                Mantener Sesión Abierta
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <button class="btn btn-rounded btn-info btn-block mt-2">Iniciar Sesión</button>
                            </form>
                        </div>
                    </div>
                    <div class="col-md-6 text-center "
                        style="background-size: cover;background-image: url({{ asset('assets/images/body_wallpaper.png') }}">
                        <div class="pr-3 auth-right">

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/js/common-bundle-script.js') }}"></script>

    <script src="{{ asset('assets/js/script.js') }}"></script>
    @toastr_js
    @toastr_render
</body>

</html>
