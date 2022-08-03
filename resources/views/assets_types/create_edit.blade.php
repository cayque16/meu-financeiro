@extends('adminlte::page')

@section('title', 'Adicionar Tipo de Ativo')

@section('content_header')
    <h1>Adicionar Tipo de Ativo</h1>
@stop

@section('content')
    @php
        echo $btnVoltar;
    @endphp
    <form action="/assets_type" method="post">
        {{ csrf_field() }}
        <div class="row">
            <x-adminlte-input name="nome" label="Nome" placeholder="Insira o nome do ativo..."
                fgroup-class="col-md-4" disable-feedback/>
            <x-adminlte-input name="descricao" label="Descrição" placeholder="Insira a descrição do ativo..."
            fgroup-class="col-md-8" disable-feedback/>
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
    
@stop
