<div>
    <!-- Botón flotante -->
    <div class="fixed bottom-6 right-6 z-50">
        <button 
            @click="toggleChat"
            class="w-14 h-14 rounded-full bg-education-primary text-white shadow-lg hover:bg-education-secondary transition-all flex items-center justify-center"
            wire:click="toggle"
        >
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
            </svg>
        </button>
    </div>

    <!-- Panel del chatbot -->
    <div 
        x-show="isOpen"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4"
        x-transition:enter-end="opacity-100 translate-y-0"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 translate-y-4"
        class="fixed right-6 bottom-24 z-40 w-full max-w-xs sm:max-w-md md:max-w-lg"
        :class="{ '!bottom-0 !right-0 !w-screen !h-screen !max-w-none': isFullscreen }"
        wire:ignore.self
    >
        <div class="bg-white rounded-t-lg shadow-xl flex flex-col h-full"
            :class="{ 'rounded-t-lg': !isFullscreen, 'h-screen': isFullscreen }"
            style="{{ $isFullscreen ? 'height: 100vh' : 'max-height: 70vh' }}"
        >
            <!-- Header -->
            <div class="bg-education-primary text-white px-4 py-3 rounded-t-lg flex justify-between items-center">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    <span class="font-medium">Asistente Educativo</span>
                </div>
                <div class="flex space-x-2">
                    <button @click="toggleFullscreen" wire:click="toggleFullscreen" class="text-white hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </svg>
                    </button>
                    <button @click="toggleChat" wire:click="toggle" class="text-white hover:text-gray-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mensajes -->
            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chat-messages">
                @foreach($messages as $msg)
                <div class="flex {{ $msg['type'] === 'user' ? 'justify-end' : 'justify-start' }}">
                    <div class="{{ $msg['type'] === 'user' ? 'bg-education-primary text-white' : 'bg-gray-100 text-gray-800' }} rounded-lg py-2 px-4 max-w-xs sm:max-w-md">
                        <div class="text-sm">{{ $msg['text'] }}</div>
                        <div class="text-xs mt-1 text-right {{ $msg['type'] === 'user' ? 'text-blue-100' : 'text-gray-500' }}">
                            {{ $msg['time'] }}
                        </div>
                    </div>
                </div>
                @endforeach

                @if($isTyping)
                <div class="flex justify-start">
                    <div class="bg-gray-100 text-gray-800 rounded-lg py-2 px-4 max-w-xs">
                        <div class="flex space-x-1">
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                            <div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                        </div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Input -->
            <div class="border-t border-gray-200 p-4">
                <form wire:submit.prevent="sendMessage" class="flex space-x-2">
                    <input 
                        type="text" 
                        wire:model="message" 
                        placeholder="Escribe tu pregunta..." 
                        class="flex-1 border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-education-primary focus:border-transparent"
                        autocomplete="off"
                    >
                    <button 
                        type="submit" 
                        class="bg-education-primary text-white rounded-lg px-4 py-2 hover:bg-education-secondary disabled:opacity-50"
                        wire:loading.attr="disabled"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('livewire:load', function() {
            // Auto-scroll al final de los mensajes
            Livewire.hook('message.processed', (message, component) => {
                const messagesContainer = document.getElementById('chat-messages');
                messagesContainer.scrollTop = messagesContainer.scrollHeight;
            });
        });
    </script>
    @endpush
</div>