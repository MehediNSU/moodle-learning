<?php
require_once('../../config.php');
require_once('classes/form/player_form.php');

global $DB;

// Get the player ID from the URL parameter.
$playerid = required_param('id', PARAM_INT);

// Set up the URL for the page.
$PAGE->set_url(new moodle_url('/local/football_scorecard/edit.php', array('id' => $playerid)));
$PAGE->set_context(context_system::instance());
$PAGE->set_title('Edit Player');
// $PAGE->set_heading('Edit Player');

// Fetch player data from the database.
$player = $DB->get_record('football_scorecard_players', array('id' => $playerid), '*', MUST_EXIST);

// Instantiate the form and pass the player data.
$mform = new \local_football_scorecard\form\player_form(null, array('playerid' => $playerid));

// If form is submitted and validated, update the record in the database.
if ($mform->is_cancelled()) {
    // If the form is cancelled, redirect to the main page.
    redirect(new moodle_url('/local/football_scorecard/view.php'));
} elseif ($data = $mform->get_data()) {
    // Update the record in the database.
    $record = new stdClass();
    $record->id = $playerid;
    $record->player_name = $data->player_name;
    $record->goal_count = $data->goal_count;
    $record->match_date = $data->match_date;

    // Update the record in the database.
    $DB->update_record('football_scorecard_players', $record);

    // Redirect back to the main view page.
    redirect(new moodle_url('/local/football_scorecard/index.php'), 'Data updated successfully!', 2);
}

// Set initial form data from the player data.
$mform->set_data($player);

// Output the page.
echo $OUTPUT->header();
echo $OUTPUT->heading('Edit Player');
$mform->display();
echo $OUTPUT->footer();