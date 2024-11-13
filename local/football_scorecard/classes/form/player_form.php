<?php
namespace local_football_scorecard\form;

defined('MOODLE_INTERNAL') || die();

require_once("$CFG->libdir/formslib.php");

class player_form extends \moodleform {
    public function definition() {
        $mform = $this->_form;
        
        $mform->addElement('text', 'player_name', get_string('player_name', 'local_football_scorecard'));
        $mform->setType('player_name', PARAM_TEXT);

        $mform->addElement('text', 'goal_count', get_string('goal_count', 'local_football_scorecard'));
        $mform->setType('goal_count', PARAM_INT);

        $mform->addElement('date_selector', 'match_date', get_string('match_date', 'local_football_scorecard'));

        $this->add_action_buttons();
    }

    public function validation($data, $files) {
        return [];
    }
}