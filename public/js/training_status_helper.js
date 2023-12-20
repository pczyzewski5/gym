class TrainingStatusHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $button = $('#training-status-button');

        $button.click(function() {
            var $data = {
                'training_id':  $button.data('training-id'),
                'actual_status': $button.attr('data-actual-status')
            }

            let $request = $.ajax({
                url: '/training/change_status',
                method: 'POST',
                data: JSON.stringify($data),
                contentType: 'json'
            });

            $request.done(function ($status) {
                let $class = 'in_progress' === $status
                    ? 'is-warning'
                    : 'is-success';
                let $content = 'in_progress' === $status
                    ? 'zakończ trening'
                    : 'rozpocznij trening';

                $button.attr('data-actual-status', $status);
                $button.removeClass('is-warning is-success');
                $button.addClass($class);
                $button.text($content);
            });
        });
    }
}

new TrainingStatusHelper();