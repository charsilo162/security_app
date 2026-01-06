<?php
namespace App\Livewire\Blogs;

use Livewire\Component;
use App\Services\ApiService;

class BlogShow extends Component
{
    public $post;

    public function mount($uuid, ApiService $api)
    {
        // Fetch the single post from your API
        $response = $api->get("posts/{$uuid}");

        if (isset($response['data'])) {
            $this->post = $response['data'];
        } else {
            abort(404);
        }
    }

    public function render()
    {
        return view('livewire.blogs.blog-show')
            ->layout('layouts.blog', ['title' => $this->post['title'] ?? 'Blog Post']);
    }
}