<?php
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
 * Admin settings for the multichoicel question type.
 *
 * @package   qtype_multichoicel
 * @copyright  2015 onwards Nadav Kavalerchik
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($ADMIN->fulltree) {
    $menu = array(
        new lang_string('answersingleno', 'qtype_multichoicel'),
        // new lang_string('answersingleyes', 'qtype_multichoicel'),
    );
    $settings->add(new admin_setting_configselect('qtype_multichoicel/answerhowmany',
    new lang_string('answerhowmany', 'qtype_multichoicel'),
    new lang_string('answerhowmany_desc', 'qtype_multichoicel'), '1', $menu));



    $settings->add(new admin_setting_configcheckbox('qtype_multichoicel/shuffleanswers',
    new lang_string('shuffleanswers', 'qtype_multichoicel'),
    new lang_string('shuffleanswers_desc', 'qtype_multichoicel'), '1'));

    $maxanswers = [1 => 1 ,2 => 2 ,3 => 3 ,4 => 4 ,5 => 5 ,6 => 6 ,7 => 7 ,8 => 8 ,9 => 9 ,10 => 10 ];
    $settings->add(new admin_setting_configselect('qtype_multichoicel/maximumanswers',
    new lang_string('maximumanswers', 'qtype_multichoicel'),
    new lang_string('maximumanswers_desc', 'qtype_multichoicel'), '1', $maxanswers));

    $settings->add(new qtype_multichoicel_admin_setting_answernumbering('qtype_multichoicel/answernumbering',
    new lang_string('answernumbering', 'qtype_multichoicel'),
    new lang_string('answernumbering_desc', 'qtype_multichoicel'), 'abc', null ));

}
