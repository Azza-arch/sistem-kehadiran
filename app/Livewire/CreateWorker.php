<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class CreateWorker extends Component
{
    public $user;
    public $name;
    public $email;
    public $password;
    protected $rules = [
        'email' => 'email|required|unique:users',
        'name' => 'required',
        'password' => 'required|min:6',
    ];
    public function store()
    {
        $this->validate();
        $this->user = new User();
        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->password = $this->password;
        $this->user->save();
        $this->js("alert('Pengguna baru telah ditambah')");
        return redirect('home');
    }
    public function render()
    {
        return view('livewire.create-worker');
    }
}
