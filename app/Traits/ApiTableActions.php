<?php
namespace App\Traits;

use App\Services\ApiService;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

trait ApiTableActions {
    use WithPagination, WithFileUploads;

    public string $search = '';
    public int $perPage = 10;
    public bool $showModal = false;
    public ?string $editId = null;

    protected ApiService $api;
    public function boot(ApiService $api) { $this->api = $api; }
}