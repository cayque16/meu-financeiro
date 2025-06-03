<?php

namespace App\Http\Controllers;

use App\Enums\ButtonType;
use App\Enums\Status;
use App\Http\Requests\StoreBrokerageRequest;
use Core\Domain\ValueObject\Cnpj;
use Core\Domain\ValueObject\Uuid;
use Core\UseCase\Brokerage\ActivateDisableBrokerageUseCase;
use Core\UseCase\Brokerage\CreateBrokerageUseCase;
use Core\UseCase\Brokerage\ListBrokeragesUseCase;
use Core\UseCase\Brokerage\ListBrokerageUseCase;
use Core\UseCase\Brokerage\UpdateBrokerageUseCase;
use Core\UseCase\DTO\Brokerage\ActivateDisable\ActivateDisableBrokerageInputDto;
use Core\UseCase\DTO\Brokerage\BrokerageInputDto;
use Core\UseCase\DTO\Brokerage\Create\CreateBrokerageInputDto;
use Core\UseCase\DTO\Brokerage\ListBrokerages\ListBrokeragesInputDto;
use Core\UseCase\DTO\Brokerage\Update\UpdateBrokerageInputDto;

class BrokeragesController extends Controller
{
    public function index(ListBrokeragesUseCase $useCase)
    {
        $allDados = $useCase->execute(new ListBrokeragesInputDto());

        $dados['cabecalho'] = $this->getHead();
        $dados['tabela'] = ['data' => $this->getTable($allDados)];
        $dados['btnAdd'] = getBtnLink(ButtonType::INCLUDE, link: "brokerages/create");

        return view("brokerages.index", $dados);
    }

    public function create()
    {
        $dados['btnVoltar'] = getBtnLink(ButtonType::BACK, link: "/brokerages");
        $dados['titulo'] = 'Adicionar';
        $dados['action'] = "/brokerages";

        return view("brokerages.create_edit", $dados);
    }

    public function store(
        StoreBrokerageRequest $request,
        CreateBrokerageUseCase $useCase
    ) {
        $response = $useCase->execute(
            new CreateBrokerageInputDto(
                $request->nome,
                $request->site,
                new Cnpj($request->cnpj)
            )
        );
        
        return redirect("/brokerages")->with('msg', 'Corretora inserida com sucesso!');
    }

    public function edit(ListBrokerageUseCase $useCase, $id)
    {
        $dados['btnVoltar'] = getBtnLink(ButtonType::BACK, link: "/brokerages");
        $dados['modelBase'] = $useCase->execute(new BrokerageInputDto($id));
        $dados['titulo'] = 'Editar';
        $dados['action'] = "/brokerages/update/$id";

        return view("brokerages.create_edit", $dados);
    }

    public function update(
        StoreBrokerageRequest $request,
        UpdateBrokerageUseCase $useCase,
        $id,
    ) {
        $useCase->execute(
            new UpdateBrokerageInputDto(
                id: $id,
                name: $request->nome,
                webPage: $request->site,
                cnpj: new Cnpj($request->cnpj)
            )
        );

        return redirect("/brokerages")->with('msg', 'Corretora editada com sucesso!');
    }

    public function enable(ActivateDisableBrokerageUseCase $useCase, $id, $value)
    {
        $useCase->execute(
            new ActivateDisableBrokerageInputDto(
                id: $id,
                activate: (bool) $value,
            )
        );

        return redirect("/brokerages")->with('msg', 'Corretora editada com sucesso!');
    }

    protected function getHead()
    {
        return [
            'id',
            'Nome',
            'Site',
            'CNPJ',
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
                Uuid::short($dado->id),
                $dado->name,
                $dado->webPage,
                (string) $dado->cnpj,
                $dado->createdAt()?->toDateBr(true),
                $dado->updatedAt()?->toDateBr(true),
                $dado->deletedAt()?->toDateBr(true) ?? "-",
                "<nobr>".getBtnLink(ButtonType::EDIT, "/brokerages/edit/$dado->id")."  ".getBtnLink($button, "/brokerages/enable/$dado->id/$action")."</nobr>"
            ];
        }
        return $data;
    }
}
