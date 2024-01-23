class TimeSpentPerTraining {
    constructor() {
        this.execute()
    }

    execute() {
        const ctx = document.getElementById('time-spent-per-training');

        const data = {
            datasets: [
                {
                    data: JSON.parse(ctx.dataset.timeSpentOnGymPerTrainingInMinutes),
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                }
            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                scales: {
                    y: {
                        grace: 20,
                        ticks: {
                            stepSize: 10
                        }
                    }
                },
                responsive: true,
                parsing: {
                    xAxisKey: 'training_date',
                    yAxisKey: 'minutes_spent'
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Czas spędzony na treningu'
                    },
                    datalabels: {
                        color: 'rgb(54, 162, 235)',
                        backgroundColor: '#FFFFFF',
                        align: 'top',
                        formatter: function(value, context) {
                            let $data = $.map(context.dataset.data, function(val) {return val;});

                            return parseInt($data[context.dataIndex]['minutes_spent']);
                        },
                        listeners: {
                            click: function(context, event) {
                                let $trainingId = context['dataset']['data'][context.dataIndex]['id'];
                                window.location.href = '/training/' + $trainingId + '/read';
                            }
                        }
                    },
                    annotation: {
                        annotations: {
                            line1: {
                                type: 'line',
                                borderColor: 'rgba(54, 162, 235, 0.5)',
                                scaleID: 'y',
                                value: ctx.dataset.averageTimeSpentOnGymInMinutes,
                                label: {
                                    display: true,
                                    content: '~ ' + ctx.dataset.averageTimeSpentOnGymInMinutes,
                                    fontColor: 'rgb(54, 162, 235)',
                                    color: 'rgb(54, 162, 235)',
                                    backgroundColor: "#FFFFFF",
                                }
                            }
                        }
                    }
                }
            }
        };

        Chart.register(ChartDataLabels);

        new Chart(ctx, config);
    }
}

new TimeSpentPerTraining();