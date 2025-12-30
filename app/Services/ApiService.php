<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;

class ApiService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('services.api.base_url', 'http://127.0.0.1:8001/api'), '/');
        // $this->baseUrl = rtrim(config('services.api.base_url', 'https://api.eaccademy.eroot.ng/api'), '/');
    }

   
    protected function request($method, $endpoint, $data = [])
    {
        $url = "$this->baseUrl/$endpoint";

        $request = Http::withHeaders([
            'Accept' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest',
        ]);

        if (Session::has('api_token')) {
            $request = $request->withToken(Session::get('api_token'));
        }

        // GET → query params
        if ($method === 'get') {
            $response = $request->get($url, $data);
        } else {
            // POST/PUT → JSON body
            $response = $request
                ->bodyFormat('json')
                ->$method($url, $data);
        }

        // If server returned invalid JSON
        if (!$response->ok() && !$response->json()) {
            return [
                'error' => 'Network or Server Error',
                'status' => $response->status(),
            ];
        }

        // Always return JSON, even for errors (400/422/etc)
        return $response->json();
    }


        // Special method for file uploads (multipart)
    protected function multipartRequest($method, $endpoint, $formData = [])
    {
        $url = "$this->baseUrl/$endpoint";

        $request = Http::withHeaders([
            'Accept' => 'application/json',
        ])->withToken(Session::get('api_token'));

        // Check if any file stream is present
        $hasFile = collect($formData)->contains(fn($f) => isset($f['contents']) && is_resource($f['contents']));

        if ($hasFile) {
            // --- MULTIPART LOGIC ---
            foreach ($formData as $field) {
                
                // 1. Critical check: Ensure the field has a 'contents' key.
                if (!isset($field['contents'])) {
                    continue; 
                }

                // 2. Check if the content is a file stream (resource)
                if (is_resource($field['contents'])) {
                    // This is a FILE: Always attach files
                    $request = $request->attach(
                        $field['name'],
                        $field['contents'],
                        $field['filename'] ?? 'file.dat'
                    );
                } 
                // 3. Check for plain STRING DATA (only attach if content is NOT null/empty string)
                elseif (!empty($field['contents'])) {
                    // This is plain STRING DATA (title, ID, duration, etc.)
                    $request = $request->attach($field['name'], $field['contents']);
                }
                // If it's not a resource AND it's empty, we simply skip it.
            }

            // Send the request as multipart/form-data
            $response = $request->$method($url);

            // Handle 422 validation errors gracefully
            if ($response->status() === 422) {
                return [
                    'error'   => true,
                    'status'  => 422,
                    'message' => $response->json('message'),
                    'errors'  => $response->json('errors'),
                ];
            }

            // Return normal JSON response
            return $response->json();

        } else {
            // --- JSON/Form-URL-Encoded LOGIC (No file) ---
            $fields = collect($formData)->pluck('contents', 'name')->all();
            return $request->asForm()->$method($url, $fields)->throw()->json();
        }
    }

    // Public methods
    public function get($endpoint, $query = [])
    {
        return $this->request('get', $endpoint, $query);
    }

    public function post($endpoint, $data = [])
    {
        return $this->request('post', $endpoint, $data);
        
    }



    public function put($endpoint, $data = [])
    {
        return $this->request('put', $endpoint, $data);
    }
    

 public function delete($endpoint, $data = [])
            {
                return $this->request('delete', $endpoint, $data);
            }
    // SPECIAL: Use this only when uploading files
    // public function putWithFile($endpoint, $formData = [])
    // {
    //     return $this->multipartRequest('put', $endpoint, $formData);
    // }


    public function putWithFile($endpoint, $formData = [])
    {
        // 1. Add the method spoofing field
        $formData[] = [
            'name'     => '_method',
            'contents' => 'PUT'
        ];

        // 2. IMPORTANT: Send as 'post', not 'put'
        return $this->multipartRequest('post', $endpoint, $formData);
    }
    public function postWithFile($endpoint, $formData = [])
    {
        return $this->multipartRequest('post', $endpoint, $formData);
    }


    public function initializePayment($courseId)
    {
        $response = $this->post('payment/initialize', [
            'course_id' => $courseId
        ]);

        // If API returned an error like {"error": "..."}
        if (isset($response['error']) && $response['error']) {
            return [
                'success' => false,
                'error' => $response['error'],
            ];
        }

        return [
            'success' => true,
            'data' => $response,
        ];
    }

    public function getCategoriesCount($search = null)
    {
        $params = $search ? ['search' => $search] : [];
        return $this->get('categories/count', $params);
    }
}