@extends('adminlte::page')

@section('title', 'Tipos de Ativo')

@section('content_header')
    <h1>Tipos de Ativo</h1>
@stop

@section('content')

    <div class="row">
        @if(session('msg'))
            <p id="msg" class="msg">{{ session('msg') }}</p>
        @endif
    </div>

    @php echo $btnAdd @endphp

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
    <script language="javascript" src="/js/desativa.js"></script>
@stop
