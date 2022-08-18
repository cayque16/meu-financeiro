<?php

namespace App\Http\Controllers;

use App\Models\Purchase;

class PurchasesController extends MyControllerAbstract
{
    public function __construct()
    {
        parent::__construct((new Purchase), 'purchases');
    }
    
    protected function getCabecalho()
    {

    }

    protected function getTabela($dados)
    {
        
    }
}
