@extends('adminlte::page')

@section('title', 'Dashboard')

@section('content_header')
    <h1>{{ $labelFiltro }}</h1>
@stop

@section('content')
<form action="/home" method="post">
        {{ csrf_field() }}
        <div class="col-sm-12 col-sm-offset-3">
            <x-adminlte-select2 name="ano" label="Ano" fgroup-class="col-md-12" disable-feedback>
                <option value='' selected>Todos</option>
                @foreach ($slAnos as $id => $anoLinha)
                    @if($ano == $id)
                        <option value='{{ $id }}' selected>{{ $anoLinha }}</option>
                        cotinue;
                    @endif
                    <option value='{{ $id }}'>{{ $anoLinha }}</option>
                @endforeach
            </x-adminlte-select2>
            <div class="div-btn-salvar">
                <x-adminlte-button class="btn-success" type="submit" label=" Filtrar" theme="success" icon="fas fa-filter"/>
            </div>
        </div>
    </form>
    <br>
<x-adminlte-datatable id="table1" :heads="$cabecalho">
        @foreach($tabela['data'] as $row)
            <tr>
                @foreach($row as $cell)
                    <td>{!! $cell !!}</td>
                @endforeach
            </tr>
        @endforeach
    </x-adminlte-datatable>
@stop

@section('css')
    <link rel="stylesheet" href="/css/app.css">
@stop

@section('js')
    
@stop
