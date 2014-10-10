/**
 * The Power Barn main.
 *
 * The main script for The Power Barn.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage Scripts
 * @category Generic
 */
var PB;
(function ($) {
    PB = {
        /**
         * Initializes some things and sets off some functions on load.
         *
         * @since ThePowerBarn 0.1.0
         */
        init: function () {

            // Initialize foundation and setup a few settings
            $(document).foundation({
                equalizer: {
                    equalize_on_stack: true
                }
            });

            this.force_search_active();
        },
        /**
         * Forces the search form to be active when it's input is active.
         *
         * @since ThePowerBarn 0.1.0
         */
        force_search_active: function () {
            var search_input = $('.searchform').find('input');

           search_input.focus(function () {
                $(this).closest('.searchform').addClass('focus');
            });

           search_input.focusout(function () {
                $(this).closest('.searchform').removeClass('focus');
            });
        }
    };

    // Launch on read
    $(function () {
        PB.init();
    });
})(jQuery);