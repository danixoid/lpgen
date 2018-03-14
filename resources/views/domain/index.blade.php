<?php
/**
 * Created by PhpStorm.
 * User: danixoid
 * Date: 07.03.18
 * Time: 10:57
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
                        <h2>Список сайтов</h2>
                        <p class="lead"></p>
                    </div>
                </div>
            </div>


            <div class="table-responsive">
                <table class="table table-striped table-bordered">
                    <thead>
                    <tr>
                        <th width="10%"></th>
                        <th>№</th>
                        <th>Поддомен <a href="{!! route('domain.create') !!}" title="Добавить поддомен"><i class="fa fa-plus"></i></a></th>
                        <th>Алиасы</th>
                        <th>Участники</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $i = 1; ?>
                    @foreach($domains as $domain)
                    <tr>
                        <td>
                            <a href="{!! route('builder.show',$domain->id) !!}" title="Блоки"><i class="fa fa-newspaper-o"></i></a>
                            <a href="{!! route('domain.edit',$domain->id) !!}" title="Редактировать"><i class="fa fa-edit"></i></a>

                            @if($domain->user_id == Auth::user()->id)
                            <a href="#" onclick="if(confirm('Вы действительно хотите удалить домен?')) {
                                    $('#form_domain_delete_{!! $domain->id !!}').submit();
                                    }" title="Удалить поддомен"><i class="fa fa-remove"></i></a>
                            <form id="form_domain_delete_{!! $domain->id !!}" action="{!! route('domain.destroy',$domain->id) !!}" method="POST">
                                {!! csrf_field() !!}
                                {!! method_field('DELETE') !!}
                            </form>
                            @endif
                        </td>
                        <td>{{ $i++ }}</td>
                        <td><a title="Перейти" target="_blank" href="//{{ $domain->name . "." . env('LPGEN_KZ','b-apps.kz') }}">{{ $domain->name . "." . env('LPGEN_KZ','b-apps.kz') }}</a></td>
                        <td>@foreach($domain->l_aliases as $alias)<a target="_blank" title="Перейти" href="//{{ $alias->name }}">{{ $alias->name }}</a><br/>@endforeach</td>
                        <td>
                            @if($domain->user_id == Auth::user()->id)
                                @foreach($domain->users as $user)
                                    <span class="label label-warning"><a href="#" onclick="if(confirm('Вы действительно хотите отобрать права у {!! $user->name !!}?')) {
                                    $('#form_access_delete_{!! $user->id !!}').submit();
                                    }" title="Удалить участника"><i class="fa fa-remove"></i></a> {!! $user->name !!}</span>
                                <form id="form_access_delete_{!! $user->id !!}" action="{!! route('access.destroy',$domain->id) !!}" method="POST">
                                    {!! csrf_field() !!}
                                    {!! method_field('DELETE') !!}
                                    <input type="hidden" name="user_id" value="{!! $user->id !!}" />
                                </form>
                                <br />
                                @endforeach
                                <a href="{!! route('access.create',['l_domain_id' => $domain->id ]) !!}" title="Добавить участника"><i class="fa fa-plus"></i></a>
                            @else Вам выделены права управления
                            @endif
                        </td>
                    </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

        </div><!-- /End Container -->
    </section>
@endsection


@section('javascript')
@endsection