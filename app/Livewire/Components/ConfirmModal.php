<?php
namespace App\Livewire\Components;

use Livewire\Component;

class ConfirmModal extends Component
{
    public bool $open = false; 
    public ?string $uuid = null;
    public string $action = '';

    protected $listeners = [
        'open-delete-modal' => 'openDeleteModal',
    ];

    public function openDeleteModal(string $uuid)
    {
        $this->uuid = $uuid;
        $this->action = 'delete-post'; // This string is what gets dispatched
        $this->open = true;
    }

public function confirm()
    {
        if ($this->uuid) {
            // Dispatch the action (delete-post) with the uuid
            $this->dispatch($this->action, uuid: $this->uuid); 
            
            // Debugging: uncomment the line below to see if the modal even gets here
            //dd('Modal confirmed for: ' . $this->uuid); 
        }
        
        $this->close();
    }

    public function close()
    {
        $this->reset();
    }

    public function render()
    {
        return view('livewire.components.confirm-modal');
    }
}