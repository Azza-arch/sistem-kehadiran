<?php

namespace App\Livewire;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class AdminDashboard extends Component
{
    use WithPagination;
    public $search = '';

    public function render()
    {
        $users = User::orderBy('name', 'asc')->where('name', 'like', '%' . $this->search . '%')
            ->where('email', '!=', 'syed@gmail.com')->paginate(20);
        return view('livewire.admin-dashboard', ['users' => $users]);
    }
}
