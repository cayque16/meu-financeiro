<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MyModelAbstract extends Model
{
    protected $model;

    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getAll()
    {
        return $this->model::all();
    }

    public function getFindOrFail($id)
    {
        return $this->model::findOrFail($id);
    }

    public function insert($request)
    {
        return $this->model::create($request->all());
    }
}