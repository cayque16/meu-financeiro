@extends('adminlte::page')

@section('title', 'Ativos')

@section('content_header')
    
    <h3>{{ $dataCompra }} - {{ $valorTotal }} 
        @if ($linkNotaCorretagem) 
            - <a href="{{ $linkNotaCorretagem }}" target="_blank">Nota Corretagem </a> 
        @endif
    </h3>
@stop

@section('content')
    @php
        echo $btnVoltar; 
    @endphp

    <table class="table table-condensed">
    <thead>
        <th>Ativo</th>
        <th>Preço (P)</th>
        <th>Quantidade (Q)</th>
        <th>Taxa (T)</th>
        <th>Total (P x Q) + T</th>
        @foreach($arrayTabela as $linha)
            <tr>
                <td>{{ $linha['codigo'] }}</td>
                <td>{{ $linha['valor_unitario'] }}</td>
                <td>{{ $linha['quantidade'] }}</td>
                <td>{{ $linha['taxas'] }}</td>
                <td>{{ $linha['total'] }}</td>
            </tr>
        @endforeach
    </thead>
</table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/app.css">
@stop 

@section('js')
@stop
