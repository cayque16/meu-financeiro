@extends('adminlte::page')

@section('title', 'Ativo')

@section('content_header')
    <h1>{{ $titulo }} Ativo</h1>
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
        $vCodigo = isset($modelBase) ? $modelBase->codigo : (isset($request) ? $request->old('codigo') : '') ;
        $vDescricao = isset($modelBase) ? $modelBase->descricao : (isset($request) ? $request->old('descricao') : '');
        $vIdAssetsType = isset($modelBase) ? $modelBase->id_assets_type : (isset($request) ? $request->old('id_assets_type') : '');
    @endphp
    <form action="{{ $action }}" method="post">
        {{ csrf_field() }}
        <div class="col-sm-12 col-sm-offset-3">
            <label for="codigo">Código:
                <span class="asterisco" data-toggle="tooltip" title data-original-title="Campo com preenchimento obrigatório.">*</span>
            </label>
            <x-adminlte-input name="codigo" placeholder="Insira o código do ativo..."
                fgroup-class="col-md-12" value="{{ $vCodigo }}" disable-feedback/>
            <label for="descricao">Descrição:
                <span class="asterisco" data-toggle="tooltip" title data-original-title="Campo com preenchimento obrigatório.">*</span>
            </label>
            <x-adminlte-input name="descricao" placeholder="Insira a descrição do ativo..."
            fgroup-class="col-md-12" value="{{ $vDescricao }}" disable-feedback/>
            <label for="id_assets_type">Tipo de Ativo:
                <span class="asterisco" data-toggle="tooltip" title data-original-title="Campo com preenchimento obrigatório.">*</span>
            </label>
            <x-adminlte-select2 name="id_assets_type" fgroup-class="col-md-12" disable-feedback>
                <option value='' selected>Selecione...</option>
                @foreach ($assetsType as $id => $type)
                    @if($vIdAssetsType == $id)
                        <option value='{{ $id }}' selected>{{ $type }}</option>
                        cotinue;
                    @endif
                    <option value='{{ $id }}'>{{ $type }}</option>
                @endforeach
            </x-adminlte-select2>
            <div class="div-btn-salvar">
                <x-adminlte-button class="btn-success" type="submit" label=" Salvar" theme="success" icon="fas fa-save"/>
            </div>
        </div>
        
    </form>
@stop

@section('css')
    <link rel="stylesheet" href="/css/app.css">
@stop 

@section('js')
    
@stop
