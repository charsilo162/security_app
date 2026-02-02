<div class="bg-white dark:bg-zinc-900 rounded-xl border dark:border-zinc-700">

    <!-- HEADER -->
    <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <h2 class="font-semibold text-lg">
            Blog Posts
        </h2>

        <input
            wire:model.live.debounce.500ms="search"
            placeholder="Search posts..."
            class="border rounded-lg px-4 py-2 text-sm
                   dark:bg-zinc-800 dark:border-zinc-600"
        />

        <div class="flex items-center gap-4">
            <button wire:click="$set('openAiModal', true)" class="flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-2 rounded-lg transition">
                <i class="fas fa-robot"></i>
                <span>AI Generate</span>
            </button>

            <button wire:click="create" class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700 transition">
                <i class="fas fa-plus mr-2"></i> Add New Post
            </button>
        </div>
    </div>

    <!-- TABLE -->
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-zinc-100 dark:bg-zinc-800">
                <tr>
                    <th class="p-3 text-left">Title</th>
                    <th class="p-3 text-left">Categories</th>
                    <th class="p-3 text-left">Status</th>
                    <th class="p-3 text-left">Created</th>
                    <th class="p-3 text-right">Actions</th>
                </tr>
            </thead>

            <tbody>
                @forelse($posts as $post)
                    <tr wire:key="post-{{ $post['uuid'] }}"
                        class="border-t dark:border-zinc-700 hover:bg-zinc-50 dark:hover:bg-zinc-800">
                        <td class="p-3 font-medium">
                            {{ $post['title'] }}
                        </td>

                        <td class="p-3">
                            {{ collect($post['categories'])->pluck('name')->join(', ') }}
                        </td>

                        <td class="p-3">
                            <span class="px-2 py-1 rounded text-xs
                                @if($post['status'] === 'published') bg-green-100 text-green-700
                                @elseif($post['status'] === 'draft') bg-yellow-100 text-yellow-700
                                @else bg-gray-200 text-gray-700 @endif">
                                {{ ucfirst($post['status']) }}
                            </span>
                        </td>

                        <td class="p-3 text-zinc-500">
                            {{ \Carbon\Carbon::parse($post['created_at'])->format('M d, Y') }}
                        </td>

                        <td class="p-3 text-right space-x-2">
                            @if($post['status'] !== 'published')
                                <button wire:click="publish('{{ $post['uuid'] }}')"
                                        class="text-green-600 hover:underline">
                                    Publish
                                </button>
                            @else
                                <button wire:click="unpublish('{{ $post['uuid'] }}')"
                                        class="text-yellow-600 hover:underline">
                                    Unpublish
                                </button>
                            @endif

                            <button
                                wire:click="edit('{{ $post['uuid'] }}')"
                                class="text-blue-600 hover:underline">
                                Edit
                            </button>

                            <button wire:click="confirmDelete('{{ $post['uuid'] }}')"
                                    class="text-red-600 hover:underline">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="p-6 text-center text-zinc-500">
                            No blog posts found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- PAGINATION -->
    <div class="p-6 flex justify-center gap-2">
        @if($page > 1)
            <button wire:click="prevPage" class="px-4 py-2 border rounded-lg">
                Previous
            </button>
        @endif

        @for($i = 1; $i <= $lastPage; $i++)
            <button wire:click="goToPage({{ $i }})"
                    class="px-4 py-2 border rounded-lg @if($i == $page) bg-blue-600 text-white @endif">
                {{ $i }}
            </button>
        @endfor

        @if($page < $lastPage)
            <button wire:click="nextPage" class="px-4 py-2 border rounded-lg">
                Next
            </button>
        @endif
    </div>

    <!-- ADD/EDIT MODAL (Centered Style with Image Field) -->
    @if($openModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto shadow-2xl">
                <div class="p-6 border-b dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900">
                    <h3 class="text-xl font-bold">{{ $postUuid ? 'Edit Blog Post' : 'Create New Blog Post' }}</h3>
                    <button wire:click="closeModal" class="text-zinc-400 hover:text-black text-2xl">×</button>
                </div>

                <form wire:submit.prevent="save" class="p-8 space-y-8">
                    <div>
                        <h4 class="text-indigo-600 font-bold text-sm uppercase mb-4">Post Details</h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold mb-1">Title</label>
                                <input wire:model="title" type="text" 
                                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('title') border-red-500 @else border-zinc-300 @enderror"
                                    placeholder="Enter post title...">
                                @error('title') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold mb-1">Category</label>
                                <select wire:model="selectedCategory" class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300">
                                    <option value="">Select Category (Optional)</option>
                                    @foreach($allCategories as $category)
                                        <option value="{{ $category['id'] }}">{{ $category['name'] ?? $category['title'] }}</option>
                                    @endforeach
                                </select>
                                @error('selectedCategory') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold mb-1">Featured Image (Optional)</label>
                                <div class="flex items-center gap-4">
                                    <div class="relative group">
                                        <div class="w-32 h-32 rounded-lg border-2 border-dashed border-zinc-300 dark:border-zinc-700 flex items-center justify-center overflow-hidden bg-zinc-50 dark:bg-zinc-800">
                                            @if ($image)
                                                <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                                            @elseif($currentImageUrl)
                                                <img src="{{ $currentImageUrl }}" class="w-full h-full object-cover">
                                            @else
                                                <i class="fas fa-camera text-zinc-400 text-2xl"></i>
                                            @endif
                                        </div>
                                        <label class="mt-2 block cursor-pointer text-xs text-indigo-600 font-semibold hover:underline">
                                            Upload Image
                                            <input type="file" wire:model="image" class="hidden" accept="image/*">
                                        </label>
                                    </div>
                                </div>
                                @error('image') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>

                            <div class="md:col-span-2">
                                <label class="block text-xs font-semibold mb-1">Content</label>
                                <textarea wire:model="content" rows="10" 
                                    class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 border-zinc-300 dark:border-zinc-700 focus:ring-2 focus:ring-indigo-500 outline-none"
                                    placeholder="Write your post content here..."></textarea>
                                @error('content') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end gap-3 pt-6 border-t dark:border-zinc-800">
                        <button type="button" wire:click="closeModal" class="px-6 py-2 border rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700">Cancel</button>
                        <button type="submit" wire:loading.attr="disabled" class="px-8 py-2 bg-indigo-600 text-white rounded-lg shadow-lg hover:bg-indigo-700 transition disabled:opacity-50">
                            <span wire:loading.remove>{{ $postUuid ? 'Save Changes' : 'Create Post' }}</span>
                            <span wire:loading><i class="fas fa-spinner fa-spin mr-2"></i> Processing...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <!-- AI GENERATE MODAL (Centered Style for Consistency) -->
    @if($openAiModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4">
            <div class="bg-white dark:bg-zinc-900 rounded-2xl w-full max-w-md max-h-[90vh] overflow-y-auto shadow-2xl">
                <div class="p-6 border-b dark:border-zinc-800 flex justify-between items-center sticky top-0 bg-white dark:bg-zinc-900">
                    <h3 class="text-xl font-bold">Generate AI Post</h3>
                    <button wire:click="closeAiModal" class="text-zinc-400 hover:text-black text-2xl">×</button>
                </div>

                <form wire:submit.prevent="generateAiPost" class="p-8 space-y-6">
                    <div>
                        <label class="block text-xs font-semibold mb-1">Topic</label>
                        <input wire:model="aiTopic" type="text" 
                            class="w-full border rounded-lg p-2.5 dark:bg-zinc-800 @error('aiTopic') border-red-500 @else border-zinc-300 @enderror"
                            placeholder="Enter a topic for AI generation...">
                        @error('aiTopic') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex justify-end gap-3">
                        <button type="button" wire:click="closeAiModal" class="px-6 py-2 border rounded-lg hover:bg-zinc-100 dark:hover:bg-zinc-700">Cancel</button>
                        <button type="submit" wire:loading.attr="disabled" class="px-8 py-2 bg-purple-600 text-white rounded-lg shadow-lg hover:bg-purple-700 transition disabled:opacity-50">
                            <span wire:loading.remove>Generate</span>
                            <span wire:loading><i class="fas fa-spinner fa-spin mr-2"></i> Generating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        window.addEventListener('notify', e => {
            alert(e.detail.message); // later replace with toast
        });
    </script>

</div>