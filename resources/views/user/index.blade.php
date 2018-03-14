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
                        <h2>Пользователи</h2>
                        <p class="lead"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form class="form" id="form_user_search" action="{!! route("user.index") !!}">

                        <div class="form-group">
                            <input type="search" name="q" class="form-control" value="{!! request('q') !!}"
                                   placeholder="Введите строку поиска">
                        </div>

                    </form>

                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th>№</th>
                            <th>Имя</th>
                            <th>Email адрес</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td>{!! $user->id !!}</td>
                                <td><a href="{!! route('user.show',['id' => $user->id]) !!}">{!! $user->name !!}</a></td>
                                <td><span class="text-info">{!! $user->email !!}</span></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </section>
@endsection

