<?php

namespace App\Interfaces\Attachment;

interface AttachmentRepositoryInterface
{
    public function create(array $attributes);
    public function update($id, array $attributes);
    public function updateByAttachebleId($id, array $attributes);
    public function findByAttachebleId($id, $class);
    public function deleteByAttachebleId($id);
}
