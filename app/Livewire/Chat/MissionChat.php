<?php

namespace App\Livewire\Chat;

use Livewire\Component;
use App\Services\ApiService;

class MissionChat extends Component
{
    public $missionId;
    public $message_text = '';
    public $missionData = [];
    public $chat_history = [];

    protected ApiService $api;

    public function boot(ApiService $api) 
    { 
        $this->api = $api; 
    }

    public function mount($missionId)
    {
        $this->missionId = $missionId;
        $this->loadInitialData();
        
    }

    public function loadInitialData()
    {
        // Fetch Mission Header Info
        $missionResponse = $this->api->get("admin/missions/{$this->missionId}");
        $this->missionData = $missionResponse['data'] ?? [];
       

        // Fetch Messages
        $this->refreshMessages();
    }

    public function refreshMessages()
    {
        $response = $this->api->get("admin/messages/{$this->missionId}");
        $this->chat_history = $response['data'] ?? [];
    }

    public function sendMessage()
    {
        if (trim($this->message_text) === '') return;
        
        $payload = [
            'mission_id' => $this->missionId,
            'message'    => $this->message_text,
        ];

        $response = $this->api->post("admin/messages", $payload);
       // dd($response);
        if (!isset($response['errors'])) {
            $this->message_text = '';
            $this->refreshMessages(); // Manual update since we aren't using WebSockets
        }
    }

    public function render()
    {
        return view('livewire.chat.mission-chat');
    }
}
