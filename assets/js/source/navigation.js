/**
 * The Power Barn navigation.
 *
 * This script is for the navigation menu at the top of the site containing
 * the various brands, lines, and series.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage Scripts
 * @category Navigation
 */
var PB_Navigation;
(function ($) {
    PB_Navigation = {
        init: function () {

            // Make clicking anywhere, besides the menu, close the menu
            $(document).click(function () {
                PB_Navigation._close_all();
            });

            // Make clicking the menu itself, not close itself
            $('.site-navigation').find('.sub-menu').click(function (event) {
                event.stopPropagation();
            });

            this.adjust_search_width();
            $('.search-options').change(function () {
                PB_Navigation.adjust_search_width()
            });
        },
        adjust_search_width: function () {
            console.log('test');
            var option = $('.search-options').find('option:selected').text(),
                container = $('.select-container'),
                width_temp = container.find('.width-temp');

            width_temp.html(option);

            container.width(width_temp.width() + 35);
        },
        /**
         * Fires when a brand icon is clicked.
         *
         * When a brand icon is clicked, the immediate sub-menu will become
         * active, thus displaying on the screen.
         *
         * @since ThePowerBarn 0.1.0
         *
         * @param e_this The provided brand element.
         *
         * @return void
         */
        show_brand: function (e_this) {

            // Stop from closing entire menu every click
            event.stopPropagation();

            // Close other menus first
            this._close_all();

            // Setup our variables
            var e = $(e_this),
                e_target = e.find('.sub-menu'),
                active = false;

            // If already active, make note of it
            if (e_target.hasClass('active')) {
                active = true;
            }

            // Remove active from all other brand's sub-menus
            $('#site-header').find('.site-navigation .menu-item-brand > .sub-menu').removeClass('active');

            // Add active to the current brand sub-menu IF it wasn't already active
            // Otherwise, do nothing. This allows us to toggle it
            if (!active) {
                e.find('.sub-menu').addClass('active');
            }
        },
        /**
         * Fires when a line icon is clicked.
         *
         * Sets active the corresponding series-section when clicked.
         *
         * @since ThePowerBarn 0.1.0
         *
         * @param e_this The provided line element.
         *
         * @return void
         */
        show_line: function (e_this) {

            // Stop it from propagating up to the brand click
            event.stopPropagation();

            // Setup our variables
            var e = $(e_this),
                e_section = e.closest('.sub-menu'),
                line = e.attr('data-line');

            // Get rid of active on all other line icons within this section
            e_section.find('.line').removeClass('active');

            // Add active to this line
            e.addClass('active');

            // Get rid of active on all within this section
            e_section.find('.series-section').removeClass('active');

            // Add active to the corresponding series section
            e_section.find('.series-section.' + line).addClass('active');
        },
        /**
         * Closes all open menus.
         *
         * @since ThePowerBarn 0.1.0
         *
         * @private
         */
        _close_all: function () {
            $('#site-navigation').find('.menu-item-brand > .sub-menu').removeClass('active');
        }
    };

    // Launch on read
    $(function () {
        PB_Navigation.init();
    });
})(jQuery);