<?php

namespace App\Livewire\Ui;

use Livewire\Component;
use App\Services\OpenAIService;
use Illuminate\Support\Facades\Log;

class FloatingChatbot extends Component
{
    public $isOpen = false;
    public $isFullscreen = false;
    public $message = '';
    public $messages = [];
    public $isTyping = false;

    protected $listeners = ['toggleChatbot' => 'toggle'];

    public function mount()
    {
        if (empty($this->messages)) {
            $this->addBotMessage("¡Hola! Soy tu asistente educativo. ¿En qué puedo ayudarte hoy?");
        }
    }

    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
    }

    public function toggleFullscreen()
    {
        $this->isFullscreen = !$this->isFullscreen;
    }

    public function sendMessage()
    {
        if (empty(trim($this->message))) return;

        $this->addUserMessage($this->message);
        $this->isTyping = true;
        
        try {
            // Esta llamada ahora es segura. Si falla, será dentro del try-catch.
            $response = app(OpenAIService::class)->ask($this->message);
            $this->addBotMessage($response);
        } catch (\Exception $e) {
            // Loguea el error real para que puedas verlo en storage/logs/laravel.log
            \Log::error('Error en Chatbot: ' . $e->getMessage()); 
            
            // Muestra un mensaje amigable al usuario
            $this->addBotMessage("Lo siento, no puedo conectar con el asistente en este momento. Revisa la configuración de la API.");
        }

        $this->isTyping = false;
        $this->message = '';
    }

    private function addUserMessage($text)
    {
        $this->messages[] = ['type' => 'user', 'text' => $text, 'time' => now()->format('H:i')];
    }

    private function addBotMessage($text)
    {
        $this->messages[] = ['type' => 'bot', 'text' => $text, 'time' => now()->format('H:i')];
    }

    public function render()
    {
        // La vista sigue siendo la misma, pero ahora la clase del componente no se romperá
        return view('livewire.ui.floating-chatbot');
    }
}