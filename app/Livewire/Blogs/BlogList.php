<?php
namespace App\Livewire\Blogs;
use Livewire\Component;
use App\Services\ApiService;
use Livewire\WithPagination;

class BlogList extends Component
{
    use WithPagination;

    public $search = '';
    public $activeCategory = 'all';

    protected $queryString = ['search', 'activeCategory'];

     public function render(ApiService $api)
        {
            $response = $api->get('posts', [
                'search' => $this->search,
                'status' => 'published',
                'page' => $this->getPage(),
            ]);

            // Convert to Collection for powerful grouping methods
            $allPosts = collect($response['data'] ?? []);

            // 1. Featured: Still take the 3 latest for the Hero section
            $featured = $allPosts->take(3);

            // 2. Grouped: Group the rest by Month and Year
            $groupedPosts = $allPosts->slice(3)->groupBy(function($post) {
                return \Carbon\Carbon::parse($post['published_at'])->format('F Y');
            });

            return view('livewire.blogs.blog-list', [
                'featuredPosts' => $featured,
                'groupedPosts'  => $groupedPosts, // This is now a multidimensional array
            ]);
        }
}