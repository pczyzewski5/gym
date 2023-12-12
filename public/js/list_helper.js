class ListHelper {
    constructor() {
        this.execute()
    }

    execute() {
       var $tableItem = $('.table-item');

       $tableItem.on('click', function() {
           window.location.href = $(this).attr('href');
       });
    }
}

new ListHelper();