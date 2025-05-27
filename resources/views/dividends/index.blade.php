@extends('adminlte::page')

@section('title', 'Dividendos')

@section('content_header')
    <h1>Dividendos</h1>
@stop

@section('content')
    <div class="row">
        @if(session('msg'))
            <p id="msg" class="msg">{{ session('msg') }}</p>
        @endif
    </div>

    <form action="/dividends/filterIndex" method="post">
        {{ csrf_field() }}
        <div class="row">
            <x-adminlte-select2 name="payment_year" label="Ano do Pagamento" fgroup-class="col-md-6" disable-feedback>
                <option value='' selected>Selecione...</option>
                @foreach ($paymentYear as $id => $year1)
                    @if(old('payment_year') == $id)
                        <option value='{{ $id }}' selected>{{ $year1 }}</option>
                        continue;
                    @endif
                    <option value='{{ $id }}'>{{ $year1 }}</option>
                @endforeach
            </x-adminlte-select2>
            <x-adminlte-select2 name="fiscal_year" label="Ano Fiscal" fgroup-class="col-md-6" disable-feedback>
                <option value='' selected>Selecione...</option>
                @foreach ($fiscalYears as $id => $year)
                    @if(old('fiscal_year') == $id)
                        <option value='{{ $id }}' selected>{{ $year }}</option>
                        continue;
                    @endif
                    <option value='{{ $id }}'>{{ $year }}</option>
                @endforeach
            </x-adminlte-select2>
        </div>
        <div class="row">
            <x-adminlte-select2 name="asset_id" label="Ativo" fgroup-class="col-md-6" disable-feedback>
                <option value='' selected>Selecione...</option>
                @foreach ($assets as $id => $asset)
                    @if(old('asset_id') == $id)
                        <option value='{{ $id }}' selected>{{ $asset }}</option>
                        continue;
                    @endif
                    <option value='{{ $id }}'>{{ $asset }}</option>
                @endforeach
            </x-adminlte-select2>
            <x-adminlte-select2 name="type" label="Tipo" fgroup-class="col-md-6" disable-feedback>
                <option value='' selected>Selecione...</option>
                @foreach ($types as $id => $type)
                    @if(old('type') == $id)
                        <option value='{{ $id }}' selected>{{ $type }}</option>
                        continue;
                    @endif
                    <option value='{{ $id }}'>{{ $type }}</option>
                @endforeach
            </x-adminlte-select2>
        </div>
        <div class="div-btn-salvar">
            <x-adminlte-button class="btn-success" type="submit" label=" Filtrar" theme="success" icon="fas fa-filter"/>
        </div>
    </form>

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
