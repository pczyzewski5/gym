function changeValue($targetClass, $action, $step = null) {
    let $counter = $('.' + $targetClass);
    let $counterValue = parseInt($counter.html());
    let $stepSec = null === $step ? 1 : $step;

    if ($action === 'increase') {
        $counter.html($counterValue + $stepSec);
    } else if ($counterValue > 1) {
        $counter.html($counterValue - $stepSec);
    }
}

function saveExerciseProgress($trainingId, $stationId, $exerciseId) {
    var $counterJingle = document.getElementById('jingle');
    var $counterValue = parseInt($.trim($('.seconds-counter').html()));

    console.log($counterValue);

    let $data = {
        'training_id': $trainingId,
        'station_id': $stationId,
        'exercise_id': $exerciseId,
        'repetition_count': $('.repetition-counter').html(),
        'kilogram_count': $('.kilogram-counter').html(),
    };

    let $request = $.ajax({
        url: '/lifted-weight/create',
        method: 'POST',
        data: JSON.stringify($data),
        contentType: 'json'
    });

    $request.done(function($liftedWeightId) {
        let $lastRow = $('.table tr:last-child');
        if ($lastRow.length) {
            $lastRow.after('<tr id="' + $liftedWeightId + '"><td>#'+ ($('.table tr').length + 1) + '</td><td>' + $data['repetition_count'] + ' x</td><td>' + $data['kilogram_count'] + ' kg</td><td><button onclick="deleteExerciseProgress(\'' + $liftedWeightId + '\')" class="button is-danger is-small is-pulled-right">usuń</button></td></tr>');
        } else {
            $('.table tbody').append('<tr id="' + $liftedWeightId + '"><td>#1</td><td>' + $data['repetition_count'] + ' x</td><td>' + $data['kilogram_count'] + ' kg</td><td><button onclick="deleteExerciseProgress(\'' + $liftedWeightId + '\')" class="button is-danger is-small is-pulled-right">usuń</button></td></tr>');
        }

        $('.seconds-counter').countdownTimer({
            seconds: $counterValue,
            loop: false,
            callback: function () {
                $('.seconds-counter').text($counterValue);
                $counterJingle.play();
            }
        });
    });
}

function deleteExerciseProgress($id) {
    let $request = $.ajax({
        url: '/lifted-weight/' + $id + '/delete',
        method: 'GET'
    });

    $request.done(function() {
        $('#' + $id).remove();
    });
}