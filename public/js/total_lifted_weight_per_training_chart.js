class TotalLiftedWeightPerTrainingChart {
    constructor() {
        this.execute()
    }

    execute() {
        const ctx = document.getElementById('total-lifted-weight-per-training-chart');

        const data = {
            datasets: [
                {
                    data: JSON.parse(ctx.dataset.totalLiftedWeightPerTraining),
                    borderColor: 'rgb(54, 162, 235)',
                    backgroundColor: 'rgba(54, 162, 235, 0.5)',
                }
            ]
        };

        const config = {
            type: 'line',
            data: data,
            options: {
                responsive: true,
                parsing: {
                    xAxisKey: 'training_date',
                    yAxisKey: 'kilograms_total'
                },
                plugins: {
                    legend: {
                        display: false,
                    },
                    title: {
                        display: true,
                        text: 'Suma podniesionych kilogramów per trening'
                    },
                    datalabels: {
                        color: 'rgb(54, 162, 235)',
                        backgroundColor: '#FFFFFF',
                        align: 'top',
                        formatter: function(value, context) {
                            let $data = $.map(context.dataset.data, function(val) {return val;});

                            return parseInt($data[context.dataIndex]['kilograms_total']);
                        },
                        listeners: {
                            click: function(context, event) {
                                let $trainingId = context['dataset']['data'][context.dataIndex]['training_id'];
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
                                value: ctx.dataset.averageLiftedWeight,
                                label: {
                                    display: true,
                                    content: '~ ' + ctx.dataset.averageLiftedWeight,
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

new TotalLiftedWeightPerTrainingChart();