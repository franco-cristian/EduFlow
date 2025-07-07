<div x-data="{ 
        isOpen: @entangle('isOpen').live,
        isFullscreen: @entangle('isFullscreen').live
     }"
     @toggle-chatbot.window="isOpen = !isOpen"
     x-cloak
>
    <!-- Botón flotante -->
    <div x-show="!isOpen" x-transition>
        <button 
            @click="isOpen = true"
            class="fixed bottom-6 right-6 z-40 w-16 h-16 rounded-full bg-education-primary text-white shadow-lg hover:bg-education-secondary transition-all flex items-center justify-center transform hover:scale-110 focus:outline-none">
            <span class="material-icons-outlined text-3xl">chat_bubble</span>
        </button>
    </div>

    <!-- Panel del chatbot -->
    <div 
        x-show="isOpen"
        x-transition
        class="fixed bottom-6 right-6 z-50 w-full max-w-sm rounded-lg shadow-2xl"
        :class="{ '!fixed !inset-0 !w-full !max-w-none !h-full !rounded-none': isFullscreen }">
        
        <div class="bg-white rounded-lg flex flex-col h-full">
            <!-- Header -->
            <div class="bg-education-primary text-white px-4 py-3 rounded-t-lg flex justify-between items-center flex-shrink-0">
                <div class="flex items-center gap-2"><span class="material-icons-outlined">smart_toy</span><span class="font-medium">Asistente Educativo</span></div>
                <div class="flex space-x-1">
                    <button @click="isFullscreen = !isFullscreen" class="p-1 rounded-full hover:bg-white/20"><span class="material-icons-outlined" x-text="isFullscreen ? 'fullscreen_exit' : 'fullscreen'"></span></button>
                    <button @click="isOpen = false" class="p-1 rounded-full hover:bg-white/20"><span class="material-icons-outlined">close</span></button>
                </div>
            </div>

            <!-- Mensajes -->
            {{-- CORRECCIÓN: Volvemos a poner el bucle @foreach aquí directamente --}}
            <div class="flex-1 overflow-y-auto p-4 space-y-4" id="chat-messages">
                @foreach($messages as $msg)
                <div class="flex {{ $msg['type'] === 'user' ? 'justify-end' : 'justify-start' }}">
                    <div class="px-4 py-2 rounded-lg max-w-xs sm:max-w-md {{ $msg['type'] === 'user' ? 'bg-education-primary text-white' : 'bg-gray-100 text-gray-800' }}">
                        <div class="prose prose-sm max-w-none text-current">{!! \Illuminate\Support\Str::markdown(e($msg['text'])) !!}</div>
                        <div class="text-xs mt-1 text-right {{ $msg['type'] === 'user' ? 'text-blue-200' : 'text-gray-500' }}">
                            {{ $msg['time'] }}
                        </div>
                    </div>
                </div>
                @endforeach
                 @if($isTyping)
                <div class="flex justify-start">
                    <div class="bg-gray-100 text-gray-800 rounded-lg py-2 px-4">
                        <div class="flex items-center space-x-1"><div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce"></div><div class="w-2 h-2 bg-gray-400 rounded-full animate-pulse" style="animation-delay: 0.1s"></div><div class="w-2 h-2 bg-gray-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div></div>
                    </div>
                </div>
                @endif
            </div>

            <!-- Input -->
            <div class="border-t border-gray-200 p-3 bg-white rounded-b-lg">
                <form wire:submit.prevent="sendMessage" class="flex space-x-2 items-center">
                    <input type="text" wire:model="message" placeholder="Escribe tu pregunta..." class="flex-1 border-gray-300 rounded-lg px-4 py-2 w-full focus:outline-none focus:ring-2 focus:ring-education-primary focus:border-transparent" autocomplete="off">
                    <button type="submit" class="bg-education-primary text-white rounded-lg p-2 hover:bg-education-secondary disabled:opacity-50 flex-shrink-0" wire:loading.attr="disabled"><span class="material-icons-outlined">send</span></button>
                </form>
            </div>
        </div>
    </div>
</div>