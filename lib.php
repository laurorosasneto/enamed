<?php
// This file is part of Moodle - https://moodle.org/
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
// along with Moodle.  If not, see <https://www.gnu.org/licenses/>.

/**
 * Plugin callbacks for local_boletimenamed.
 *
 * @package     local_boletimenamed
 * @copyright   2026 Lauro Rosas Neto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

/**
 * Add the plugin page to the global navigation when enabled.
 *
 * @param global_navigation $navigation Global navigation instance.
 * @return void
 */
function local_boletimenamed_extend_navigation(global_navigation $navigation): void {
    if (!get_config('local_boletimenamed', 'showinnavigation')) {
        return;
    }

    $context = context_system::instance();
    if (!has_capability('local/boletimenamed:view', $context)) {
        return;
    }

    $url = new moodle_url('/local/boletimenamed/index.php');
    $navigation->add(
        get_string('pluginname', 'local_boletimenamed'),
        $url,
        navigation_node::TYPE_CUSTOM,
        null,
        'local_boletimenamed'
    );
}
