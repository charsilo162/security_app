<?php

namespace App\Livewire\Dashboard;

use Livewire\Component;
use App\Services\ApiService;
use Illuminate\Support\Facades\Log;
use Livewire\Attributes\On; // ✅ Import this at the top
use Livewire\WithFileUploads; // ✅ Add this for file uploads

class BlogPostTable extends Component
{
    use WithFileUploads;

    public array $posts = [];
    public string $search = '';
    public int $perPage = 10;
    public int $page = 1;
    public int $lastPage = 1;
    public array $allCategories = [];
    public bool $openAiModal = false;
    public string $aiTopic = '';
    public bool $isGenerating = false;
    // public array $selectedCategories = [];
    public ?string $selectedCategory = null;

    // 🔥 COMBINED MODAL STATE FOR ADD/EDIT
    public bool $openModal = false;
    public ?string $postUuid = null;
    public string $title = '';
    public string $content = '';
    public $image; // For new image upload (TemporaryUploadedFile or null)
    public ?string $currentImageUrl = null; // For displaying existing image during edit

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
       ADD/EDIT (COMBINED)
    ========================= */

    public function create()
    {
        $this->reset(['postUuid', 'title', 'content', 'selectedCategory', 'image', 'currentImageUrl']);
        $this->openModal = true;
    }

    public function edit(string $uuid)
    {
        $response = $this->api->get("posts/{$uuid}");
        $post = $response['data'] ?? null;

        if (! $post) {
            $this->dispatch('notify', type: 'error', message: 'Failed to load post');
            return;
        }

        $this->postUuid = $uuid;
        $this->title = $post['title'] ?? '';
        $this->content = $post['content'] ?? '';

        // 2. Take only the first category ID from the array (or null)
        $this->selectedCategory = !empty($post['categories']) 
            ? (string) $post['categories'][0]['id'] 
            : null;

        // Set current image URL (assuming 'image' field in API response is a URL or path)
        $this->currentImageUrl = $post['image'] ?? null;

        // Reset image upload field
        $this->image = null;

        $this->openModal = true;
    }

   public function save()
        {
            // 1. Validation
            $this->validate([
                'title'   => 'required|min:3',
                'content' => 'required|min:10',
                'image'   => 'nullable|image|max:2048',
            ]);

            // 2. Build multipart payload
            $data = [
                ['name' => 'title', 'contents' => $this->title],
                ['name' => 'content', 'contents' => $this->content],
            ];

            if ($this->selectedCategory) {
                $data[] = [
                    'name'     => 'categories[]',
                    'contents' => $this->selectedCategory,
                ];
            }

            // 3. Attach image if present
            if ($this->image) {
                $data[] = [
                    'name'     => 'image',
                    'contents' => fopen($this->image->getRealPath(), 'r'),
                    'filename' => $this->image->getClientOriginalName(),
                ];
            }

            // Log::info('Livewire → API multipart payload prepared', [
            //     'has_image' => (bool) $this->image,
            //     'fields'    => collect($data)->pluck('name'),
            // ]);

            // 4. Send to API
            try {
                if ($this->postUuid) {
                    $response = $this->api->postWithFile("posts/{$this->postUuid}", $data, 'PUT');
                } else {
                    $response = $this->api->postWithFile('posts', $data);
                }
            } catch (\Exception $e) {
                $this->dispatch('notify', type: 'error', message: $e->getMessage());
                return;
            }

            // 5. Handle response
            if (isset($response['message'])) {
                $this->dispatch('notify', type: 'success', message: $response['message']);
                $this->reset([
                    'openModal',
                    'postUuid',
                    'title',
                    'content',
                    'selectedCategory',
                    'image',
                    'currentImageUrl'
                ]);
                $this->fetchPosts();
                return;
            }

            if (isset($response['errors'])) {
                foreach ($response['errors'] as $field => $messages) {
                    $this->addError($field, $messages[0]);
                }
                return;
            }

            $this->dispatch('notify', type: 'error', message: 'Failed to save post.');
        }


    public function closeModal()
    {
        $this->reset(['openModal', 'postUuid', 'title', 'content', 'selectedCategory', 'image', 'currentImageUrl']);
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


    public function generateAiPost()
        {
            $this->validate([
                'aiTopic' => 'required|min:5'
            ]);

            $this->isGenerating = true;

            try {
                // Calling your specific endpoint: http://localhost:8001/ai/blog/generate
                // Assuming your ApiService can handle full URLs or is configured for this port
                $response = $this->api->post('ai/blog/generate', [
                    'topic' => $this->aiTopic
                ]);
                //dd($response);
                if (isset($response['uuid']) || isset($response['data'])) {
                    $this->dispatch('notify', type: 'success', message: 'AI Content Generated Successfully!');
                    $this->reset(['openAiModal', 'aiTopic', 'isGenerating']);
                    $this->fetchPosts(); // Refresh the table
                } else {
                    $this->dispatch('notify', type: 'error', message: 'Generation failed. Check API.');
                }
            } catch (\Exception $e) {
                $this->dispatch('notify', type: 'error', message: 'Error: ' . $e->getMessage());
            } finally {
                $this->isGenerating = false;
            }
        }

    public function closeAiModal()
        {
            $this->reset(['openAiModal', 'aiTopic', 'isGenerating']);
        }
    public function render()
    {
        return view('livewire.dashboard.blog-post-table');
    }
}