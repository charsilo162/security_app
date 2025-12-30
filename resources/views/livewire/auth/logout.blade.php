<button 
    onclick="
        event.preventDefault();
        fetch('http://127.0.0.1:8001/api/logout', {
            method: 'POST',
            headers: {
                'Authorization': 'Bearer {{ session('api_token') }}',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        }).then(() => {
            // Clear session and redirect
            window.location = '/';
        }).catch(() => {
            // Even if API fails, log out frontend
            window.location = '/';
        });
    "
    class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-200 dark:hover:bg-neutral-700">
    Log Out
</button>