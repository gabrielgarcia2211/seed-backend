<?php

namespace App\UseCases\Product;

use App\Interfaces\Product\ProductRepositoryInterface;

class ListProductsUseCase
{
    protected ProductRepositoryInterface $repository;

    public function __construct(ProductRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute()
    {
        return $this->repository->all();
    }
}