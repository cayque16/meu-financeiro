<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

const CAMINHO_VIEWS = 'resources/views/';

const VIEW_MODELO = 'layouts/model.blade.php';

const EXTENSAO = '.blade.php';

class CriarViewBase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:nova-view {caminho}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Criar uma nova view com base no meu modelo';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $model = dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR.CAMINHO_VIEWS.VIEW_MODELO;
        $caminho = $this->argument('caminho');
        $arrayCaminho = explode('/', $caminho);
        $view = array_pop($arrayCaminho);
        $pastas = implode('/', $arrayCaminho);

        if(!is_dir(base_path(CAMINHO_VIEWS.$pastas))){
            mkdir(CAMINHO_VIEWS.$pastas);
        }

        $newView = dirname(dirname(dirname(__DIR__))).DIRECTORY_SEPARATOR.CAMINHO_VIEWS.$pastas.DIRECTORY_SEPARATOR.$view.EXTENSAO;
        if(!copy($model, $newView)){
            $this->info("Erro ao gerar view.");
        } else {
            $this->info("View gerada com sucesso!!!");
        }
        
        return 0;
    }
}
