//import 'select2/dist/js/select2';

let forms = {
    load() {
        $(document).ready(function () {
            // $('select').select2({
            //     placeholder: 'Select an option...',
            //     minimumResultsForSearch: -1,
            //     theme: "flat"
            // });

            forms.loaded();
        });
    },

    loaded() {
        // Show filename on change
        $('input[type=file]').on("change", function (e) {
            let ext = e.target.files[0].name.slice(e.target.files[0].name.lastIndexOf('.') + 1);
            let fileName = e.target.files[0].name;
            if (e.target.files[0].name.length - ext.length > 15) {
                fileName = e.target.files[0].name.slice(0, 15).concat('...').concat(ext);
            }

            if ($(this).closest('.input-file-section').children('.file-name').length > 0) {
                $(this).closest('.input-file-section').children('.file-name').html(fileName);
            } else {
                $(this).closest('.input-file-section').children('label').after('<span class="file-name">' + fileName + '</span>');
            }
        });
    }
};

export default forms;