<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Enums\Status;
use App\Http\Requests\StoreAssetRequest;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\Asset\ActivateDisableAssetUseCase;
use Core\UseCase\Asset\CreateAssetUseCase;
use Core\UseCase\Asset\ListAssetsUseCase;
use Core\UseCase\Asset\ListAssetUseCase;
use Core\UseCase\Asset\UpdateAssetUseCase;
use Core\UseCase\AssetType\ListAssetsTypesUseCase;
use Core\UseCase\DTO\Asset\ActivateDisable\ActivateDisableAssetInputDto;
use Core\UseCase\DTO\Asset\AssetInputDto;
use Core\UseCase\DTO\Asset\Create\CreateAssetInputDto;
use Core\UseCase\DTO\Asset\ListAssets\ListAssetsInputDto;
use Core\UseCase\DTO\Asset\Update\UpdateAssetInputDto;
use Core\UseCase\DTO\AssetType\ListAssetsTypes\ListAssetsTypesInputDto;

class AssetsController extends Controller
{
    public function index(ListAssetsUseCase $useCase)
    {
        $response = $useCase->execute(new ListAssetsInputDto());
        $data["cabecalho"] = $this->getHead();
        $data["tabela"] = ['data' => $this->getTable($response)];
        $data["btnAdd"] = getBtnLink(ButtonType::INCLUDE, link: "assets/create");

        return view("assets.index", $data);
    }

    public function create(ListAssetsTypesUseCase $useCase)
    {
        $types = $useCase->execute(new ListAssetsTypesInputDto(includeInactive: false));
        
        $data['btnVoltar'] = getBtnLink(ButtonType::BACK, link: "/assets");
        $data['titulo'] = 'Adicionar';
        $data['action'] = "/assets";
        $data["assetsType"] = $this->getAssetsType(($types->items));

        return view("assets.create_edit", $data);
    }

    public function store(
        StoreAssetRequest $request,
        CreateAssetUseCase $useCase
    ) {
        $useCase->execute(
            new CreateAssetInputDto(
                code: $request->codigo,
                idType: $request->id_assets_type,
                description: $request->descricao,
            )
        );

        return redirect("/assets")->with("msg", "Ativo inserido com sucesso!");
    }
    
    public function edit(
        ListAssetUseCase $useCaseAsset,
        ListAssetsTypesUseCase $useCaseType,
        $id
    ) {
        $types = $useCaseType->execute(new ListAssetsTypesInputDto(includeInactive: false));
        $data['btnVoltar'] = getBtnLink(ButtonType::BACK, link: "/assets");
        $data['modelBase'] = $useCaseAsset->execute(new AssetInputDto($id));
        $data['titulo'] = 'Editar';
        $data['action'] = "/assets/update/$id";
        $data["assetsType"] = $this->getAssetsType(($types->items));

        return view("assets.create_edit", $data);
    }

    public function update(
        StoreAssetRequest $request,
        UpdateAssetUseCase $useCase,
        $id,
    ) {
        $useCase->execute(
            new UpdateAssetInputDto(
                id: $id,
                code: $request->codigo,
                idType: $request->id_assets_type,
                description: $request->descricao,
            )
        );

        return redirect("/assets")->with("msg", "Ativo editado com sucesso!");
    }

    public function enable(ActivateDisableAssetUseCase $useCase, $id, $value)
    {
        $useCase->execute(
            new ActivateDisableAssetInputDto(
                id: $id,
                activate: (bool) $value,
            )
        );

        return redirect("/assets")->with('msg', 'Ativo editado com sucesso!');
    }

    private function getAssetsType($types)
    {
        $result = [];
        foreach ($types as $type) {
            $result[$type->id()] = $type->name;
        }
        return $result;
    }

    private function getTable($data)
    {
        $result = [];
        foreach($data->items as $item) {
            $button = $item->isActive() ? ButtonType::DISABLE : ButtonType::ACTIVATE;
            $action = $item->isActive() ? Status::ACTIVE : Status::INACTIVE;
            $result[] = [
                Uuid::short($item->id),
                $item->code,
                $item->description,
                $item->type->name,
                $item->createdAt()?->toDateBr(true),
                $item->updatedAt()?->toDateBr(true),
                $item->deletedAt()?->toDateBr(true) ?? "-",
                "<nobr>".getBtnLink(ButtonType::EDIT, "/assets/edit/$item->id")."  ".getBtnLink($button, "/assets/enable/$item->id/$action")."</nobr>",
            ];
        }

        return $result;
    }

    private function getHead()
    {
        return [
            'Id',
            'Código',
            'Descricao',
            'Tipo de Ativo',
            'Data Criação',
            'Data Atualização',
            'Data Desativação',
            ['label' => 'Ações','no-export' => true, 'width' => 5]
        ];
    }
}
