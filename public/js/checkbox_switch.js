class CheckboxSwitch {
    constructor() {
        this.execute()
    }

    execute() {
        $('.switch-desc').on('click', function(e) {
            let $target = $(e.target);
            let $switchContainer = $target.parent();
            let $slider = $switchContainer.find('.slider');

            $slider.click();
        });
    }
}

new CheckboxSwitch();