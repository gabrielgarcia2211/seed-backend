<?php

namespace App\Services\Attachment;

use App\Services\File\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\Attachment\AttachmentRepositoryInterface;
use App\Models\Product\Product;

class AttachmentService
{
    protected $attachmentRepository;
    protected $fileService;

    public function __construct(AttachmentRepositoryInterface $attachmentRepository, FileService $fileService)
    {
        $this->fileService = $fileService;
        $this->attachmentRepository = $attachmentRepository;
    }

    public function store(array $data)
    {
        DB::beginTransaction();
        try {
            if (isset($data['file'])) {
                $filePath = $this->fileService->saveFile($data['file'], $data['subfolder']);
                $data['name'] = $data['file']->getClientOriginalName();
                $data['file_path'] = $filePath;
                $data['file_type'] = $data['file']->getClientMimeType();
            }
            $item = $this->attachmentRepository->create($data);
            DB::commit();
            return $item;
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::info($ex->getLine());
            Log::info($ex->getMessage());
            throw $ex;
        }
    }

    public function updateByAttachebleId(array $data, $id)
    {
        DB::beginTransaction();
        try {
            $preparedData  = $this->handleFileAttachment($id, $data);
            $existingAttachment = $this->attachmentRepository->findByAttachebleId($id, Product::class);
            if ($existingAttachment) {
                $item = $this->attachmentRepository->updateByAttachebleId($id, $preparedData);
            } else {
                $preparedData['attachable_id'] = $id;
                $preparedData['attachable_type'] = Product::class;
                $item = $this->attachmentRepository->create($preparedData);
            }
            DB::commit();
            return $item;
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::info($ex->getLine());
            Log::info($ex->getMessage());
            throw $ex;
        }
    }

    public function deleteByAttachebleId($id)
    {
        try {
            $item = $this->attachmentRepository->findByAttachebleId($id, Product::class);
            if (!empty($item) && $item->file_path) {
                $this->fileService->deleteFile($item->file_path);
            }
            $this->attachmentRepository->deleteByAttachebleId($id);
            return true;
        } catch (\Exception $ex) {
            Log::info($ex->getLine());
            Log::info($ex->getMessage());
            throw $ex;
        }
    }

    private function handleFileAttachment($id, &$data)
    {
        $item = $this->attachmentRepository->findByAttachebleId($id, Product::class);
        if (isset($data['file']) && $data['file']) {
            if (!empty($item) && $item->file_path) {
                $this->fileService->deleteFile($item->file_path);
            }
            $filePath = $this->fileService->saveFile($data['file'], $data['subfolder'] ?? '');
            return [
                'name' => $data['file']->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $data['file']->getClientMimeType(),
            ];
        }
        return [];
    }
}
