<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class TestComponent extends Component
{
    public $toDoPercentage;
    public $doingPercentage;
    public $donePercentage;

    public function mount()
    {
        $this->calculateTaskPercentages();
    }

    public function calculateTaskPercentages()
    {
        $totalTasks = Task::count();
        
        if ($totalTasks == 0) {
            $this->toDoPercentage = 0;
            $this->doingPercentage = 0;
            $this->donePercentage = 0;
            return;
        }
        $toDoCount = Task::where('status', 'To Do')->count();
        $doingCount = Task::where('status', 'Doing')->count();
        $doneCount = Task::where('status', 'Done')->count();
        $this->toDoPercentage = ($toDoCount / $totalTasks) * 100;
        $this->doingPercentage = ($doingCount / $totalTasks) * 100;
        $this->donePercentage = ($doneCount / $totalTasks) * 100;

        $this->dispatch('updateDashboard', [
            'toDoPercentage' => $this->toDoPercentage,
            'doingPercentage' => $this->doingPercentage,
            'donePercentage' => $this->donePercentage,
        ]);
    }

    public function render()
    {   
        $this->dispatch('loadedDashboard');
        return view('livewire.test-component');
    }
}
