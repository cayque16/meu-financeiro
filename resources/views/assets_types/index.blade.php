@extends('adminlte::page')

@section('title', 'Tipos de Ativo')

@section('content_header')
    <h1>Tipos de Ativo</h1>
@stop

@section('content')
<x-adminlte-datatable id="table1" :heads="$heads">
    @foreach($config['data'] as $row)
        <tr>
            @foreach($row as $cell)
                <td>{!! $cell !!}</td>
            @endforeach
        </tr>
    @endforeach
</x-adminlte-datatable>
@stop

@section('css')
    
@stop

@section('js')
    
@stop
