<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;

class TaskComponent extends Component
{
    public $tasks;
    public $userInput;
    public $isModalOpen = false;
    public $taskToEdit;

    protected $rules = [
        'taskToEdit.task_name' => 'required|string|max:255',
    ];

    public function mount()
    {
        $this->tasks = Task::all();

        $this->dispatch('renderComponent');
    }

    public function addTask()
    {
        Task::create(['task_name' => $this->userInput, 'status' => 'To Do']);
        $this->tasks = Task::all();
        $this->userInput = '';
    }

    public function editTask($id)
    {
        $this->taskToEdit = Task::findOrFail($id);
        $this->isModalOpen = true;
    }

    public function saveTask()
    {
        $this->validate();
        $this->taskToEdit->save();
        $this->tasks = Task::all();
        $this->isModalOpen = false;
    }

    public function updateTaskStatus($taskId, $newStatus)
    {
        $task = Task::findOrFail($taskId);
        
        if ($task->status !== $newStatus) {
            $task->status = $newStatus;
            $task->save();
        }

        $this->tasks = Task::all();
    }

    public function deleteTask($id)
    {
        Task::findOrFail($id)->delete();
        $this->tasks = Task::all();
    }

    public function closeModal()
    {
        $this->isModalOpen = false;
    }

    public function render()
    {
        $this->dispatch('loadedTask');
        return view('livewire.task-component', ['tasks' => Task::all()]);
    }
}
