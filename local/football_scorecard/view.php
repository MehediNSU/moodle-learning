<?php
require_once(__DIR__ . '/../../config.php');
require_once($CFG->dirroot . '/local/football_scorecard/classes/form/player_form.php');

require_login();

$context = context_system::instance();
$PAGE->set_context($context);
$PAGE->set_url('/local/football_scorecard/view.php');
$PAGE->set_title('Football Scorecard');
// $PAGE->set_heading('Football Scorecard');

// Instantiate the form
$mform = new \local_football_scorecard\form\player_form();

// Check if form was submitted and validated
if ($mform->is_submitted() && $mform->is_validated()) {
    $data = $mform->get_data();

    // Prepare the record to insert
    $record = new stdClass();
    $record->player_name = $data->player_name;
    $record->goal_count = $data->goal_count;
    $record->match_date = $data->match_date;

    // Insert the record into the custom table
    $DB->insert_record('football_scorecard_players', $record);

    // Redirect after successful submission
    redirect($PAGE->url, 'Data submitted successfully!', 2);
}

// Display the page and form
echo $OUTPUT->header();
echo '<h2>Football Scorecard</h2>';
$mform->display(); // Display the form
echo $OUTPUT->footer();