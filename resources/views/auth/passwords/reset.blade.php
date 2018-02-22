@extends('layouts.app')

@section('content')



<!-- =============================
 RESET PASSWORD
============================== -->
<section id="subscription5-3" class="p-y-lg subscription bg-edit bg-img" style="background-image:url('/elements/images/uploads/arrow_stephen_amell_oliver_queen_105575_1366x768.jpg')">

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
                <form class="form-horizontal form-white form-margin text-white form-horizontal"
                      method="POST" action="{{ route('password.request') }}" role="form">
                    {{ csrf_field() }}

                    <input type="hidden" name="token" value="{{ $token }}">
                    <h6 class="text-center m-b-md">Восстановить доступ к системе</h6>


                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="email" class="form-control" name="email" placeholder="EMail" value="{{ $email or old('email') }}" required autofocus>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <input id="password" type="password" class="form-control" name="password" placeholder="Пароль" required>

                        @if ($errors->has('password'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('password') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                        <input id="password-confirm" type="password" class="form-control" placeholder="Подтвердите пароль" name="password_confirmation" required>

                        @if ($errors->has('password_confirmation'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('password_confirmation') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-shadow btn-blue btn-md">СБРОСИТЬ ПАРОЛЬ</button>
                    </div>
                </form>

            </div>
        </div><!-- /End Row -->
    </div><!-- /End Container -->

</section>



@endsection

@section('javascript')
    <script>
        $(function(){
            if($(document).height() <= $(window).height()) {
                $("section").css("height",$(window).height())
            };
        })
    </script>
@endsection
