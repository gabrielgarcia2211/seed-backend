<?php

namespace App\UseCases\Product;

use App\Interfaces\Product\ProductRepositoryInterface;

class CreateProductUseCase
{
    protected $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(array $data)
    {
        return $this->repository->create($data);
    }
}