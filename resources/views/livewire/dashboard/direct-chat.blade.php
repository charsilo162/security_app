<div class="flex h-[calc(100vh-100px)] bg-white dark:bg-zinc-900 rounded-2xl border dark:border-zinc-800 overflow-hidden shadow-xl">
    
    {{-- LEFT SIDE: Inbox List --}}
    {{-- Logic: If a chat is active, hide the sidebar on mobile (hidden), but show it on medium screens (md:flex) --}}
    <div class="{{ $activeConversation ? 'hidden md:flex' : 'flex' }} w-full md:w-1/3 border-r dark:border-zinc-800 flex-col">
        <div class="p-4 border-b dark:border-zinc-800 font-bold text-lg">Messages</div>
        <div class="flex-1 overflow-y-auto">
            @foreach($conversations as $chat)
                <button wire:click="openChat('{{ $chat['uuid'] }}')" 
                    class="w-full flex items-center gap-3 p-4 hover:bg-zinc-50 dark:hover:bg-zinc-800 transition {{ $activeConversation == $chat['uuid'] ? 'bg-indigo-50 dark:bg-indigo-900/20' : '' }}">
                    <img src="{{ $chat['other_user_photo'] }}" class="w-10 h-10 rounded-full border">
                    <div class="text-left flex-1 overflow-hidden">
                        <div class="flex justify-between">
                            <span class="font-bold text-sm truncate">{{ $chat['other_user_name'] }}</span>
                            @if($chat['unread_count'] > 0)
                                <span class="bg-red-500 text-white text-[10px] px-1.5 rounded-full">{{ $chat['unread_count'] }}</span>
                            @endif
                        </div>
                        <p class="text-xs text-zinc-500 truncate">{{ $chat['last_message'] }}</p>
                    </div>
                </button>
            @endforeach
        </div>
    </div>

    {{-- RIGHT SIDE: Chat Window --}}
    {{-- Logic: If NO chat is active, hide this on mobile. If active, take full width. --}}
    <div class="{{ !$activeConversation ? 'hidden md:flex' : 'flex' }} flex-1 flex flex-col bg-zinc-50/50 dark:bg-zinc-950/30">
        @if($activeConversation)
            {{-- MOBILE BACK BUTTON --}}
            <div class="p-3 border-b dark:border-zinc-800 bg-white dark:bg-zinc-900 md:hidden flex items-center">
                <button wire:click="$set('activeConversation', null)" class="text-indigo-600 flex items-center gap-2">
                    <i class="fas fa-chevron-left"></i> Back
                </button>
            </div>

            {{-- Messages Area --}}
            <div 
                x-data 
                x-init="$el.scrollTop = $el.scrollHeight" 
                class="flex-1 p-6 overflow-y-auto space-y-4 flex flex-col"
            >
                @foreach($messages as $msg)
                    <div class="max-w-[85%] md:max-w-[70%] p-3 rounded-2xl text-sm {{ $msg['is_me'] ? 'bg-indigo-600 text-white self-end rounded-tr-none' : 'bg-white dark:bg-zinc-800 self-start rounded-tl-none border dark:border-zinc-700' }}">
                        {{ $msg['message'] }}
                        <div class="text-[9px] mt-1 opacity-70 text-right">{{ $msg['created_at'] }}</div>
                    </div>
                @endforeach
            </div>

            {{-- Input Area --}}
            <form wire:submit.prevent="sendMessage" class="p-4 bg-white dark:bg-zinc-900 border-t dark:border-zinc-800 flex gap-2">
                <input wire:model="newMessage" type="text" placeholder="Type a message..." class="flex-1 bg-zinc-100 dark:bg-zinc-800 border-none rounded-xl px-4 py-2 focus:ring-2 focus:ring-indigo-500 text-sm">
                
                
                <button type="submit" class="bg-indigo-600 text-white p-2 px-4 rounded-xl">
                    <i class="fas fa-paper-plane"></i>
                </button>
            </form>
        @else
            <div class="flex-1 flex flex-col items-center justify-center text-zinc-400">
                <i class="fas fa-comments text-5xl mb-4 opacity-20"></i>
                <p>Select a message to start chatting</p>
            </div>
        @endif
    </div>
</div>