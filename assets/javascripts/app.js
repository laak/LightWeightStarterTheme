var applications = [];

// Hide topbanner on scroll
var app = (function($) {

    var testapp = function () {

    }

    return {
        init: function() {
            // Test 123 123
        }
    }

})(jQuery);
applications.push(app);

$(document).ready(function() {
    applications.forEach(function (app) { 
        if (typeof app.init == 'function') {
            app.init() 
        } else {
            console.log("STARTUP ERROR: Finns ingen funktion som heter app.init");
            console.log(app);
        }
    });
});