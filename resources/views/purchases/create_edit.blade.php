@extends('adminlte::page')

@section('title', 'Compras')

@section('content_header')
    <h1>Compras</h1>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@stop

@section('plugins.TempusDominusBs4', true)
@section('plugins.BsCustomFileInput', true)

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
    <div class="alert alert-danger" style='display: none;' id='resposta'></div>
    @php
        echo $btnVoltar; 
        $config = ['format' => 'DD-MM-YYYY'];
        $vIdAsset = isset($modelBase) ? $modelBase->id_assets_type : (isset($request) ? $request->old('id_assets_type') : '');
        $vIdBrokerage = isset($modelBase) ? $modelBase->id_assets_type : (isset($request) ? $request->old('id_assets_type') : '');
    @endphp
    <form id='form' action="{{ $action }}" method="post">
    <div class="row">
        {{ csrf_field() }}
        <x-adminlte-input-date fgroup-class="col-md-3" name="data" label="Data" :config="$config" disable-feedback/>
        <x-adminlte-select2 name="id_brokerages" label="Corretora"  fgroup-class="col-md-3" disable-feedback>
                <option value='' selected>Selecione...</option>
                @foreach ($brokerages as $id => $broker)
                    @if($vIdBrokerage == $id)
                        <option value='{{ $id }}' selected>{{ $broker }}</option>
                        cotinue;
                    @endif
                    <option value='{{ $id }}'>{{ $broker }}</option>
                @endforeach
        </x-adminlte-select2>
        <x-adminlte-input id="taxas_total" name="taxas_total" label="Total Taxas" placeholder="Insira o total pago em taxas..."
            fgroup-class="col-md-3" type="number" min="0" value="" disable-feedback/>
        <x-adminlte-input-file label="Nota de Corretagem" name="notaCorretagem" fgroup-class="col-md-3"/>
    </div>
    </form>
    <div class="row">
        <x-adminlte-select2 id="ativo" name="ativo" label="Ativo"  fgroup-class="col-md-4" disable-feedback>
                <option value='' selected>Selecione...</option>
                @foreach ($assets as $id => $asset)
                    @if($vIdAsset == $id)
                        <option value='{{ $id }}' selected>{{ $asset }}</option>
                        cotinue;
                    @endif
                    <option value='{{ $id }}'>{{ $asset }}</option>
                @endforeach
        </x-adminlte-select2>
        
        <x-adminlte-input id="preco" name="preco" label="Preço" placeholder="Insira o preço unitário do ativo..."
                fgroup-class="col-md-4" type="number" min="1" value="" disable-feedback/>
        <x-adminlte-input name="quantidade" label="Quantidade" placeholder="Insira a quantidade de ativos..."
        fgroup-class="col-md-4" type="number" min="1" value="" disable-feedback/>
        </div>
        <div class="div-btn-salvar">
            <x-adminlte-button class="btn-warning" onclick="teste()" label=" Incluir" theme="success" icon="fas fa-plus"/>
            <x-adminlte-button class="btn-success" onclick="document.getElementById('form').submit()" label=" Salvar" theme="success" icon="fas fa-save"/>
        </div>

    <br>
<table id="table-ativos" class="table table-condensed">
    <thead>
        <th>Ativo</th>
        <th>Preço (P)</th>
        <th>Quantidade (Q)</th>
        <th>Taxa (T)</th>
        <th>Total (P x Q) + T</th>
        <tbody id="teste-ativos-conteudo"></tbody>
    </thead>
</table>
@stop

@section('css')
    <link rel="stylesheet" href="/css/app.css">
@stop 

@section('js')
    <script language="javascript" src="/js/adiciona-ativo.js"></script>
@stop
