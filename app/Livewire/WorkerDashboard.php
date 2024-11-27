<?php

namespace App\Livewire;

use App\Models\Attend;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class WorkerDashboard extends Component
{
    public $attendance;
    public $catatan;

    public function mount()
    {
        $this->attendance = Attend::where('user_id', Auth::id())
            ->whereDate('date', today())
            ->whereNull('check_out')
            ->first();
    }
    protected $rules = [
        'catatan' => 'nullable',
    ];
    public function check_in()
    {
        $this->validate();
        $this->attendance = new Attend();
        $this->attendance->user_id = auth()->id();
        $this->attendance->check_in = now();
        $this->attendance->date = today();
        $this->attendance->catatan = $this->catatan;
        // dd($this->attendance);
        $this->attendance->save();
        $citime = $this->attendance->check_in->format('h:i A');
        $this->js("alert('You have check-in at $citime')");
        // session()->flash('success', 'You have successfully checked in at ' .$citime);
    }

    public function check_out()
    {
        $this->attendance->check_out = now();
        $this->attendance->save();
        $cotime = $this->attendance->check_out->format('h:i A');
        $this->js("alert('You have check-out at $cotime')");
        $this->attendance = null;
    }

    public  function in_out()
    {
        if (!$this->attendance) {
            $this->check_in();
        } else {
            $this->check_out();
        }
    }
    public function render()
    {
        return view('livewire.worker-dashboard');
    }
}
