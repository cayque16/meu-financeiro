@extends('adminlte::page')

@section('title', 'Corretoras')

@section('content_header')
    <h1>Corretoras</h1>
@stop

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    @php
        echo $btnVoltar;
        $vNome = isset($modelBase) ? $modelBase->nome : (isset($request) ? $request->old('nome') : '');
        $vSite = isset($modelBase) ? $modelBase->site : (isset($request) ? $request->old('site') : '');
        $vCnpj = isset($modelBase) ? $modelBase->cnpj : (isset($request) ? $request->old('cnpj') : '');
    @endphp
    <form action="{{ $action }}" method="post">
        {{ csrf_field() }}
        <div class="col-sm-12 col-sm-offset-3">
            <x-adminlte-input name="nome" label="Nome" placeholder="Insira o nome da corretora..."
                fgroup-class="col-md-12" value='{{ $vNome}}' disable-feedback/>
            <x-adminlte-input name="site" label="Site" placeholder="Insira o site da corretora..."
                fgroup-class="col-md-12" value='{{ $vSite }}' disable-feedback/>
            <x-adminlte-input name="cnpj" label="CNPJ" id="cnpj" placeholder="00.000.000/0000-00"
                fgroup-class="col-md-12" value='{{ $vCnpj }}' disable-feedback/>
        </div>
        <div class="div-btn-salvar">
            <x-adminlte-button class="btn-success" type="submit" label=" Salvar" theme="success" icon="fas fa-save"/>
        </div>
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/app.css">
@stop 

@section('js')
    <script language="javascript" src="/js/jquery-1.2.6.pack.js"></script>
    <script language="javascript" src="/js/jquery.maskedinput-1.1.4.pack.js"></script>
    <script language="javascript" src="/js/teste.js"></script>
@stop
