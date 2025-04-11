<?php

namespace App\Http\Controllers\Product;

use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Services\Product\ProductService;
use App\Http\Requests\Product\StoreProductRequest;
use App\Http\Requests\Product\UpdateProductRequest;
use App\Http\Controllers\ResponseController as Response;

class ProductController extends Controller
{
    protected $productService;
    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $products = $this->productService->getAllProducts();
            return Response::sendResponse($products, 'Registros obtenidos con exito.');
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Response::sendError('Ocurrio un error inesperado al intentar procesar la solicitud', 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        try {
            $product = $this->productService->createProduct($request->all());
            return Response::sendResponse($product, 'Registro creado con exito.');
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Response::sendError('Ocurrio un error inesperado al intentar procesar la solicitud', 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, string $id)
    {
        try {
            $product = $this->productService->getProductById($id);;
            if (!$product) {
                return Response::sendError('El registro no existe.', 404);
            }
            $product = $this->productService->updateProduct($id, $request->all());
            return Response::sendResponse($product, 'Registro actualizado con exito.');
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Response::sendError('Ocurrio un error inesperado al intentar procesar la solicitud', 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $product = $this->productService->getProductById($id);;
            if (!$product) {
                return Response::sendError('El registro no existe.', 404);
            }
            $this->productService->deleteProduct($id);
            return Response::sendResponse([], 'Registro eliminado con exito.');
        } catch (\Exception $ex) {
            Log::error($ex->getMessage());
            return Response::sendError('Ocurrio un error inesperado al intentar procesar la solicitud', 500);
        }
    }
}
