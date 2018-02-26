@extends('layouts.app')

@section('content')


<!-- =============================
     LOGIN
    ============================== -->
<section class="p-y-lg bg-green bg-edit">

    <div class="overlay"></div>
    <div class="container">
        <!-- Section Header -->
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="section-header text-center text-white wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                    <h2>Добро пожаловать!</h2>
                    <p class="lead"></p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <!-- Mailchimp Form -->
                <form class="form-horizontal form-white form-margin text-white"
                      method="POST" action="{{ route('login') }}" role="form">
                    {{ csrf_field() }}

                    <h6 class="text-center m-b-md">Войти в систему</h6>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email" name="email" required="" value="{{ old('email') }}" autofocus>
                    @if ($errors->has('email'))
                        <span class="help-block">
                            <strong>{{ $errors->first('email') }}</strong>
                        </span>
                    @endif
                    </div>
                    <div class="form-group">
                        <input type="password" class="form-control" placeholder="Пароль" name="password" required="">
                    @if ($errors->has('password'))
                        <span class="help-block">
                            <strong>{{ $errors->first('password') }}</strong>
                        </span>
                    @endif
                    </div>
                    <div class="form-group">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}> Запомнить меня
                            </label>
                        </div>
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-shadow btn-blue btn-md">ВОЙТИ</button>
                    </div>
                    <p class="small text-center"><a href="{{ route('password.request') }}" class="inverse">Забыли пароль?</a></p>
                </form>

            </div>
        </div><!-- /End Row -->
    </div><!-- /End Container -->

</section>



@endsection
