<?php
namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Services\ApiService;
use Livewire\Attributes\On;

class BlogPostForm extends Component
{
    public bool $open = false;
    public ?string $uuid = null;

    public string $title = '';
    public string $content = '';

    protected $listeners = [
        'edit-post' => 'loadPost',
    ];

    protected ApiService $api;

    public function boot(ApiService $api)
    {
        $this->api = $api;
    }

      #[On('edit-post')] 
    public function loadPost(string $uuid)
    {
        dd('here');
        try {
            $response = $this->api->get("posts/{$uuid}");

            $this->uuid = $uuid;
            $this->title = $response['title'] ?? '';
            $this->content = $response['content'] ?? '';

            $this->open = true; 
        } catch (\Exception $e) {
            // Log error or show notification if API fails
        }
    }

    public function close()
    {
        $this->reset(['open', 'uuid', 'title', 'content']);
    }

    public function save()
    {
        
        $this->api->put("posts/{$this->uuid}", [
            'title' => $this->title,
            'content' => $this->content,
        ]);

        $this->dispatch('postSaved');
        $this->close();
    }

    public function render()
    {
        return view('livewire.dashboard.blog-post-form');
    }
}



