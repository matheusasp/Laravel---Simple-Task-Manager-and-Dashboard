
<div class="task-container">
    <div class="task-input-container">
        <label for="new-task">New Task:</label>
        <input type="text" id="new-task" wire:model="userInput" class="input-task">
        <button wire:click="addTask" class="btn-add-task">Add Task</button>
    </div>
    <br>


    <div class="task-lists-container">

        <div class="task-list">
            <label>To Do:</label>
            <ul id="sortable-To Do" class="sortable-list">
                @foreach ($tasks->where('status', 'To Do') as $task)
                    <li id="{{ $task->id }}" data-status="To Do" class="task-item">
                        <span>{{ $task->task_name }}</span>
                        <button wire:click="editTask({{ $task->id }})" class="icon-button">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button wire:click="deleteTask({{ $task->id }})" class="icon-button">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>


        <div class="task-list">
            <label>Doing:</label>
            <ul id="sortable-Doing" class="sortable-list">
                @foreach ($tasks->where('status', 'Doing') as $task)
                    <li id="{{ $task->id }}" data-status="Doing" class="task-item">
                        <span>{{ $task->task_name }}</span>
                        <button wire:click="editTask({{ $task->id }})" class="icon-button">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button wire:click="deleteTask({{ $task->id }})" class="icon-button">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>


        <div class="task-list">
            <label>Done:</label>
            <ul id="sortable-Done" class="sortable-list">
                @foreach ($tasks->where('status', 'Done') as $task)
                    <li id="{{ $task->id }}" data-status="Done" class="task-item">
                        <span>{{ $task->task_name }}</span>
                        <button wire:click="editTask({{ $task->id }})" class="icon-button">
                            <i class="fas fa-edit"></i> Edit
                        </button>
                        <button wire:click="deleteTask({{ $task->id }})" class="icon-button">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>


    @if ($isModalOpen)
        <div class="modal">
            <div class="modal-content">
                <h2>Edit Task</h2>
                <label for="editTaskName">Task Name:</label>
                <input type="text" id="editTaskName" wire:model="taskToEdit.task_name" class="input-task">
                <div class="modal-actions">
                    <button wire:click="closeModal" class="btn-cancel">Cancel</button>
                    <button wire:click="saveTask" class="btn-save">Save</button>
                </div>
            </div>
        </div>
    @endif



    <style>
        .task-container {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f4f4f9;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }
    
        .task-input-container {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    
        .input-task {
            padding: 8px;
            font-size: 16px;
            border-radius: 4px;
            border: 1px solid #ccc;
            width: 100%;
            max-width: 300px;
        }
    
        .btn-add-task {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
    
        .btn-add-task:hover {
            background-color: #45a049;
        }
    
        .task-lists-container {
            margin-top: 30px;
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }
    
        .task-list {
            background-color: #fff;
            padding: 15px;
            border-radius: 6px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            width: 30%;
        }
    
        .task-list label {
            font-weight: bold;
            display: block;
            margin-bottom: 10px;
        }
    
        .task-list ul {
            list-style-type: none;
            padding: 0;
        }
    
        .task-list li {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 8px 0;
            border-bottom: 1px solid #eee;
        }
    
        .icon-button {
            background: none;
            border: none;
            color: #007bff;
            cursor: pointer;
            font-size: 16px;
        }
    
        .icon-button:hover {
            color: #0056b3;
        }
    
        .modal {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
        }
    
        .modal-content {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            width: 400px;
            text-align: center;
        }
    
        .modal-actions {
            margin-top: 20px;
            display: flex;
            justify-content: space-between;
        }
    
        .btn-cancel, .btn-save {
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            border: none;
        }
    
        .btn-cancel {
            background-color: #f44336;
            color: white;
        }
    
        .btn-save {
            background-color: #4CAF50;
            color: white;
        }
    
        .btn-cancel:hover {
            background-color: #d32f2f;
        }
    
        .btn-save:hover {
            background-color: #45a049;
        }
    </style>


<script>


    
    document.addEventListener('DOMContentLoaded', function () {
        const sortableLists = document.querySelectorAll('.sortable-list');

        sortableLists.forEach(function (list) {
            new Sortable(list, {
                group: 'tasks',
                onEnd(evt) {
                    updateTaskStatus(evt.item.id, evt.from.id, evt.to.id);
                }
            });
        });

        function updateTaskStatus(taskId, fromListId, toListId) {
            const newStatus = toListId.replace('sortable-', '').trim();
            
            @this.call('updateTaskStatus', taskId, newStatus);
        }
    }); 

    Livewire.on('loadedTask', () => {
        const sortableLists = document.querySelectorAll('.sortable-list');

        sortableLists.forEach(function (list) {
            new Sortable(list, {
                group: 'tasks',
                onEnd(evt) {
                    updateTaskStatus(evt.item.id, evt.from.id, evt.to.id);
                }
            });
        });

        function updateTaskStatus(taskId, fromListId, toListId) {
            const newStatus = toListId.replace('sortable-', '').trim();
            
            @this.call('updateTaskStatus', taskId, newStatus);
        }
    });

</script>
</div>



