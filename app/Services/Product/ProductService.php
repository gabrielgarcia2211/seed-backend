<?php

namespace App\Services\Product;

use App\Models\Product\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use App\Services\Attachment\AttachmentService;
use App\Interfaces\Product\ProductRepositoryInterface;

class ProductService
{
    protected $productRepository;
    protected $attachmentService;

    public function __construct(ProductRepositoryInterface $productRepository, AttachmentService $attachmentService)
    {
        $this->productRepository = $productRepository;
        $this->attachmentService = $attachmentService;
    }

    public function getAllProducts()
    {
        $products = $this->productRepository->all();
        return $products->map(function ($product) {
            $product->file_url = $product->file_path
                ? Storage::disk('gcs_sim')->url($product->file_path)
                : null;
            return $product;
        });
    }

    public function createProduct($data)
    {
        DB::beginTransaction();
        try {
            $product = $this->productRepository->create($data);
            if (isset($data['attachment'])) {
                $attachmentData = [
                    'attachable_id' => $product->id,
                    'attachable_type' => Product::class,
                    'file' => $data['attachment'],
                    'subfolder' => 'products',
                ];
                $this->attachmentService->store($attachmentData);
            }
            DB::commit();
            return $product;
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            throw $ex;
        }
    }

    public function updateProduct($id, $data)
    {
        DB::beginTransaction();
        try {
            $this->productRepository->update($id, $data);
            if (isset($data['attachment'])) {
                $attachmentData = [
                    'attachable_id' => $id,
                    'attachable_type' => Product::class,
                    'file' => $data['attachment'],
                    'subfolder' => 'products',
                ];
                $this->attachmentService->updateByAttachebleId($attachmentData, $id);
            }
            DB::commit();
            return true;
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::error($ex->getMessage());
            throw $ex;
        }
    }

    public function deleteProduct($id)
    {
        $item = $this->attachmentService->deleteByAttachebleId($id);
        return $this->productRepository->delete($id);
    }

    public function getProductById($id)
    {
        return $this->productRepository->find($id);
    }
}
