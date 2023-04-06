let navigation = {

    load() {
        document.addEventListener("DOMContentLoaded", function() {

            window.addEventListener("scroll", function () {
                let header = document.querySelector("header");
                header.classList.toggle('sticky', window.scrollY > 0);
            });

            $('.menu-item-has-children').find('> a, > .obf').click(function (e) {
                if ($(window).width() <= 992) {
                    e.preventDefault();
                    e.stopPropagation();
                    $(this).unbind(e);
                }
            });

            //menu V02
            const largeScreenSize = 992;
            let burgerBtn = document.querySelector("#primary-mobile-menu");

            // If button exist we add events listeners
            if(burgerBtn) {
                burgerBtn.addEventListener("click", () => {
                    if(burgerBtn.getAttribute("aria-expanded") == "false") {
                        burgerBtn.setAttribute("aria-expanded", true);
                        document.body.classList.add('primary-navigation-open');
                        document.querySelector('html').classList.add('no-scroll');
                    } else {
                        burgerBtn.setAttribute("aria-expanded", false);
                        document.body.classList.remove('primary-navigation-open');
                        document.querySelector('html').classList.remove('no-scroll');
                    }
                });

                addEventOnSubmenus(largeScreenSize);

                // remove primary-navigation-open class if window size > 992px / $large
                window.addEventListener("resize", function(){
                    if(window.innerWidth > largeScreenSize){
                        document.body.classList.remove('primary-navigation-open');
                        burgerBtn.setAttribute("aria-expanded", false);
                    }
                    addEventOnSubmenus(largeScreenSize);
                });
            }
        });
    },
};


function addEventOnSubmenus(largeScreenSize) {
    let submenus = document.querySelectorAll("li.menu-item-has-children");

    submenus.forEach(li => {
        let elementA = li.querySelector('a');

        //reinit dom element
        elementA.setAttribute("aria-expanded", "false");
        console.log("reinit a", elementA, elementA.getAttribute("aria-expanded"))
        li.removeEventListener("mouseenter", rollExpand);
        li.removeEventListener("mouseleave", rollExpand);
        elementA.removeEventListener("click", clickExpand);

        //add Event listener
        if(window.innerWidth > largeScreenSize){
            li.addEventListener("mouseenter", rollExpand);
            li.addEventListener("mouseleave", rollExpand);
        } else {
            elementA.addEventListener("click", clickExpand);
        }
    });
}

//handle target on click <a>
function clickExpand(e) {
    let t = e.target;
    toggleAriaExpanded(t);
};

//handle target on click <li><a>
function rollExpand(e) {
    let t = e.target.querySelector('a');
    toggleAriaExpanded(t);
};

//Toggle Aria Expanded attribute
function toggleAriaExpanded(target) {
    if(target.getAttribute("aria-expanded") === "false" || target.getAttribute("aria-expanded") === false) {
        target.setAttribute("aria-expanded", "true");
    } else {
        target.setAttribute("aria-expanded", "false");
    }
}

export default navigation;
