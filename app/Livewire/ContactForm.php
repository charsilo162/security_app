<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Mail\ContactMessage;

class ContactForm extends Component
{
    
    public $name = '';
    public $email = '';
    public $subject = '';
    public $message = '';

    protected $rules = [
        'name' => 'required|string|min:2|max:255',
        'email' => 'required|email',
        'subject' => 'required|string',
        'message' => 'required|string|min:10',
    ];

    public function updated($propertyName)
    {
        // Real-time validation happens when user leaves an input field
        $this->validateOnly($propertyName);
    }

    public function sendMessage()
    {
        $this->validate();

        // Convert message to HTML using Markdown
        $markdownMessage = Str::markdown($this->message);

        try {
            Mail::to('support@esencialacademy.com')->send(new ContactMessage(
                $this->name,
                $this->email,
                $this->subject,
                $markdownMessage
            ));

            session()->flash('success', 'Your message has been sent successfully!');
            $this->reset(['name', 'email', 'subject', 'message']);
            
        } catch (\Exception $e) {
            session()->flash('error', 'Something went wrong. Please try again later.');
        }
    }

    public function render()
    {
        return view('livewire.contact-form');
    }
}