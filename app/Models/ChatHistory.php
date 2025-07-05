<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Casts\Attribute;

class ChatHistory extends Model
{
    protected $fillable = [
        'user_id',
        'message',
        'response',
        'session_id',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'array'
    ];

    // Relación con usuario
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Accesor para tiempo transcurrido
    protected function elapsedTime(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->created_at->diffForHumans()
        );
    }

    // Accesor para mensaje truncado
    protected function shortMessage(): Attribute
    {
        return Attribute::make(
            get: fn () => str($this->message)->limit(50)
        );
    }

    // Accesor para respuesta truncada
    protected function shortResponse(): Attribute
    {
        return Attribute::make(
            get: fn () => str($this->response)->limit(50)
        );
    }
}