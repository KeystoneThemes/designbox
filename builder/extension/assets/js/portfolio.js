!function(t){var a=function(t,a){var e=a(".enable-filter .wdb-posts",t);e.length&&mixitup(e);var n=a(".pf-load-more a",t),o=a(".load-more-anchor",t).data("e-id"),r=!1,c=a(".load-more-anchor",t).data("page"),d=a(".load-more-anchor",t).data("max-page");n.on("click",(function(t){t.preventDefault(),c<d&&i()}));var i=function(){f(),r&&a(".wdb__btn",t).addClass("loading"),c++;var e=a(".load-more-anchor",t).attr("data-next-page");return fetch(e).then((function(t){return t.text()})).then((function(t){var a=(new DOMParser).parseFromString(t,"text/html");l(a)}))},l=function(e){u();var i=e.querySelectorAll('[data-id="'.concat(o,'"] .wdb-posts > article')),l=e.querySelector('[data-id="'.concat(o,'"] .load-more-anchor')).getAttribute("data-next-page");i.forEach((function(t){return a('[data-id="'.concat(o,'"] .wdb-posts')).append(t)})),a(".load-more-anchor",t).attr("data-page",c),a(".load-more-anchor",t).attr("data-next-page",l),r||a(".wdb__btn",t).removeClass("loading"),c===d&&n.hide()},f=function(){r=!0},u=function(){r=!1}};t(window).on("elementor/frontend/init",(function(){elementorFrontend.hooks.addAction("frontend/element_ready/wdb--portfolio.default",a)}))}(jQuery);