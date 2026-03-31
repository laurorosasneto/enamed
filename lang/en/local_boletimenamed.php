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
 * English language strings for local_boletimenamed.
 *
 * @package     local_boletimenamed
 * @category    string
 * @copyright   2026 Lauro Rosas Neto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// General.
$string['pluginname']            = 'Boletim ENAMED';
$string['manageplugin']          = 'Manage Boletim ENAMED';
$string['settings']              = 'Settings';
$string['plugindescription']     = 'ENAMED report — student performance tracking with charts and insights.';
$string['plugindisabled']        = 'The Boletim ENAMED plugin is currently disabled.';
$string['notenrolled']           = 'You are not enrolled as a student in any course.';
$string['accessdenied']          = 'You do not have permission to access this resource.';

// Admin settings.
$string['enabled']               = 'Enable plugin';
$string['enabled_desc']          = 'When disabled the plugin page is inaccessible to all users.';
$string['showinnavigation']      = 'Show plugin in navigation';
$string['showinnavigation_desc'] = 'Displays a shortcut to the plugin page in Moodle navigation.';

// Dashboard — module cards.
$string['dashboard']             = 'Dashboard';
$string['dashboardwelcome']      = 'Welcome to Boletim ENAMED. Select a module to get started.';
$string['accessmodule']          = 'Open';

// Module: Boletim por Simulado.
$string['module_simulado']       = 'Report by Mock Exam';
$string['module_simulado_desc']  = 'View and compare student performance across each mock exam taken.';

// RA filter (used inside modules).
$string['filterbyra']            = 'Filter by RA';
$string['ra']                    = 'RA (Student ID)';
$string['ra_help']               = 'Enter the student RA (idnumber) to view their report.';
$string['search']                = 'Search';
$string['clearfilter']           = 'Clear filter';
$string['userfound']             = 'Showing results for: {$a}';
$string['nouserfound']           = 'No student found with RA "{$a}".';
$string['selectuserprompt']      = 'Enter a student RA above to load their report.';

// Privacy.
$string['privacy:metadata']      = 'The local_boletimenamed plugin does not store personal data.';
