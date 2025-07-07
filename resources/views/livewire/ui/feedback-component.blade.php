<div class="bg-white p-6 rounded-lg border border-gray-200 shadow-sm">
    <h3 class="text-xl font-bold text-gray-800 mb-4">Feedback y Comentarios</h3>

    {{-- Formulario para nuevo feedback --}}
    <form wire:submit="addFeedback" class="mb-6">
        <textarea 
            wire:model="content" 
            rows="3" 
            class="w-full border-gray-300 rounded-md shadow-sm focus:ring-education-primary focus:border-education-primary"
            placeholder="Escribe un comentario o pregunta..."></textarea>
        @error('content') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror

        <button type="submit" class="mt-2 w-full bg-education-primary hover:bg-education-secondary text-white font-semibold py-2 px-4 rounded-lg transition-colors">
            <span wire:loading.remove>Enviar Comentario</span>
            <span wire:loading>Enviando...</span>
        </button>
        @if (session('feedback_message'))
            <p class="text-green-600 text-sm mt-2">{{ session('feedback_message') }}</p>
        @endif
    </form>
    
    {{-- Lista de comentarios existentes --}}
    <div class="space-y-4">
        @forelse($feedbacks as $feedback)
            <div wire:key="feedback-{{ $feedback->id }}" class="flex items-start gap-3">
                <div class="flex-shrink-0 w-10 h-10 bg-gray-200 rounded-full flex items-center justify-center font-bold text-gray-600">
                    {{ strtoupper(substr($feedback->user->name, 0, 1)) }}
                </div>
                <div class="flex-1 bg-gray-50 p-3 rounded-lg">
                    <div class="flex justify-between items-center">
                        <p class="font-semibold text-sm text-gray-800">{{ $feedback->user->name }}</p>
                        <p class="text-xs text-gray-500">{{ $feedback->created_at->diffForHumans() }}</p>
                    </div>
                    <p class="text-sm text-gray-700 mt-1 whitespace-pre-wrap">{{ $feedback->content }}</p>
                </div>
            </div>
        @empty
            <p class="text-sm text-gray-500 text-center py-4">No hay comentarios todavía. ¡Sé el primero!</p>
        @endforelse
    </div>
</div>