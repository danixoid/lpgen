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
                    <p class="lead">Регистрация</p>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <!-- Mailchimp Form -->
                <form class="form-horizontal form-white form-margin text-white form-horizontal"
                      method="POST" action="{{ route('register') }}" role="form">
                    {{ csrf_field() }}

                    <h6 class="text-center m-b-md">Введите регистрационные данные</h6>
                    <div class="form-group">
                        <input type="text" class="form-control" placeholder="Имя" value="{{ old('name') }}" name="email" autofocus required="">
                        @if ($errors->has('name'))
                            <span class="help-block">
                                <strong>{{ $errors->first('name') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" placeholder="Email" value="{{ old('email') }}" name="email" required="">
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
                        <input type="password" class="form-control" placeholder="Повторите пароль" name="password_confirmation" required="">
                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                <strong>{{ $errors->first('password_confirmation') }}</strong>
                            </span>
                        @endif
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-shadow btn-yellow btn-md">ВПЕРЁД</button>
                    </div>
                    <p class="small text-center"></p>
                </form>

            </div>
        </div><!-- /End Row -->
    </div><!-- /End Container -->

</section>



@endsection
