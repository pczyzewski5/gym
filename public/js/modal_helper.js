class ModalHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $modal = $('.modal');
        var $modalLaunchButton = $('.modal-launch-button');
        var $modalBackground = $('.modal-background');
        var $modalNoButton = $('.modal-no-button');
        var $modalYesButton = $('.modal-yes-button');
        var $href = $modalLaunchButton.attr('data-href');

        $modalLaunchButton.on('click', function() {
            $modal.addClass('is-active');
        });
        $modalBackground.on('click', function() {
            $modal.removeClass('is-active');
        });
        $modalNoButton.on('click', function() {
            $modal.removeClass('is-active');
        });
        $modalYesButton.on('click', function() {
            window.location.href = $href;
        });
    }
}

new ModalHelper();