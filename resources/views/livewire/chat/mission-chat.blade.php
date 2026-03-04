<div class="flex flex-col h-[500px] bg-white dark:bg-zinc-900 rounded-xl overflow-hidden shadow-none">
    
    <div class="flex-1 overflow-y-auto p-4 space-y-4 bg-zinc-50 dark:bg-zinc-950">
        @forelse($chat_history as $msg)
            <div class="flex {{ $msg['is_me'] ? 'justify-end' : 'justify-start' }}">
                <div class="max-w-[85%]">
                    <div class="flex items-center space-x-2 mb-1 {{ $msg['is_me'] ? 'flex-row-reverse space-x-reverse' : '' }}">
                        <span class="text-[9px] font-black text-zinc-500 uppercase tracking-tight">{{ $msg['sender_name'] }}</span>
                        <span class="text-[9px] text-zinc-400">{{ $msg['created_at'] }}</span>
                    </div>

                    <div class="p-3 rounded-2xl shadow-sm {{ $msg['is_me'] ? 'bg-red-600 text-white rounded-tr-none' : 'bg-zinc-200 text-zinc-800 dark:bg-zinc-800 dark:text-zinc-100 rounded-tl-none' }}">
                        <p class="text-xs font-bold leading-relaxed">{{ $msg['message'] }}</p>
                    </div>
                </div>
            </div>
        @empty
            <div class="flex flex-col items-center justify-center h-full opacity-40">
                <p class="text-zinc-500 text-[10px] font-black uppercase tracking-widest">No Audit Logs Found</p>
            </div>
        @endforelse
    </div>

    <div class="p-4 bg-white dark:bg-zinc-900 border-t dark:border-zinc-800">
        <div class="flex items-center gap-2">
            <input type="text" 
                   wire:model="message_text" 
                   wire:keydown.enter="sendMessage"
                   placeholder="Type a message..." 
                   class="flex-1 bg-zinc-100 dark:bg-zinc-800 border-none rounded-xl px-4 py-2 text-xs font-bold text-zinc-900 dark:text-white placeholder-zinc-400 focus:ring-2 focus:ring-red-600 outline-none">
            
            <button wire:click="sendMessage" 
                    class="bg-red-600 hover:bg-red-700 text-white p-2.5 rounded-xl transition-all shadow-lg shadow-red-100 dark:shadow-none">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8"></path></svg>
            </button>
        </div>
    </div>
</div>