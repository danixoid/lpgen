@extends('layouts.app')

@section('content')



<!-- =============================
 RESET PASSWORD
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
                <form class="form-horizontal form-white form-margin text-white form-horizontal"
                      method="POST" action="{{ route('password.email') }}" role="form">
                    {{ csrf_field() }}

                    <h6 class="text-center m-b-md">Введите Email</h6>
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <input id="email" type="email" placeholder="EMail" class="form-control"
                               name="email" value="{{ old('email') }}" required>

                        @if ($errors->has('email'))
                            <span class="help-block">
                                    <strong>{{ $errors->first('email') }}</strong>
                                </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-shadow btn-blue btn-md">ОТПРАВИТЬ ССЫЛКУ НА СБРОС ПАРОЛЯ</button>
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