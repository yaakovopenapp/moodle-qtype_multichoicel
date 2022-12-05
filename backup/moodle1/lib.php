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
 * @package    qtype
 * @subpackage multichoicel
 * @copyright  2011 David Mudrak <david@moodle.com>
 * @license    http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * multichoicel question type conversion handler
 */
class moodle1_qtype_multichoicel_handler extends moodle1_qtype_handler {

    /**
     * @return array
     */
    public function get_question_subpaths() {
        return array(
            'ANSWERS/ANSWER',
            'multichoicel',
        );
    }

    /**
     * Appends the multichoicel specific information to the question
     */
    public function process_question(array $data, array $raw) {

        // Convert and write the answers first.
        if (isset($data['answers'])) {
            $this->write_answers($data['answers'], $this->pluginname);
        }

        // Convert and write the multichoicel.
        if (!isset($data['multichoicel'])) {
            // This should never happen, but it can do if the 1.9 site contained
            // corrupt data.
            $data['multichoicel'] = array(array(
                'single'                         => 1,
                'shuffleanswers'                 => 1,
                'correctfeedback'                => '',
                'correctfeedbackformat'          => FORMAT_HTML,
                'partiallycorrectfeedback'       => '',
                'partiallycorrectfeedbackformat' => FORMAT_HTML,
                'incorrectfeedback'              => '',
                'incorrectfeedbackformat'        => FORMAT_HTML,
                'answernumbering'                => 'abc',
                'showstandardinstruction'        => 0
            ));
        }
        $this->write_multichoicel($data['multichoicel'], $data['oldquestiontextformat'], $data['id']);
    }

    /**
     * Converts the multichoicel info and writes it into the question.xml
     *
     * @param array $multichoicels the grouped structure
     * @param int $oldquestiontextformat - {@see moodle1_question_bank_handler::process_question()}
     * @param int $questionid question id
     */
    protected function write_multichoicel(array $multichoicels, $oldquestiontextformat, $questionid) {
        global $CFG;

        // The grouped array is supposed to have just one element - let us use foreach anyway
        // just to be sure we do not loose anything.
        foreach ($multichoicels as $multichoicel) {
            // Append an artificial 'id' attribute (is not included in moodle.xml).
            $multichoicel['id'] = $this->converter->get_nextid();

            // Replay the upgrade step 2009021801.
            $multichoicel['correctfeedbackformat']               = 0;
            $multichoicel['partiallycorrectfeedbackformat']      = 0;
            $multichoicel['incorrectfeedbackformat']             = 0;

            if ($CFG->texteditors !== 'textarea' and $oldquestiontextformat == FORMAT_MOODLE) {
                $multichoicel['correctfeedback']                 = text_to_html($multichoicel['correctfeedback'], false, false, true);
                $multichoicel['correctfeedbackformat']           = FORMAT_HTML;
                $multichoicel['partiallycorrectfeedback']        = text_to_html($multichoicel['partiallycorrectfeedback'], false, false, true);
                $multichoicel['partiallycorrectfeedbackformat']  = FORMAT_HTML;
                $multichoicel['incorrectfeedback']               = text_to_html($multichoicel['incorrectfeedback'], false, false, true);
                $multichoicel['incorrectfeedbackformat']         = FORMAT_HTML;
            } else {
                $multichoicel['correctfeedbackformat']           = $oldquestiontextformat;
                $multichoicel['partiallycorrectfeedbackformat']  = $oldquestiontextformat;
                $multichoicel['incorrectfeedbackformat']         = $oldquestiontextformat;
            }

            $multichoicel['correctfeedback'] = $this->migrate_files(
                    $multichoicel['correctfeedback'], 'question', 'correctfeedback', $questionid);
            $multichoicel['partiallycorrectfeedback'] = $this->migrate_files(
                    $multichoicel['partiallycorrectfeedback'], 'question', 'partiallycorrectfeedback', $questionid);
            $multichoicel['incorrectfeedback'] = $this->migrate_files(
                    $multichoicel['incorrectfeedback'], 'question', 'incorrectfeedback', $questionid);

            $this->write_xml('multichoicel', $multichoicel, array('/multichoicel/id'));
        }
    }
}
