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
 * Admin settings for local_boletimenamed.
 *
 * @package     local_boletimenamed
 * @category    admin
 * @copyright   2026 Lauro Rosas Neto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

if ($hassiteconfig) {
    $ADMIN->add(
        'localplugins',
        new admin_category(
            'local_boletimenamed_category',
            new lang_string('pluginname', 'local_boletimenamed')
        )
    );

    $ADMIN->add(
        'local_boletimenamed_category',
        new admin_externalpage(
            'local_boletimenamed_manage',
            new lang_string('manageplugin', 'local_boletimenamed'),
            new moodle_url('/local/boletimenamed/index.php'),
            'local/boletimenamed:view'
        )
    );

    $settingspage = new admin_settingpage(
        'local_boletimenamed_settings',
        new lang_string('settings', 'local_boletimenamed')
    );

    if ($ADMIN->fulltree) {
        $settingspage->add(new admin_setting_configcheckbox(
            'local_boletimenamed/showinnavigation',
            new lang_string('showinnavigation', 'local_boletimenamed'),
            new lang_string('showinnavigation_desc', 'local_boletimenamed'),
            1
        ));
    }

    $ADMIN->add('local_boletimenamed_category', $settingspage);
}
