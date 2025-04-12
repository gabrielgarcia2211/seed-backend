<?php

namespace App\Repositories\Attachment;

use App\Models\Attachment\Attachment;
use App\Interfaces\Attachment\AttachmentRepositoryInterface;

class AttachmentRepository implements AttachmentRepositoryInterface
{
    protected $model;

    public function __construct(Attachment $attachment)
    {
        $this->model = $attachment;
    }

    public function create(array $attributes)
    {
        return $this->model->create($attributes);
    }

    public function update($id, array $attributes)
    {
        $attachment = $this->model->findOrFail($id);
        $attachment->update($attributes);
        return $attachment;
    }

    public function delete($id)
    {
        $attachment = $this->model->findOrFail($id);
        $attachment->delete();
        return $attachment;
    }
}
