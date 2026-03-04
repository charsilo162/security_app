<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Services\ApiService;

class DirectChat extends Component
{

        public $conversations = [];
        public $activeConversation = null; // The UUID of the selected chat
        public $messages = [];
        public $newMessage = '';


            public function boot(ApiService $api)
    {
        $this->api = $api;
    }
        public function mount($targetUuid = null)
        {
            $this->loadConversations();
            
            // If we came from the Employee Detail page, start/open that chat automatically
            if ($targetUuid) {
                $this->openChat($targetUuid);
            }
        }

        public function loadConversations()
        {
            $response = $this->api->get('chat/conversations');
           // dd($response);
            $this->conversations = $response['data'] ?? [];
        }

        public function openChat($conversationUuid)
        {
            $this->activeConversation = $conversationUuid;
            $response = $this->api->get("chat/{$conversationUuid}/messages");
            $this->messages = $response['data'] ?? [];
            //dd($response);
            // Mark as read in the local list
            $this->loadConversations(); 
        }

        public function sendMessage()
        {
            if (empty($this->newMessage)) return;

            $response = $this->api->post("chat/{$this->activeConversation}/send", [
                'body' => $this->newMessage
            ]);
            // dd($response);
            if (isset($response['data'])) {
                $this->messages[] = $response['data'];
                $this->newMessage = '';
                $this->loadConversations(); // Update the sidebar "Last Message"
            }
        }



        // // Add this property to your class
        // protected function getListeners()
        // {
        //     return [
        //         // Listen to the private channel
        //         "echo-private:chat.{$this->activeConversation},MessageSent" => 'prependMessage',
        //     ];
        // }

        // public function prependMessage($data)
        // {
        //     // Add the new message to the top or bottom of the array instantly
        //     $this->messages[] = $data['message'];
            
        //     // Dispatch browser event to scroll to bottom
        //     $this->dispatch('message-sent');
        // }
            public function render()
            {
                return view('livewire.dashboard.direct-chat');
            }
}
