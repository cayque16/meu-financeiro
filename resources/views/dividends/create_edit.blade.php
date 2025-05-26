@extends('adminlte::page')

@section('title', 'Dividendo')

@section('content_header')
    <h1>{{ $titulo }} Dividendo</h1>
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
    @php
        echo $btnVoltar;
        $config = ['format' => 'DD-MM-YYYY'];
        $vIdAsset = isset($modelBase) ? $modelBase->idAsset : (isset($request) ? $request->old('id_asset') : '') ;
        $vPaymentDate = isset($modelBase) ? $modelBase->paymentDate : (isset($request) ? $request->old('payment_date') : '');
        $vFiscalYear = isset($modelBase) ? $modelBase->fiscalYear : (isset($request) ? $request->old('fiscal_year') : '');
        $vType = isset($modelBase) ? $modelBase->type : (isset($request) ? $request->old('type') : '');
        $vAmount = isset($modelBase) ? $modelBase->amount : (isset($request) ? $request->old('amount') : '');
        $vIdCurrency = isset($modelBase) ? $modelBase->idCurrency : (isset($request) ? $request->old('id_currency') : '');
        $vAmount = isset($modelBase) ? $modelBase->amount : (isset($request) ? $request->old('amount') : '');
    @endphp
    <form action="{{ $action }}" method="post">
        {{ csrf_field() }}
        <div class="col-sm-12 col-sm-offset-3">
            <div class="row">
            <x-adminlte-select2 label="Ativo:" name="id_asset" fgroup-class="col-md-4" disable-feedback>
                <option value='' selected>Selecione...</option>
                @foreach ($assets as $id => $asset)
                    @if($vIdAsset == $id)
                        <option value='{{ $id }}' selected>{{ $asset }}</option>
                        cotinue;
                    @endif
                    <option value='{{ $id }}'>{{ $asset }}</option>
                @endforeach
            </x-adminlte-select2>
            <x-adminlte-select2 label="Moeda:" name="id_currency" fgroup-class="col-md-4" disable-feedback>
                <option value='' selected>Selecione...</option>
                @foreach ($currencies as $id => $currency)
                    @if($vIdCurrency == $id)
                        <option value='{{ $id }}' selected>{{ $currency }}</option>
                        cotinue;
                    @endif
                    <option value='{{ $id }}'>{{ $currency }}</option>
                @endforeach
            </x-adminlte-select2>
            <x-adminlte-input label="Valor:" type="number" min="0.01" step="0.01" name="amount" placeholder="Insira a quantidade recebida..."
                fgroup-class="col-md-4" value="{{ $vAmount }}" disable-feedback/>
            </div>
            <div class="row">
                <x-adminlte-select2 label="Ano Fiscal:" name="fiscal_year" fgroup-class="col-md-4" disable-feedback>
                    <option value='' selected>Selecione...</option>
                    @foreach ($years as $id => $year)
                        @if($vFiscalYear == $id)
                            <option value='{{ $id }}' selected>{{ $year }}</option>
                            cotinue;
                        @endif
                        <option value='{{ $id }}'>{{ $year }}</option>
                    @endforeach
                </x-adminlte-select2>
                <x-adminlte-input-date label="Data do Pagamento:" fgroup-class="col-md-4" name="payment_date" :config="$config" disable-feedback/>
                <x-adminlte-select2 label="Tipo:" name="type" fgroup-class="col-md-4" disable-feedback>
                    <option value='' selected>Selecione...</option>
                    @foreach ($types as $id => $type)
                        @if($vType == $id)
                            <option value='{{ $id }}' selected>{{ $type }}</option>
                            cotinue;
                        @endif
                        <option value='{{ $id }}'>{{ $type }}</option>
                    @endforeach
                </x-adminlte-select2>
            </div>
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
