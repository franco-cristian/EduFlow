<?php

namespace App\Services;

use OpenAI;
use OpenAI\Client;
use Illuminate\Support\Facades\Config;

class OpenAIService
{
    protected ?Client $client = null;

    protected function client(): Client
    {
        if ($this->client === null) {
            $apiType = Config::get('services.openai.api_type', 'openai'); // Por defecto 'openai'

            if (strtolower($apiType) === 'azure') {
                // --- Configuración para Azure ---
                $apiKey = Config::get('services.openai.key');
                $azureEndpoint = Config::get('services.openai.azure_endpoint');
                $azureDeployment = Config::get('services.openai.azure_deployment');
                $apiVersion = Config::get('services.openai.version');

                if (empty($apiKey) || empty($azureEndpoint) || empty($azureDeployment) || empty($apiVersion)) {
                    throw new \Exception('Azure OpenAI configuration is incomplete. Please check your .env file.');
                }

                // La librería openai-php usa estos nombres para las cabeceras
                $this->client = OpenAI::factory()
                    ->withBaseUri("$azureEndpoint/openai/deployments/$azureDeployment")
                    ->withHttpHeader('api-key', $apiKey)
                    ->withQueryParam('api-version', $apiVersion)
                    ->make();

            } else {
                // --- Configuración para OpenAI estándar ---
                $apiKey = Config::get('services.openai.key');
                if (empty($apiKey)) {
                    throw new \Exception('OpenAI API key is not configured.');
                }
                $this->client = OpenAI::client($apiKey);
            }
        }
        
        return $this->client;
    }

    public function ask(string $question): string
    {
        $response = $this->client()->chat()->create([
            // Para Azure, no necesitas pasar el 'model', ya está en la URL del endpoint.
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
            'max_tokens' => 800,
        ]);

        return $response->choices[0]->message->content;
    }

    // ... puedes adaptar el método improveWriting de la misma forma ...
}