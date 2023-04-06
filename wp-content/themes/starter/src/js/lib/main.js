//import LazyLoad from 'vanilla-lazyload';
//import polyfill from "./polyfill";
import Flickity from 'flickity';

let main = {

    load() {
        console.log("Made with ❤ by Gosselink.");

        $(document).ready(function () {

            // document.addEventListener("mousemove", function(event) {
            //     const x = event.pageX - 10;
            //     const y = event.pageY - 10;
            //     const cursor = document.querySelector("#cursor");
            //     cursor.style.left = x + "px";
            //     cursor.style.top = y + "px";
            // });

            $('.gk-slider').on("mouseover", function(){
                $('#cursor').css({'transform': 'scale(6)', 'font-size': '0'});
            });

            $('.gk-slider').on("mouseleave", function(){
                $('#cursor').css({'transform': 'scale(1)', 'font-size': '0'});
            });


            // Search widget
            $('.popup_search a').on('click', function () {
                $('.full-bg').addClass('active');
                $('#s').focus();
            });
            $('.close-popup').on('click', function () {
                $('.full-bg').removeClass('active');
            });

            //uncomment this if you want to close the popup on click on whole popup screen
            // $('#popup').on('click', function () {
            //     if($('#popup').hasClass('open')) {
            //            $('#popup').removeClass('open');
            //            $('html').removeClass('no-scroll');
            //        }
            // });

            if ($('.home-slider').length > 0) {
                new Flickity('.home-slider', {
                    prevNextButtons: true,
                    pageDots: true,
                    wrapAround: true,
                });
            }


            $('.nav-links .menu-item-has-children').find('> a, > .obf').click(function (e) {
                if ($(window).width() <= 1200) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).unbind(e);
                }
            });

            main.loaded();
        });

    },

    loaded() {
        // Load all necessary polyfill
        //polyfill.load();

        // Page Popups
        let $popup = $('#popup');
        $(document).on('click', '.open-popup', function (e) {
            e.preventDefault();
            e.stopPropagation();

            $.ajax({
                method: "POST",
                url: wp_data.ajax_url,
                data: {
                    method: "POST",
                    action: 'post_content',
                    ID: $(this).data('post-id'),
                    security: wp_data.security
                }
            })
                .done(function (response) {
                    $popup.addClass('open');
                    $('html').addClass('no-scroll');
                    $popup.find('.popup-content').html(response);
                    //close popup
                    $('.close-button').on('click', function () {
                        if ($('#popup').hasClass('open')) {
                            $('#popup').removeClass('open');
                            $('html').removeClass('no-scroll');
                        }
                    });

                })
                .fail(function () {
                    console.error("Error getting post content");
                });
        });

        // Lazy Loading des images
        // if ($('.lazy').length) {
        //     new LazyLoad();
        // }

        // Theme Color
        const toggleSwitch = document.querySelector('.theme-switch input[type="checkbox"]');
        const currentTheme = localStorage.getItem('theme') ? localStorage.getItem('theme') : null;
        const osColorDark = window.matchMedia("(prefers-color-scheme: dark)").matches; // OS Preference is dark

        function switchTheme(e) {
            if (e.target.checked) {
                document.documentElement.setAttribute('data-theme', 'dark');
                localStorage.setItem('theme', 'dark');
            }
            else {
                document.documentElement.setAttribute('data-theme', 'light');
                localStorage.setItem('theme', 'light');
            }
        }

        // if Button exist we add an event listener
        if(toggleSwitch) {
            toggleSwitch.addEventListener('change', switchTheme, false);
        }

        if (currentTheme) {
            document.documentElement.setAttribute('data-theme', currentTheme);

            if (currentTheme === 'dark' && !osColorDark) {
                toggleSwitch.checked = true;
            }
        } else if(osColorDark) {
            toggleSwitch.checked = true;
        }
    },
};

export default main;
