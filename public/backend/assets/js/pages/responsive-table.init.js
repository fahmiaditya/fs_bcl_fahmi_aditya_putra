"use strict";
! function (e) {
    function n() {}
    n.prototype.init = function () {
        document.addEventListener("DOMContentLoaded", function () {
            e(".table-rep-plugin").responsiveTable("update"), e(".btn-toolbar [data-toggle=dropdown]").attr("data-bs-toggle", "dropdown")
        })
    }, e.ResponsiveTable = new n, e.ResponsiveTable.Constructor = n
}(window.jQuery), window.jQuery.ResponsiveTable.init();
