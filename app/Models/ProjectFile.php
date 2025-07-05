<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;
use App\Models\Project;
use App\Models\User;

class ProjectFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'original_name',
        'stored_name',
        'mime_type',
        'size',
        'path',
        'description',
        'project_id',
        'uploaded_by'
    ];

    protected $appends = ['file_url', 'icon'];

    // Relación con proyecto
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    // Relación con usuario que subió el archivo
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Accesor para URL de descarga
    protected function fileUrl(): Attribute
    {
        return Attribute::make(
            get: fn () => route('files.download', $this)
        );
    }

    // Accesor para icono según tipo de archivo
    protected function icon(): Attribute
    {
        return Attribute::make(
            get: function () {
                $types = [
                    'pdf'  => 'file-pdf',
                    'doc'  => 'file-word',
                    'docx' => 'file-word',
                    'xls'  => 'file-excel',
                    'xlsx' => 'file-excel',
                    'ppt'  => 'file-powerpoint',
                    'pptx' => 'file-powerpoint',
                    'zip'  => 'file-archive',
                    'rar'  => 'file-archive',
                    'jpg'  => 'file-image',
                    'jpeg' => 'file-image',
                    'png'  => 'file-image',
                    'gif'  => 'file-image',
                ];

                $extension = strtolower(pathinfo($this->original_name, PATHINFO_EXTENSION));
                return $types[$extension] ?? 'file';
            }
        );
    }
}