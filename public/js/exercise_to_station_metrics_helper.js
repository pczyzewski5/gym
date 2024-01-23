class ExerciseToStationMetricsHelper {
    constructor() {
        this.execute()
    }

    execute() {
        let $selector = $('#exercise-to-station-metrics-selector');
        let $chart = $('#exercise-to-station-chart');

        function getChartConfig($data) {
            return {
                type: 'line',
                data: {
                    datasets: [
                        {
                            data: $data,
                            borderColor: 'rgb(54, 162, 235)',
                            backgroundColor: 'rgba(54, 162, 235, 0.5)',
                        }
                    ]
                },
                options: {
                    responsive: true,
                    parsing: {
                        xAxisKey: 'training_date',
                        yAxisKey: 'max_kilograms'
                    },
                    scales: {
                        y: {
                            grace: 2,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    },
                    plugins: {
                        legend: {
                            display: false,
                        },
                        title: {
                            display: true,
                            text: 'Progres ciężaru dla danego ćwiczenia'
                        },
                        datalabels: {
                            color: 'rgb(54, 162, 235)',
                            backgroundColor: '#FFFFFF',
                            align: 'top',
                            formatter: function($value) {
                                return $value['max_kilograms'];
                            }
                        }
                    }
                }
            };
        }

        function attachChart($selector)
        {
            let $option = $selector.find(':selected');
            let $exerciseId = $option.data('exercise-id');
            let $stationId = $option.data('station-id');

            let $request = $.ajax({
                url: '/lifted-weight/exercise/' + $exerciseId + '/station/' + $stationId + '/metrics',
                method: 'GET',
                async: false
            });

            $request.done(function($data) {
                let $lastChart = Chart.getChart($chart);
                if (typeof $lastChart !== 'undefined') {
                    $lastChart.destroy();
                }

                new Chart($chart, getChartConfig((JSON.parse($data))))
            });
        }

        $selector.ready(function() {
            attachChart($(this));
        });

        $selector.change(function() {
            attachChart($(this));
        });
    }
}

new ExerciseToStationMetricsHelper();
