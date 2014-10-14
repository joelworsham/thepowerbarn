/**
 * The Power Barn search form.
 *
 * @since ThePowerBarn 0.1.0
 *
 * @package ThePowerBarn
 * @subpackage Scripts
 * @category Generic
 */
var PB_Search;
(function ($) {
    PB_Search = {
        /**
         * Initializes some things and sets off some functions on load.
         *
         * @since ThePowerBarn 0.1.0
         */
        init: function () {

            this.force_search_active();
            this.search_validate();
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
        },
        /**
         * Validate the search form.
         *
         * @since ThePowerBarn 0.1.0
         */
        search_validate: function () {
            $('.search-form').submit(function () {

                var input = $('.search-form').find('.search-box').val(),
                    message = '',
                    valid = true;

                if (input === '' ) {
                    message = 'Please enter something.';
                    valid = false;
                } else if (!input.match(/^[a-zA-Z0-9]*$/)) {
                    message = 'Please only use regular characters.';
                    valid = false;
                }

                if (!valid) {
                    var message_html = '<div class="alert-box alert" data-alert><span class="message">' + message + '</span><span class="close"></span></div>';

                    // Add the message
                    if (!$(this).find('.alert-box').length) {

                        $(this).append(message_html);

                        // Re-initialize foundation to make the alert-box function
                        $(document).foundation();
                    } else {
                        $(this).find('.alert-box .message').html(message);
                    }

                    // Cancel the submit
                    return false;
                }
            });
        }
    };

    // Launch on read
    $(function () {
        PB_Search.init();
    });
})(jQuery);