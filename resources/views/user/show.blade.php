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
                        <h2>{!! $user->name !!}</h2>
                        <p class="lead"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4 form-horizontal">

                    <div class="form-group text-center"><strong>Имя</strong>: {!! $user->name !!}</div>

                    <div class="form-group text-center"><strong>Email</strong>: {!! $user->email !!}</div>

                    <div class="form-group text-center">
                        @foreach($user->l_domains as $domain)
                        <strong>Поддомен</strong>: <a target="_blank" href="http://{!! $domain->name !!}/">http://{!! $domain->name !!}/</a><br />
                        <strong>Алиасы</strong>:
                            @foreach($domain->l_aliases as $alias)
                                <a target="_blank" href="http://{!! $domain->name !!}.{!! env('LPGEN_KZ','b-apps.kz') !!}/">{!! $alias->name !!}.{!! env('LPGEN_KZ','b-apps.kz') !!}</a><br />
                            @endforeach
                        @endforeach
                    </div>

                    <div class="form-group">
                        <a href="{!! route('user.index') !!}" class="btn btn-block btn-primary">Список</a>
                        <a href="{!! route('user.edit',['id'=>$user->id]) !!}" class="btn btn-block btn-info">Исправить</a>
                        <a href="#" id="deleteOrg" class="delete btn btn-block btn-danger">Удалить</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <form id="form_delete_user" action="{!! route('user.destroy',['id' => $user->id]) !!}" method="POST">
        {!! csrf_field() !!}
        {!! method_field("DELETE") !!}
    </form>
@endsection


@section('javascript')
    <script>
        $(function(){
            $("#deleteOrg").click(function() {
                $('#form_delete_user').submit();
            });


        })
    </script>
@endsection

