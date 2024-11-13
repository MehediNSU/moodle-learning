<?php
require_once('../../config.php');
require_login();

$context = context_system::instance();
require_capability('local/football_scorecard:view', $context);

$PAGE->set_url('/local/football_scorecard/index.php');
$PAGE->set_context($context);
$PAGE->set_title(get_string('player_list', 'local_football_scorecard'));

echo $OUTPUT->header();
echo $OUTPUT->heading(get_string('player_list', 'local_football_scorecard'));

// Query to get player data
$players = $DB->get_records('football_scorecard_players');

// Define the table and add an "Edit" column header
$table = new html_table();
$table->head = [
    get_string('player_name', 'local_football_scorecard'), 
    get_string('goal_count', 'local_football_scorecard'), 
    get_string('match_date', 'local_football_scorecard'),
    get_string('edit', 'local_football_scorecard')
];

// Populate the table with player data and an "Edit" link for each player
foreach ($players as $player) {
    $date = userdate($player->match_date);
    $editlink = html_writer::link(
        new moodle_url('/local/football_scorecard/edit.php', array('id' => $player->id)),
        get_string('edit', 'local_football_scorecard')
    );
    $table->data[] = [$player->player_name, $player->goal_count, $date, $editlink];
}

echo html_writer::table($table);
echo $OUTPUT->footer();