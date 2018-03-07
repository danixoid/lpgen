<?php
/**
 * Created by PhpStorm.
 * User: danixoid
 * Date: 07.03.18
 * Time: 18:07
 */?>

@extends('layouts.app')

@section('meta')
@endsection

@section('content')
    <section class="p-y-lg bg-white bg-edit">

        <div class="container">
            <!-- Section Header -->
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <div class="section-header text-center wow fadeIn" style="visibility: visible; animation-name: fadeIn;">
                        <h2>Редактирование "{{ $domain->name }}"</h2>
                        <p class="lead"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 col-md-offset-3">

                    <form class="form-horizontal form-margin"
                          method="POST" action="{{ route('domain.update',$domain->id) }}" role="form">
                        {{ csrf_field() }}
                        {{ method_field('PUT') }}

                        <h6 class="text-center m-b-md">Заполните все поля</h6>
                        <div class="form-group">
                            <input type="text" autocomplete="off" pattern="(([a-zA-Z\d\-]+(\.[a-zA-Z\d\-]+)+(\,(\s+)?)?)+)"
                                   class="form-control" placeholder="Алиасы (например, site1.kz, site2.kz, site3.kz)"
                                   required="" name="l_aliases" value="@foreach($domain->l_aliases as $_alias){{ $_alias->name }}, @endforeach" autofocus>
                            <span class="text-primary">
                                <strong>Введите список доменов через запятую, которые настроены на этот сайт</strong>
                            </span>
                            @if ($errors->has('l_aliases'))
                                <span class="text-danger">
                                    <strong>{{ $errors->first('l_aliases') }}</strong>
                                </span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-shadow btn-blue btn-md">Исправить</button>
                        </div>
                        <p class="small text-center"><a href="{!! route('domain.index') !!}" class="">Отмена</a></p>
                    </form>

                </div>
            </div><!-- /End Row -->
        </div><!-- /End Container -->
    </section>
@endsection


@section('javascript')
@endsection