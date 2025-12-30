<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Services\ApiService;
use Livewire\Attributes\On; // ✅ Import this at the top

class BlogPostTable extends Component
{
    public array $posts = [];
    public string $search = '';
    public int $perPage = 10;
    public int $page = 1;
    public int $lastPage = 1;
    public array $allCategories = [];
    // public array $selectedCategories = [];
    public ?string $selectedCategory = null;

    // 🔥 EDIT MODAL STATE
    public bool $openEdit = false;
    public ?string $editUuid = null;
    public string $title = '';
    public string $content = '';

    protected ApiService $api;

    protected $listeners = [
        'postSaved' => 'fetchPosts',
        'postDeleted' => 'fetchPosts',
        'delete-confirmed' => 'deletePost',
    ];

    public function boot(ApiService $api)
    {
        $this->api = $api;
    }

    public function mount()
    {
        $this->fetchCategories();
        
        $this->fetchPosts();
    }

    public function fetchCategories()
    {
        $response = $this->api->get('categories');
        //dd($response);
        $this->allCategories = $response['data'] ?? [];
    }

    public function fetchPosts()
    {
        $response = $this->api->get('posts', [
            'page' => $this->page,
            'per_page' => $this->perPage,
            'search' => $this->search,
        ]);

        $this->posts = $response['data'] ?? [];
        $this->lastPage = $response['meta']['last_page'] ?? 1;
        $this->page = $response['meta']['current_page'] ?? 1;
    }

    public function updatedSearch()
    {
        $this->page = 1;
        $this->fetchPosts();
        //dd($this->search);
    }

    public function prevPage()
    {
        if ($this->page > 1) {
            $this->page--;
            $this->fetchPosts();
        }
    }

    public function nextPage()
    {
        if ($this->page < $this->lastPage) {
            $this->page++;
            $this->fetchPosts();
        }
    }

    public function goToPage($page)
    {
        $this->page = $page;
        $this->fetchPosts();
    }

    /* =========================
       EDIT (DIRECT TEST)
    ========================= */

  public function edit(string $uuid)
{
    $response = $this->api->get("posts/{$uuid}");
    $post = $response['data'] ?? null;

    if (! $post) {
        $this->dispatch('notify', type: 'error', message: 'Failed to load post');
        return;
    }

    $this->editUuid = $uuid;
    $this->title = $post['title'] ?? '';
    $this->content = $post['content'] ?? '';

    // 2. Take only the first category ID from the array (or null)
    $this->selectedCategory = !empty($post['categories']) 
        ? (string) $post['categories'][0]['id'] 
        : null;

    $this->openEdit = true;
}
public function saveEdit()
{
    $response = $this->api->put("posts/{$this->editUuid}", [
        'title' => $this->title,
        'content' => $this->content,
        'categories' => $this->selectedCategory ? [$this->selectedCategory] : [], 
    ]);

    if (isset($response['message'])) {
        $this->dispatch('notify', type: 'success', message: $response['message']);
        $this->reset(['openEdit', 'editUuid', 'title', 'content', 'selectedCategory']);
        $this->fetchPosts();
        return;
    }

    if (isset($response['errors'])) {
        foreach ($response['errors'] as $field => $messages) {
            $this->addError($field, $messages[0]);
        }
        return;
    }

    $this->dispatch('notify', type: 'error', message: 'Failed to update post.');
}

public function closeEdit()
{
    $this->reset(['openEdit', 'editUuid', 'title', 'content', 'selectedCategory']);
}

    /* =========================
       STATE ACTIONS
    ========================= */

    public function publish(string $uuid)
    {
        $this->api->post("posts/{$uuid}/publish");
        $this->fetchPosts();
    }

    public function unpublish(string $uuid)
    {
        $this->api->post("posts/{$uuid}/unpublish");
        $this->fetchPosts();
    }

    public function confirmDelete(string $uuid)
    {
        $this->dispatch('open-delete-modal', uuid: $uuid);
    }
/* =========================
    DELETE ACTION
========================= */


    #[On('delete-post')] // ✅ This explicitly listens for the 'delete-post' event
    public function deletePost(string $uuid)
    {
      //  dd('Received UUID: ' . $uuid); // This should now trigger
        
        $response = $this->api->delete("posts/{$uuid}");

        if (isset($response['message'])) {
            $this->dispatch('notify', type: 'success', message: 'Post deleted successfully');
            $this->fetchPosts();
        } else {
            $this->dispatch('notify', type: 'error', message: 'Failed to delete post.');
        }
    }
    public function render()
    {
        return view('livewire.dashboard.blog-post-table');
    }
}