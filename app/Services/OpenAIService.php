<?php

namespace App\Services;

use OpenAI\Factory;

class OpenAIService
{
    protected $client;

    public function __construct()
    {
        $this->client = (new Factory())
            ->withApiKey(config('services.openai.key'))
            ->make();
    }

    public function ask(string $question): string
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Eres un asistente educativo especializado en proyectos escolares. Responde preguntas sobre gestión de proyectos, fechas de entrega y metodologías educativas.'
                ],
                [
                    'role' => 'user',
                    'content' => $question
                ]
            ],
            'max_tokens' => 500,
        ]);

        return $response->choices[0]->message->content;
    }

    public function improveWriting(string $text): string
    {
        $response = $this->client->chat()->create([
            'model' => 'gpt-4',
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'Eres un experto en redacción académica. Mejora el siguiente texto para un proyecto escolar manteniendo el significado original pero mejorando su claridad, estructura y formalidad académica.'
                ],
                [
                    'role' => 'user',
                    'content' => $text
                ]
            ],
            'max_tokens' => 1000,
        ]);

        return $response->choices[0]->message->content;
    }
}
