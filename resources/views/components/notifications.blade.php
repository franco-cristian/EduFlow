@auth
<div class="fixed top-4 right-20 z-50">
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="relative p-2 text-gray-600 hover:text-gray-900">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            @if(auth()->user()->unreadNotifications->count() > 0)
            <span class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                {{ auth()->user()->unreadNotifications->count() }}
            </span>
            @endif
        </button>
        
        <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-xl overflow-hidden z-50">
            <div class="border-b border-gray-200 px-4 py-2">
                <h3 class="font-semibold text-gray-800">Notificaciones</h3>
            </div>
            <div class="max-h-96 overflow-y-auto">
                @forelse(auth()->user()->notifications->take(10) as $notification)
                <a href="{{ $notification->data['url'] ?? '#' }}" 
                   class="block px-4 py-3 border-b border-gray-100 hover:bg-gray-50 {{ $notification->read_at ? 'bg-white' : 'bg-blue-50' }}">
                    <div class="flex items-start">
                        <div class="mr-3 text-{{ $notification->data['color'] ?? 'blue' }}-500">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $notification->data['icon'] ?? 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z' }}" />
                            </svg>
                        </div>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-800">{{ $notification->data['title'] }}</p>
                            <p class="text-xs text-gray-600 mt-1">{{ $notification->data['message'] }}</p>
                            <p class="text-xs text-gray-500 mt-2">{{ $notification->created_at->diffForHumans() }}</p>
                        </div>
                        @if(!$notification->read_at)
                        <span class="ml-2 flex-shrink-0">
                            <span class="w-2 h-2 bg-blue-500 rounded-full"></span>
                        </span>
                        @endif
                    </div>
                </a>
                @empty
                <div class="px-4 py-8 text-center">
                    <p class="text-gray-500">No tienes notificaciones</p>
                </div>
                @endforelse
            </div>
            <div class="border-t border-gray-200 px-4 py-2">
                <a href="{{ route('notifications.index') }}" class="text-sm text-education-primary font-medium hover:text-education-secondary">
                    Ver todas
                </a>
            </div>
        </div>
    </div>
</div>
@endauth