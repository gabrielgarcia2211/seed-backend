<?php

namespace App\Models\Attachment;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $table = 'attachments';
    protected $fillable = [
        'attachable_id',
        'attachable_type',
        'file_path',
        'file_type',
        'name',
    ];
}