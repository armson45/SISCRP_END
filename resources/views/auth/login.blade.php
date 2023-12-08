@extends('layouts.navbarlog')

@section('content')
    <div class="container rounded mt-1 shadow-sm" id="logcontainer" style="width: 40%; height: 10%;">
        <div class="row align-items-stretch">
            <div class="col bg-white p-5 rounded">
                <div class="d-flex justify-content-center">
                    <img src="{{ asset('images/arteDentalLogo.jpg') }}" width="48" class="logoart">
                </div>
                {{-- LOGIN --}}

                <form method="POST" action="{{ route('login') }}" class="p-3 rounded">
                    @csrf
                    <div class="mb-4 input-group">
                        <div class="input-group-text bg-info">
                            <img src="images/person-circle.svg" alt="" style="height: 25px;">
                        </div>
                        <input id="email" type="email" placeholder="Email"
                            class="form-control @error('email') is-invalid @enderror" name="email"
                            value="{{ old('email') }}" required autocomplete="email" autofocus>
                        @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-4 input-group">
                        <div class="input-group-text bg-info">
                            <img src="images/key-fill.svg" alt="" style="height: 25px;">
                        </div>
                        <input id="password" type="password" placeholder="Contraseña"
                            class="form-control @error('password') is-invalid @enderror" name="password" required
                            autocomplete="current-password">
                        @error('password')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                        @enderror
                    </div>
                    <div class="mb-1 form-check" style="font-size: 15px">
                        <input type="checkbox" class="form-check-input" name="remember" id="remember"
                            {{ old('remember') ? 'checked' : '' }}> <label class="form-check-label" for="remember">
                            Recuérdame </label>
                    </div>
                    {{-- <div class="d-flex justify-content-center">
                        <button type="submit" class="btn btn-primary fs-6">Iniciar Sesión</button>
                        @if (Route::has('password.request'))
                            <a class="btn btn-link" href="{{ route('password.request') }}"></a>
                        @endif
                    </div> --}}
                    <div class="row">
                        <div class="col text-end">
                            <button type="submit" class="btn btn-info text-white fw-bold">
                                {{ __('Iniciar Sesión') }}
                            </button>
                        </div>
                    </div>
                </form>
                <br>
                <section class="row">
                    <div class="col fs-1">
                        <a class="btn btn-light" href="{{ route('register') }}" style="">Aún no tengo una cuenta!</a>
                    </div>
                    <div class="col fs-1 text-end">
                        @if (Route::has('password.request'))
                            <a class="btn btn-light" href="{{ route('password.request') }}">
                                {{ __('Olvidé mi Contraseña') }}
                            </a>
                        @endif
                    </div>
                </section>
            </div>
        </div>
    </div>
    <div class="modal fade" id="terms" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 fw-bold" id="staticBackdropLabel">Terminos y Condiciones de Uso</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laboriosam possimus eius consectetur
                        consequuntur ratione animi, veritatis amet eveniet magnam ea doloribus! Eveniet quisquam, vel,
                        molestias
                        deserunt iusto quaerat in quod quis alias maxime voluptas doloremque quos. Ratione, cum asperiores
                        optio
                        ipsa maiores, quod magni nemo nesciunt iste eius et commodi molestias mollitia nam sequi quas enim
                        quos.
                        Neque maxime sequi nisi explicabo labore magnam autem sapiente in hic unde quia veniam debitis eaque
                        dignissimos magni, perferendis tenetur. Laboriosam dolorem repellat nemo magnam tempore doloribus
                        reprehenderit unde quo corporis, adipisci alias ratione praesentium, ut natus quasi dolores minus
                        quas
                        incidunt. Atque animi dolores cumque nisi numquam saepe in aliquid enim aspernatur molestiae!
                        Laborum
                        dolor fuga maiores iste odit facere tempora, corporis a. Nesciunt enim sequi voluptatibus maxime
                        beatae
                        suscipit debitis aspernatur eaque! Quisquam repudiandae reiciendis quo aspernatur hic placeat
                        facilis
                        magni optio dolor id nam expedita, deleniti asperiores consequatur fugiat amet consequuntur
                        doloribus ea
                        dolores impedit vel fugit? Molestias facere excepturi hic debitis ullam.</p>
                    <br>
                    <br>
                    <label for="agreed" class="fw-bold">De Acuerdo</label>
                    <input type="checkbox" name="" id="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Entendido</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="political" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog  modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-4 fw-bold" id="staticBackdropLabel">Politica de Privacidad</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Lorem ipsum dolor sit, amet consectetur adipisicing elit. Laboriosam possimus eius consectetur
                        consequuntur ratione animi, veritatis amet eveniet magnam ea doloribus! Eveniet quisquam, vel,
                        molestias
                        deserunt iusto quaerat in quod quis alias maxime voluptas doloremque quos. Ratione, cum asperiores
                        optio
                        ipsa maiores, quod magni nemo nesciunt iste eius et commodi molestias mollitia nam sequi quas enim
                        quos.
                        Neque maxime sequi nisi explicabo labore magnam autem sapiente in hic unde quia veniam debitis eaque
                        dignissimos magni, perferendis tenetur. Laboriosam dolorem repellat nemo magnam tempore doloribus
                        reprehenderit unde quo corporis, adipisci alias ratione praesentium, ut natus quasi dolores minus
                        quas
                        incidunt. Atque animi dolores cumque nisi numquam saepe in aliquid enim aspernatur molestiae!
                        Laborum
                        dolor fuga maiores iste odit facere tempora, corporis a. Nesciunt enim sequi voluptatibus maxime
                        beatae
                        suscipit debitis aspernatur eaque! Quisquam repudiandae reiciendis quo aspernatur hic placeat
                        facilis
                        magni optio dolor id nam expedita, deleniti asperiores consequatur fugiat amet consequuntur
                        doloribus ea
                        dolores impedit vel fugit? Molestias facere excepturi hic debitis ullam.</p>
                    <br>
                    <br>
                    <label for="agreed" class="fw-bold">De Acuerdo</label>
                    <input type="checkbox" name="" id="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="button" class="btn btn-primary">Entendido</button>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-light w-100 mx-auto p-2 mt-3 pb-1" id="">
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
                <a href="https://www.instagram.com/artedentalsv/"
                    class="social-icon-link bi-instagram text-secondary"></a>
                &nbsp;
                <a href="https://api.whatsapp.com/send?phone=50379858515&text=Quiero%20agendar%20una%20cita%20por%20favor%20%0A"
                    class="social-icon-link bi-whatsapp text-secondary"></a>

            </div>
        </section>
    </footer>
@endsection
