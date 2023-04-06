import $ from 'jquery';

let gk_highlights = {
    load (){
        $('.gk-highlights .count').each(function () {
            $(this).prop('Counter', 1090).animate({
                Counter: $(this).text()
            }, {
                duration: 2000,
                easing: 'swing',
                step: function (now) {
                    $(this).text(Math.ceil(now));
                }
            });
        });
    }
}

export default gk_highlights;