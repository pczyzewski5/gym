class UploadImageHelper {
    constructor() {
        this.execute()
    }

    execute() {
        $('.file-input').on('input', function(e) {
            $('.image img ').attr('src', URL.createObjectURL(e.target.files[0]));
        });
    }
}

new UploadImageHelper();