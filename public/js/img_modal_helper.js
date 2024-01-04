class ImgModalHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $modalLaunchButton = $('.img-modal-launch-button');
        var $modalBackground = $('.modal-background');
        var $modalImage = $('.modal-image');

        $modalLaunchButton.on('click', function(e) {
            $(e.target).parent('.icon').children('.modal.img-modal').addClass('is-active');
        });
        $modalBackground.on('click', function(e) {
            $(e.target).parent('.modal.img-modal').removeClass('is-active');
        });
        $modalImage.on('click', function(e) {
            $(e.target).parents('.modal.img-modal').removeClass('is-active');
        });
    }
}

new ImgModalHelper();