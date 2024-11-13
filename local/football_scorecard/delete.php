<?php
require_once('../../config.php');
require_login();

$id = required_param('id', PARAM_INT); // Player ID

// Check permissions
$context = context_system::instance();
require_capability('local/football_scorecard:manage', $context);

// Ensure the player exists
if (!$DB->record_exists('football_scorecard_players', array('id' => $id))) {
    print_error('Player not found');
}

// Delete the player
$DB->delete_records('football_scorecard_players', array('id' => $id));

// Redirect back to the player list with a success message
redirect(new moodle_url('/local/football_scorecard/index.php'), get_string('player_deleted', 'local_football_scorecard'));