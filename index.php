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
 * Main page for local_boletimenamed.
 *
 * @package     local_boletimenamed
 * @copyright   2026 Lauro Rosas Neto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

$context = context_system::instance();

require_login();

$url   = new moodle_url('/local/boletimenamed/index.php');
$title = get_string('pluginname', 'local_boletimenamed');

$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');
$PAGE->set_title($title);
$PAGE->set_heading($title);

// -----------------------------------------------------------------------
// Plugin desativado nas configurações.
// -----------------------------------------------------------------------
if (!get_config('local_boletimenamed', 'enabled')) {
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('plugindisabled', 'local_boletimenamed'), 'warning');
    echo $OUTPUT->footer();
    die();
}

$canviewall = has_capability('local/boletimenamed:viewall', $context);
$canview    = has_capability('local/boletimenamed:view', $context);

// -----------------------------------------------------------------------
// Gestores / Administradores — podem consultar qualquer estudante por RA.
// -----------------------------------------------------------------------
if ($canviewall || is_siteadmin()) {
    $ra          = optional_param('ra', '', PARAM_TEXT);
    $ra          = trim($ra);
    $targetuser  = null;
    $notfound    = false;

    if ($ra !== '') {
        $targetuser = $DB->get_record('user', ['idnumber' => $ra, 'deleted' => 0]);
        if (!$targetuser) {
            $notfound = true;
        }
    }

    echo $OUTPUT->header();
    echo $OUTPUT->heading($title);

    // Formulário de busca por RA.
    $searchform  = html_writer::start_tag('form', ['method' => 'get', 'action' => $url, 'class' => 'mb-3']);
    $searchform .= html_writer::start_div('input-group');
    $searchform .= html_writer::label(
        get_string('ra', 'local_boletimenamed'),
        'ra',
        true,
        ['class' => 'input-group-text']
    );
    $searchform .= html_writer::empty_tag('input', [
        'type'        => 'text',
        'id'          => 'ra',
        'name'        => 'ra',
        'value'       => s($ra),
        'class'       => 'form-control',
        'placeholder' => get_string('ra', 'local_boletimenamed'),
        'autocomplete'=> 'off',
    ]);
    $searchform .= html_writer::tag(
        'button',
        get_string('search', 'local_boletimenamed'),
        ['type' => 'submit', 'class' => 'btn btn-primary']
    );
    $searchform .= html_writer::end_div();
    $searchform .= html_writer::end_tag('form');

    echo $searchform;

    if ($notfound) {
        echo $OUTPUT->notification(
            get_string('nouserfound', 'local_boletimenamed', s($ra)),
            'warning'
        );
    } elseif ($targetuser !== null) {
        echo $OUTPUT->notification(
            get_string('userfound', 'local_boletimenamed', fullname($targetuser) . ' (RA: ' . s($targetuser->idnumber) . ')'),
            'success'
        );
        // TODO: Etapas futuras — renderizar o dashboard do $targetuser aqui.
        echo html_writer::div(get_string('welcomemessage', 'local_boletimenamed'), 'alert alert-info');
    } else {
        echo html_writer::div(get_string('selectuserprompt', 'local_boletimenamed'), 'alert alert-secondary');
    }

    echo $OUTPUT->footer();
    die();
}

// -----------------------------------------------------------------------
// Estudantes — acesso permitido apenas se matriculado em algum curso.
// -----------------------------------------------------------------------
if ($canview) {
    // Verifica se o usuário possui papel de estudante em algum curso ativo.
    $sql = "SELECT COUNT(ra.id)
              FROM {role_assignments} ra
              JOIN {role} r ON r.id = ra.roleid
              JOIN {context} ctx ON ctx.id = ra.contextid
             WHERE ra.userid = :userid
               AND r.shortname = 'student'
               AND ctx.contextlevel = :courselevel";

    $isstudent = $DB->count_records_sql($sql, [
        'userid'      => $USER->id,
        'courselevel' => CONTEXT_COURSE,
    ]) > 0;

    echo $OUTPUT->header();
    echo $OUTPUT->heading($title);

    if (!$isstudent) {
        echo $OUTPUT->notification(get_string('notenrolled', 'local_boletimenamed'), 'warning');
    } else {
        echo html_writer::div(get_string('welcomemessage', 'local_boletimenamed'), 'alert alert-info');
        // TODO: Etapas futuras — renderizar o dashboard do $USER aqui.
    }

    echo $OUTPUT->footer();
    die();
}

// -----------------------------------------------------------------------
// Sem permissão.
// -----------------------------------------------------------------------
require_capability('local/boletimenamed:view', $context);
