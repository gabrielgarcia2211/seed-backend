<?php

namespace App\Services\Attachment;

use App\Services\File\FileService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Interfaces\Attachment\AttachmentRepositoryInterface;

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

    public function update(array $data, $id)
    {
        DB::beginTransaction();
        try {
            $item = $this->attachmentRepository->update($id, $data);
            DB::commit();
            return $item;
        } catch (\Exception $ex) {
            DB::rollBack();
            Log::info($ex->getLine());
            Log::info($ex->getMessage());
            throw $ex;
        }
    }

    public function delete($id)
    {
        try {   
            $this->attachmentRepository->delete($id);
            return true;
        } catch (\Exception $ex) {
            Log::info($ex->getLine());
            Log::info($ex->getMessage());
            throw $ex;
        }
    }
}
