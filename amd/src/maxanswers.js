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


    var init = function(max) {

        $max = max-1;
        $(document).ready(function() {
            let $total = 0;
            $("div.answer input[type=checkbox]").each(function(){
                $(this).on("click", function(event) {
                    if (!$(this).is(":checked")) {
                        $total = $total - 1;
                    } else if ($total <= $max) {
                        $total = $total + 1 ;
                    } else {
                        event.preventDefault();
                        event.stopPropagation();
                    }
                });
            });
    });

    $(document).ready(function() {
            $("div.formulation.clearfix").each(function() {
            if ($(this).find("#maximumselections").length) {
                let maxselect = parseInt($(this).find("#maximumselections").text());
                $(this).find("#numberselections").text(maxselect);
                let $total = 1;
                $(this).find("div.answer input[type=checkbox]").each(function() {
                    if($(this).is(":checked")){ $total++; }
                    $(this).on("click", function(event) {
                        if (!$(this).is(":checked")) {
                            $total = $total - 1;
                            $("div.validationerror").remove();
                        } else if ($total <= maxselect) {
                            $total = $total + 1;
                            $("div.validationerror").remove();
                        } else {
                            event.preventDefault();
                            event.stopPropagation();
                            if (!$("div.validationerror").length) {
                                $("div.answer").after("<div class='validationerror'> Please select    " + maxselect + " only.</div>");
                            }
                        }
                    });
                });
            }
        });
    })

}
    return {
        init: init
    };
});
