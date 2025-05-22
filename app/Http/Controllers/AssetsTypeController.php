<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Enums\Status;
use App\Http\Requests\StoreAssetsTypeRequest;
use Core\UseCase\AssetType\ActivateDisableAssetTypeUseCase;
use Core\UseCase\AssetType\CreateAssetTypeUseCase;
use Core\UseCase\AssetType\ListAssetsTypesUseCase;
use Core\UseCase\AssetType\ListAssetTypeUseCase;
use Core\UseCase\AssetType\UpdateAssetTypeUseCase;
use Core\UseCase\DTO\AssetType\ActivateDisable\ActivateDisableAssetTypeInputDto;
use Core\UseCase\DTO\AssetType\AssetTypeInputDto;
use Core\UseCase\DTO\AssetType\Create\CreateAssetTypeInputDto;
use Core\UseCase\DTO\AssetType\ListAssetsTypes\ListAssetsTypesInputDto;
use Core\UseCase\DTO\AssetType\Update\UpdateAssetTypeInputDto;
use Illuminate\Http\Request;

class AssetsTypeController extends Controller
{
    public function index(Request $request, ListAssetsTypesUseCase $useCase)
    {
        $allDados = $useCase->execute(new ListAssetsTypesInputDto());
        
        $dados['cabecalho'] = $this->getHead();

        $dados['tabela'] = ['data' => $this->getTable($allDados)];

        $dados['btnAdd'] = getBtnLink(ButtonType::INCLUDE, link: "assets_type/create");

        return view("assets_type.index", $dados);
    }

    public function create()
    {
        $dados['btnVoltar'] = getBtnLink(ButtonType::BACK, link: "/assets_type");
        $dados['titulo'] = 'Adicionar';
        $dados['action'] = "/assets_type";

        return view("assets_type.create_edit", $dados);
    }

    public function store(
        StoreAssetsTypeRequest $request,
        CreateAssetTypeUseCase $useCase
    ) {
        $response = $useCase->execute(
            new CreateAssetTypeInputDto(
                $request->nome,
                $request->descricao,
            )
        );
        
        return redirect("/assets_type")->with('msg', 'Tipo de ativo inserido com sucesso!');
    }

    public function edit(
        ListAssetTypeUseCase $useCase,
        $id,
    ) {
        $dados['btnVoltar'] = getBtnLink(ButtonType::BACK, link: "/assets_type");
        $dados['modelBase'] = $useCase->execute(new AssetTypeInputDto($id));
        $dados['titulo'] = 'Editar';
        $dados['action'] = "/assets_type/update/$id";

        return view("assets_type.create_edit", $dados);
    }

    public function update(
        StoreAssetsTypeRequest $request,
        UpdateAssetTypeUseCase $useCase,
        $id,
    ) {
        $useCase->execute(
            new UpdateAssetTypeInputDto(
                id: $id,
                name: $request->nome,
                description: $request->descricao,
            )
        );

        return redirect("/assets_type")->with('msg', 'Tipo de ativo editado com sucesso!');
    }

    public function enable(ActivateDisableAssetTypeUseCase $useCase, $id, $value)
    {
        $useCase->execute(
            new ActivateDisableAssetTypeInputDto(
                id: $id,
                activate: (bool) $value,
            )
        );

        return redirect("/assets_type")->with('msg', 'Tipo de ativo editado com sucesso!');
    }

    protected function getHead()
    {
        return  [
            'Id',
            'Nome',
            'Descrição',
            'Data Criação',
            'Data Atualização',
            'Data Desativação',
            ['label' => 'Ações','no-export' => true, 'width' => 5]
        ];
    }

    protected function getTable($dados)
    {
        $data = [];
        foreach($dados->items as $dado) {
            $button = $dado->isActive() ? ButtonType::DISABLE : ButtonType::ACTIVATE;
            $action = $dado->isActive() ? Status::ACTIVE : Status::INACTIVE;
            $data[] = [
                $dado->id, 
                $dado->name,
                $dado->description,
                $dado->createdAt()?->toDateBr(),
                $dado->updatedAt()?->toDateBr(),
                $dado->deletedAt()?->toDateBr() ?? "-",
                "<nobr>".getBtnLink(ButtonType::EDIT, "/assets_type/edit/$dado->id")."  ".getBtnLink($button, "/assets_type/enable/$dado->id/$action")."</nobr>"
            ];
        }
        return $data;
    }
}
