<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;

class EvenueService
{
    protected $baseUrl;
    protected $token;

    public function __construct()
    {
        $this->baseUrl = config('services.evenue.base_url');
        $this->token   = config('services.evenue.token');
    }

    /** Get all venues – used for the full page */
    public function getAllVenues(int $page = 1, int $limit = 9): array
    {
        $cacheKey = "evenue_venues_page_{$page}_limit_{$limit}";
        return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($page, $limit) {
            $response = Http::withHeaders([
                'Authorization' => 'Bearer ' . $this->token,
            ])->get("{$this->baseUrl}/getAllVenues", [
                'page'  => $page,
                'limit' => $limit,
            ]);

            return $response->successful() ? $response->json() : [];
        });
    }

    /** Get only the first N venues – used for the homepage */
    // public function getFeaturedVenues(int $count = 4): array
    // {
    //     $cacheKey = "evenue_featured_{$count}";
    //     return Cache::remember($cacheKey, now()->addMinutes(30), function () use ($count) {
    //         $all = $this->getAllVenues(page: 1, limit: $count);
    //         return $all['venues'] ?? [];
    //     });
    // }

    // app/Services/EvenueService.php
public function getFeaturedVenues(int $count = 4): array
{
    $cacheKey = "evenue_featured_{$count}";
    return Cache::remember($cacheKey, now()->addMinutes(15), function () use ($count) {
        try {
            $response = Http::timeout(8)->get("{$this->baseUrl}/getAllVenues", [
                'page'  => 1,
                'limit' => $count,
            ]);

            if ($response->successful()) {
                return $response->json('venues') ?? [];
            }
        } catch (\Exception $e) {
            \Log::error('Evenue API timeout/down: ' . $e->getMessage());
        }

        return []; // Return empty on failure
    });
}
}