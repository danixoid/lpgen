<?php
/**
 * Created by PhpStorm.
 * User: danixoid
 * Date: 22.06.17
 * Time: 15:42
 */?>
@extends('layouts.app')

@section('content')

    <section class="p-y-lg bg-edit">

        <div class="container">
            <!-- Section Header -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="section-header text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                        <h2>Изменить данные <br />пользователя "{!! $user->name !!}"</h2>
                        <p class="lead"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">

                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#profile" aria-controls="profile" role="tab" data-toggle="tab">
                                Профиль
                            </a></li>
                        <li role="presentation"><a href="#settings" aria-controls="settings" role="tab" data-toggle="tab">
                                Изменить пароль
                            </a></li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane active" id="profile">
                            <br />
                            <form id="form_create_user" class="form-horizontal" action="{!!
                        route('user.update',['id' => $user->id]) !!}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field("PUT")  !!}

                                <div class="form-group">
                                    <input type="email" class="form-control" disabled name="email" value="{!! $user->email !!}" />
                                </div>

                                <div class="form-group">
                                    <input type="text" class="form-control" name="name" value="{!! $user->name !!}" required/>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-block btn-danger" >Обновить</button>
                                </div>
                            </form>
                        </div>
                        <div role="tabpanel" class="tab-pane" id="settings">
                            <br />
                            <form id="form_create_user" class="form-horizontal" action="{!!
                                    route('user.update',['id' => $user->id]) !!}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field("PUT")  !!}

                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Пароль" name="password" required>
                                </div>

                                <div class="form-group">
                                    <input type="password" class="form-control" placeholder="Повторить пароль" name="password_confirmation" required>
                                </div>

                                <div class="form-group">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" id="gen_pswd" > Генерировать пароль
                                        </label>
                                        <span class="text-primary" id="pswd"></span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <button class="btn btn-block btn-danger" >Обновить</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('meta')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('javascript')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/i18n/ru.js') }}"></script>
    <script>

        $(function () {

            $('#gen_pswd').change(function (ev) {
                if(this.checked) {
                    var pswd = generatePassword();
                    $("#pswd").text('[' + pswd + ']');
                    $("input[type='password']").val(pswd);
                } else {
                    $("#pswd").text('');
                    $("input[type='password']").val('');
                }
            });

            $("input[type='password']").on('keyup',function(ev) {
                $("#pswd").text('');
            });
        });

        function generatePassword() {
            var length = 6,
                charset = "abcdefghijklnmopqrstuvwxyz1234567890",
                retVal = "";
            for (var i = 0, n = charset.length; i < length; ++i) {
                retVal += charset.charAt(Math.floor(Math.random() * n));
            }
            return retVal;
        }


    </script>

@endsection

