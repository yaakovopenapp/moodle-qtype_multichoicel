// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Manages 'Clear my choice' functionality actions.
 *
 * @module     qtype_multichoicel/clearchoice
 * @copyright  2019 Simey Lameze <simey@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 * @since      3.7
 */
define(['jquery'], function() {
    var init = function() {
        $(document).ready(function() {
            $("div.formulation.clearfix").each(function() {
                    $(this).find("div.answer input[type=checkbox]").each(function() {
                    $(this).on("click", function(event) {
                        let maxanswers = $(this).data('maxanswers');
                        let qid = this.id.replace(/_.*/, '');
                        let totalChecked = $('[id^="' + qid + '"]').toArray().reduce((t, v) => t + (v.checked ? 1 : 0), 0);
                        if (!$(this).is(":checked")) {
                            $("div.validationerror").remove();
                        } else if (totalChecked <= maxanswers) {
                            totalChecked = totalChecked + 1;
                             $("div.validationerror").remove();
                        } else {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    });
                });
            }
        );
    });
}
    return {
        init: init
    };
});