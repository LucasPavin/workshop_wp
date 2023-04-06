import $ from 'jquery';
import 'jquery-ui';
import 'jquery-ui/ui/widgets/tabs';
import 'jquery-ui/ui/widgets/accordion';

let gk_accordions = {

    load() {
        $(".gk-tabs").tabs();
        $( ".gk-accordion" ).accordion({
            header: ".accordion-title"
        });
    }
}
export default gk_accordions;