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

    @if($openEdit)
        <div class="fixed inset-0 z-50 flex">

            <!-- Backdrop -->
            <div class="fixed inset-0 bg-black/40" wire:click="closeEdit"></div>

            <!-- Slide-over -->
            <div class="relative ml-auto w-full max-w-xl h-full bg-white dark:bg-zinc-900 shadow-xl">

                <div class="p-6 border-b dark:border-zinc-700 flex justify-between">
                    <h2 class="text-lg font-semibold">Edit Blog Post</h2>

                    <button wire:click="closeEdit">✕</button>
                </div>

                <div class="p-6 space-y-4 overflow-y-auto h-[calc(100%-140px)]">

                    <div>
                        <label class="block text-sm mb-1">Title</label>
                        <input
                            wire:model.defer="title"
                            class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800">
                    </div>
                <div>
                    <label class="block text-sm mb-1">Category</label>
                    <select wire:model.defer="selectedCategory"
                            class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800">
                        <option value="">Select a category</option>
                        @foreach($allCategories as $category)
                            <option value="{{ $category['id'] }}">
                                {{ $category['name'] }}
                            </option>
                        @endforeach
                    </select>
                    @error('category') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </div>

                    <div>
                        <label class="block text-sm mb-1">Content</label>
                        <textarea
                            wire:model.defer="content"
                            rows="8"
                            class="w-full border rounded-lg px-3 py-2 dark:bg-zinc-800"></textarea>
                    </div>

                </div>

                <div class="p-6 border-t dark:border-zinc-700 flex justify-end gap-3">
                    <button wire:click="closeEdit" class="px-4 py-2 border rounded-lg">
                        Cancel
                    </button>

                    <button wire:click="saveEdit"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg">
                        Save
                    </button>
                </div>

            </div>
        </div>
    @endif

    <script>
        window.addEventListener('notify', e => {
            alert(e.detail.message); // later replace with toast
        });
    </script>

</div>