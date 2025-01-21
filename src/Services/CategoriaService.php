<?php

namespace Services;
use Models\Categoria;

use Repositories\CategoriaRepository;

class CategoriaService
{

    private CategoriaRepository $repository;

    public function __construct()
    {
        $this->repository = new CategoriaRepository();
    }

    public function newCategoria(string $nombre): void
    {
        $this->repository->newCategoria($nombre);
    }

}