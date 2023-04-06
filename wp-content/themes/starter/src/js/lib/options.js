import smoothscroll from 'smoothscroll-polyfill';

let options = {

    load(){
        //detect Safari Browser to polyfill the css scroll-behavior: smooth;        
        let isSafari = /^((?!chrome|android).)*safari/i.test(navigator.userAgent);
        let $back_to_top = $('.scrolltop');
        
        $(document).ready(function(){

            // SCROLL TOP BUTTON ANIMATION
            if (wp_data.options.scroll_top_enabled){
                let offset = 300,
                    offset_opacity = 1000;

                $(window).scroll(function () {
                    ( $(this).scrollTop() > offset ) ? $back_to_top.addClass('is-visible') : $back_to_top.removeClass('is-visible fade-out');
                    if ($(this).scrollTop() > offset_opacity) {
                        $back_to_top.addClass('fade-out');
                    }
                });
            }

            // SMOOTH SCROLL POLYFILL FOR SAFARI ONLY, OTHER BROWSERS USE CSS
            // To be removed, one day, if SAFARI use the css scroll-behavior: smooth;
            if (isSafari){
                smoothscroll.polyfill();
                
                // Auto scroll to section on page load
                if (window.location.hash) {
                    let anchor = $( window.location.hash);
                    if (anchor.length > 0){
                        let bodyRect = document.body.getBoundingClientRect(),
                            elemRect = anchor[0].getBoundingClientRect(),
                            offset   = elemRect.top - bodyRect.top;
                        window.scroll({
                            top: offset, 
                            left: 0, 
                            behavior: 'smooth'
                        });
                    }
                }

                let anchors = document.getElementsByTagName("a");
                let bodyRect = document.body.getBoundingClientRect();
                for (var i = 0; i < anchors.length ; i++) {
                    //get all url links & identify # links to handle them with a smooth scroll js
                    let anchor = anchors[i];
                    let anchorLink = anchor.href;
                    var anchorId = anchorLink.split('#').pop();
                    
                    if(anchorId && anchorId !== null && anchorLink !== anchorId) {
                        let selectedEl = document.querySelector("#"+anchorId);
                        if(selectedEl !== null) {
                            let offset   = selectedEl.getBoundingClientRect().top - bodyRect.top;
                            
                            anchor.addEventListener("click", function (event) {
                                event.preventDefault();
                                window.scroll({
                                    top: offset, 
                                    left: 0, 
                                    behavior: 'smooth'
                                });
                            }, 
                            false);
                        }
                        
                    }
                }
                // SCROLL TOP
                if (wp_data.options.scroll_top_enabled){
                    $back_to_top.on('click', function (event) {
                        event.preventDefault();
                        window.scroll({
                            top: 0, 
                            left: 0, 
                            behavior: 'smooth'
                        });
                    });
                }
            }
        });
    },
};

export default options;