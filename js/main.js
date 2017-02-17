(function () {

// Fix navigation menu on scroll

    var relocateNav = (function () {

        var docElem = document.documentElement,
            didScroll = false,
            changeHeaderOn = 120;

        function init() {
            window.addEventListener('scroll', function (event) {
                if (!didScroll) {
                    didScroll = true;
                    setTimeout(scrollPage, 250);
                }
            }, false);
        }

        function scrollPage() {
            var sy = scrollY();
            if (sy >= changeHeaderOn) {
                $('#main-menu').addClass('fixed');
            }
            else {
                $('#main-menu').removeClass('fixed');
            }
            didScroll = false;
        }

        function scrollY() {
            return window.pageYOffset || docElem.scrollTop;
        }

        init();

    })();

// Bounce scroll back when clicking intra-page links, to avoid hiding titles under fixed menu

    window.onload = function () {
        $(".article-links").click(function (e) {
            setTimeout(scrollBack, 10);
        });

        function scrollBack() {
            var menu = document.getElementById("main-menu"),
                mh = menu.clientHeight,
                scrl = -mh - 5;

            window.scrollBy(0, scrl);
        }
    };
});