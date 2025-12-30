<?php

namespace App\Livewire\Auth;

use App\Services\ApiService;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithFileUploads;

class Register extends Component
{
     use WithFileUploads;

    public $photo;
    public $name = '';
    public $email = '';
    public $type = 'user';
    public $password = '';
    public $password_confirmation = '';

  protected $rules = [
    'name' => 'required|string|max:255',
    'email' => 'required|email|max:255',
    'type' => 'required|in:user,center,tutor',
    'password' => 'required|min:6|confirmed',
    // Add photo rules here for temporary upload validation
    'photo' => 'nullable|image|max:2048', 
];
// Add this method to App\Livewire\Auth\Register.php

public function updatedPhoto()
{
    // The framework automatically validates here using $rules
    $this->validateOnly('photo');
    // If validation passes, you can see a temporary file path is created
    // This is useful for confirmation
    \Log::info('Photo selected and validated successfully: ' . $this->photo->getRealPath());
}
public function register()
{
    $this->validate(); // Uses the $rules property

    // 1. Prepare the payload array for your multipartRequest function
    $payload = [
        ['name' => 'name', 'contents' => $this->name],
        ['name' => 'email', 'contents' => $this->email],
        ['name' => 'type', 'contents' => $this->type],
        ['name' => 'password', 'contents' => $this->password],
        ['name' => 'password_confirmation', 'contents' => $this->password_confirmation],
    ];

    // 2. Attach the actual file stream if it exists
    if ($this->photo) {
        // Get the file contents as a stream resource
        $fileStream = fopen($this->photo->getRealPath(), 'r');
        
        // Add the file to the payload in the expected format
        $payload[] = [
            'name' => 'photo', // This MUST match the API's validation rule name
            'contents' => $fileStream, // The file stream resource
            'filename' => $this->photo->getFilename(), // Recommended for correct file naming
        ];
    }

    // 3. Use the postWithFile method, which utilizes multipartRequest
    // The ApiService will close the stream automatically.
    $response = (new ApiService())->postWithFile('register', $payload);
    
    if (isset($response['errors'])) {
        foreach ($response['errors'] as $field => $messages) {
            $this->addError($field, is_array($messages) ? $messages[0] : $messages);
        }
        return;
    }

    // Save auth data
    Session::put('api_token', $response['token']);
    Session::put('user', $response['user']);

    return redirect()->route('category.index');
}
    public function render()
    {
        return view('livewire.auth.register')->layout('layouts.auth', ['title' => 'Sign Up']);
    }
}