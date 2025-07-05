<?php

namespace App\Livewire\Ui;

use Livewire\Component;
use App\Services\OpenAIService;

class FloatingChatbot extends Component
{
    public $isOpen = false;
    public $isFullscreen = false;
    public $message = '';
    public $messages = [];
    public $isTyping = false;

    protected $listeners = ['toggleChatbot' => 'toggle'];

    public function toggle()
    {
        $this->isOpen = !$this->isOpen;
        if ($this->isOpen && empty($this->messages)) {
            $this->addBotMessage("¡Hola! Soy tu asistente educativo. ¿En qué puedo ayudarte hoy?");
        }
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
            $response = app(OpenAIService::class)->ask($this->message);
            $this->addBotMessage($response);
        } catch (\Exception $e) {
            $this->addBotMessage("Lo siento, hubo un error. Por favor intenta nuevamente.");
        }

        $this->isTyping = false;
        $this->message = '';
    }

    private function addUserMessage($text)
    {
        $this->messages[] = [
            'type' => 'user',
            'text' => $text,
            'time' => now()->format('H:i')
        ];
    }

    private function addBotMessage($text)
    {
        $this->messages[] = [
            'type' => 'bot',
            'text' => $text,
            'time' => now()->format('H:i')
        ];
    }

    public function render()
    {
        return view('livewire.floating-chatbot');
    }
}