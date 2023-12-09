class NavbarBurgerHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $(document).ready(function() {
            $('.navbar-burger').click(function() {
                $('.navbar-burger').toggleClass('is-active');
                $('.navbar-menu').toggleClass('is-active');
            });
        });
    }
}

new NavbarBurgerHelper();