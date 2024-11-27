<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;

class WorkerInfo extends Component
{
    public $user;
    public $name;
    public $email;
    public $password;
    public function mount($userId)
    {
        $this->user = User::findOrFail($userId);
        $this->name = $this->user->name;
        $this->email = $this->user->email;
    }
    public function update()
    {
        $this->user->name = $this->name;
        $this->user->email = $this->email;
        $this->user->password = bcrypt($this->password);
        $this->user->update();
        $this->js("alert('Pengguna ini telah di-update')");
        return redirect()->route('user-info', ['userId' => $this->user->id]);
    }
    public function delete()
    {
        $this->user->delete();
        $this->js("alert('Pengguna ini telah dipadam')");
        return redirect('/home');
    }
    public function render()
    {
        return view('livewire.worker-info');
    }
}
