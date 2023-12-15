class TagsHelper {
    constructor() {
        this.execute()
    }

    execute() {
        var $tags = [];

        $('form[name=training_form]').submit(function () {
            $('.tags-input').children('.tag').each(function () {
                $tags.push($.trim($(this).text()));
            });

            if ($tags.length > 0) {
                $('#training_form_tags').val(
                    JSON.stringify($tags)
                );
            }

            return true;
        });
    }
}

new TagsHelper();