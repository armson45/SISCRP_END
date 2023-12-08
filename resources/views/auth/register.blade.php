@extends('layouts.navbarlog')

@section('content')
    <div class="container mt-1 shadow-lg" style="width: 40%;">
        <div class="row">
            <div class="col rounded border p-5">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('images/arteDentalLogo.jpg') }}" width="48" class="logoart">
                </div>
                {{-- LOGIN --}}

                <form method="POST" action="{{ route('register') }}" class="p-3 rounded">
                    @csrf
                    <div class="mb-4">
                        <div class="col-md-12">
                            <input id="name" type="text" placeholder="Nombre"
                                class="form-control @error('name') is-invalid @enderror" name="name"
                                value="{{ old('name') }}" required autocomplete="name" autofocus>

                            @error('name')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="mb-4">
                        {{-- <label for="email" class="form-label text-md-end">Correo Electrónico</label> --}}

                        <div class="col-md-12">
                            <input id="email" type="email" placeholder="Correo Electrónico"
                                class="form-control @error('email') is-invalid @enderror" name="email"
                                value="{{ old('email') }}" required autocomplete="email">

                            @error('email')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        {{-- <label for="password" class="form-label">Contraseña</label> --}}

                        <div class="col-md-12">
                            <input id="password" type="password" placeholder="Contraseña"
                                class="form-control @error('password') is-invalid @enderror" name="password" required
                                autocomplete="new-password">

                            @error('password')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        {{-- <label for="password-confirm" class="form-label">Confirma tu
                            contraseña</label> --}}

                        <div class="col-md-12">
                            <input id="password-confirm" type="password" class="form-control"
                                placeholder="Confirmar contraseña" name="password_confirmation" required
                                autocomplete="new-password">
                        </div>
                    </div>
                    <div class="d-grid gap-2 d-md-flex justify-content-md-between">
                        <div class="">
                            <a href="{{ route('login') }}" class="btn btn-light">Ya tengo una cuenta</a>
                        </div>
                        <div class="">
                            <button type="submit" class="btn btn-light" onclick="fieldIsEmpty()">
                                Registrarme
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <footer class="bg-light w-100 mx-auto p-2 mt-4 pb-1" id="">
        <section class="row">
            <div class="col-md-4 text-center">
                Arte Dental
            </div>
            <div class="col-md-4 text-center">
                <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#terms">
                    Términos y Condiciones
                </button>

                <span>
                    <img src="images/arteDentalLogo.jpg" class="" id="logteeth">
                </span>
                <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#political">
                    Politica de Privacidad
                </button>
            </div>
            <div class="col-md-4 text-center">
                <a href="https://www.facebook.com/Caballerodontologo"
                    class="social-icon-link bi-facebook text-secondary"></a>
                &nbsp;
                <a href="https://www.instagram.com/artedentalsv/" class="social-icon-link bi-instagram text-secondary"></a>
                &nbsp;
                <a href="https://api.whatsapp.com/send?phone=50379858515&text=Quiero%20agendar%20una%20cita%20por%20favor%20%0A"
                    class="social-icon-link bi-whatsapp text-secondary"></a>

            </div>
        </section>
    </footer>
    <script>
        const sopas = 2;

        function fieldIsEmpty() {
            var name = document.getElementById("name");
            var email = document.getElementById("email").value;
            var password = document.getElementById("password").value;
            var password - confirm = document.getElementById("password-confirm").value;

            if (name.length == 0) {
                alert("Rellene el campo name")
            } else {
                console.log("noc");
            }
        }
    </script>
@endsection
