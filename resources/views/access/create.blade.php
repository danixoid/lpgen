<?php
/**
 * Created by PhpStorm.
 * User: danixoid
 * Date: 07.03.18
 * Time: 11:33
 */?>

@extends('layouts.app')

@section('meta')
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/select2-bootstrap.min.css') }}" rel="stylesheet">
@endsection

@section('content')
    <section class="p-y-lg bg-white bg-edit">

        <div class="container">
            <!-- Section Header -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="section-header text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                        <h2>Добавить участника</h2>
                        <p class="lead"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">

                    <form class="form-horizontal form-margin"
                          method="POST" action="{{ route('access.store') }}" role="form">
                        {{ csrf_field() }}

                        <input type="hidden" name="l_domain_id" value="{!! request()->l_domain_id !!}">
                        <h6 class="text-center m-b-md">Заполните все поля</h6>
                        <div class="form-group">
                            <select class="form-control select2-single" name="user_id" id="user">
                            </select>
                            <span class="text-primary">
                                <strong>Выберите участника</strong>
                            </span>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-shadow btn-blue btn-md">Добавить</button>
                        </div>
                        <p class="small text-center"><a href="{!! route('domain.index') !!}" class="">Отмена</a></p>
                    </form>

                </div>
            </div><!-- /End Row -->
        </div><!-- /End Container -->
    </section>
@endsection


@section('javascript')
    <script src="{{ asset('js/select2.min.js') }}"></script>
    <script src="{{ asset('js/i18n/ru.js') }}"></script>

    <script>
        $(function () {

            $("#user").each(function(){

                $(this).select2({
                    ajax: {
                        url: "{!! route('user.index') !!}",
                        dataType: 'json',
                        delay: 250,
                        data: function (params) {
                            return {
                                q: params.term, // search term
                                count: params.page
                            };
                        },
                        processResults: function (data, params) {
                            params.page = params.page || 1;

                            return {
                                results: $.map(data.data, function (item) {
                                    return {
                                        text: item.name + "<" + item.email + ">",
                                        id: item.id
                                    }
                                }),
                                pagination: {
                                    more: (params.page * 30) < data.length
                                }
                            };
                        },
                        cache: true
                    },
                    theme: "bootstrap",
                    placeholder: 'Начинайте вводить имя',
                    allowClear: false,
                    minimumInputLength: 2,
                    language: '{!! config()->get('app.locale') !!}',
                    escapeMarkup: function (markup) { return markup; }, // let our custom formatter work
                });
            });
        });

    </script>
@endsection