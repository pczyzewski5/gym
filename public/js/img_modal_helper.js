class ImgModalHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $modalLaunchButton = $('.modal-launch-button');
        var $modalBackground = $('.modal-background');
        var $modalImage = $('.modal-image');

        $modalLaunchButton.on('click', function(e) {
            $(e.target).children('.modal').addClass('is-active');
        });
        $modalBackground.on('click', function(e) {
            $(e.target).parent('.modal').removeClass('is-active');
        });
        $modalImage.on('click', function(e) {
            $(e.target).parents('.modal').removeClass('is-active');
        });
    }
}

new ImgModalHelper();