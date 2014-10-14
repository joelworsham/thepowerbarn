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

            this.sticky_footer();
        },
        /**
         * Keeps the footer at the bottom of the screen isn't tall enough.
         *
         * @since ThePowerBar 0.1.0
         */
        sticky_footer: function () {
            var footer = $("#site-footer"),
                pos = footer.position(),
                height = $(window).height();

            height = height - pos.top;
            height = height - footer.height();
            if (height > 0) {
                footer.css({
                    'margin-top': height + 'px'
                });
            }
        }
    };

    // Launch on read
    $(function () {
        PB.init();
    });
})(jQuery);