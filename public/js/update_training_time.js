class UpdateTrainingTime {
    constructor() {
        this.execute()
    }

    execute() {
        function updateTrainingTime() {
            let $timestamp = Date.now() / 1000
            let $durationContainer =  $('#training-duration');
            let $duration = parseInt($durationContainer.data('training-started'));
            let $minutes = parseInt(($timestamp - $duration) / 60);

            let $result = '';

            if ($minutes < 10) {
                $result += '0'
            }

            $durationContainer.text($result += $minutes);
        }

        $(function() {
            updateTrainingTime();
            setInterval(updateTrainingTime, 10000);
        });
    }
}

new UpdateTrainingTime();