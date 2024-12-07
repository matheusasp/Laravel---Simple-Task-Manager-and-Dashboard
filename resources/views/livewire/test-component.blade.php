<div class="task-dashboard">
    <h2>Task Status Dashboard</h2>

    <div style="display: flex; justify-content: center;">
        <div class="chart-container">
            <h4>Task Status</h4>
            <canvas id="taskStatusChart"></canvas>
        </div>
    </div>

    <script>


        document.addEventListener('livewire:init', function () {

            Livewire.on('updateDashboard', (event) => {
                var todoPercentage = parseFloat("{{ $toDoPercentage }}");
                var doingPercentage =  parseFloat("{{ $doingPercentage }}");
                var donePercentage =  parseFloat("{{ $donePercentage }}");


                var remainingTodo = 100 - todoPercentage;
                var remainingDoing = 100 - doingPercentage;
                var remainingDone = 100 - donePercentage;

                var ctx = document.getElementById('taskStatusChart').getContext('2d');

                if (window.myChart) {
                    console.log("aaaa");
                    window.myChart.destroy();
                }

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['To Do', 'Doing', 'Done'],
                        datasets: [{
                            label: 'Task Status',
                            data: [todoPercentage, doingPercentage, donePercentage],
                            backgroundColor: ['#FF6347', '#FFD700', '#32CD32'],  
                            borderWidth: 1 
                        }]
                    },
                    options: {
                        responsive: true,
                        cutoutPercentage: 60, 
                        plugins: {
                            legend: {
                                position: 'top', 
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2) + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            });

        });

        Livewire.on('loadedDashboard', (event) => {
                var todoPercentage = parseFloat("{{ $toDoPercentage }}");
                var doingPercentage =  parseFloat("{{ $doingPercentage }}");
                var donePercentage =  parseFloat("{{ $donePercentage }}");


                var remainingTodo = 100 - todoPercentage;
                var remainingDoing = 100 - doingPercentage;
                var remainingDone = 100 - donePercentage;

                var ctx = document.getElementById('taskStatusChart').getContext('2d');

                if (window.myChart) {
                    window.myChart.destroy();
                }

                new Chart(ctx, {
                    type: 'doughnut',
                    data: {
                        labels: ['To Do', 'Doing', 'Done'],
                        datasets: [{
                            label: 'Task Status',
                            data: [todoPercentage, doingPercentage, donePercentage],
                            backgroundColor: ['#FF6347', '#FFD700', '#32CD32'],  
                            borderWidth: 1 
                        }]
                    },
                    options: {
                        responsive: true,
                        cutoutPercentage: 60, 
                        plugins: {
                            legend: {
                                position: 'top', 
                            },
                            tooltip: {
                                callbacks: {
                                    label: function(tooltipItem) {
                                        return tooltipItem.label + ': ' + tooltipItem.raw.toFixed(2) + '%';
                                    }
                                }
                            }
                        }
                    }
                });
            });
    </script>

    <style>
        .task-dashboard {
            text-align: center;
            margin-top: 20px;
        }
        .chart-container {
            width: 300px;
            height: 300px;
        }
        canvas {
            max-width: 100%;
            max-height: 100%;
        }
    </style>
</div>


