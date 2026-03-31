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
 * Módulo: Boletim por Simulado.
 *
 * @package     local_boletimenamed
 * @copyright   2026 Lauro Rosas Neto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

$context = context_system::instance();

require_login();

// Plugin desativado.
if (!get_config('local_boletimenamed', 'enabled')) {
    redirect(
        new moodle_url('/local/boletimenamed/index.php'),
        get_string('plugindisabled', 'local_boletimenamed'),
        null,
        \core\output\notification::NOTIFY_WARNING
    );
}

// Permissão básica.
if (!has_capability('local/boletimenamed:view', $context) && !is_siteadmin()) {
    require_capability('local/boletimenamed:view', $context);
}

$canviewall = has_capability('local/boletimenamed:viewall', $context) || is_siteadmin();

// Estudantes sem matrícula ativa não devem acessar.
if (!$canviewall) {
    $sql = "SELECT COUNT(ra.id)
              FROM {role_assignments} ra
              JOIN {role} r      ON r.id    = ra.roleid
              JOIN {context} ctx ON ctx.id  = ra.contextid
             WHERE ra.userid       = :userid
               AND r.shortname     = 'student'
               AND ctx.contextlevel = :courselevel";

    $isstudent = $DB->count_records_sql($sql, [
        'userid'      => $USER->id,
        'courselevel' => CONTEXT_COURSE,
    ]) > 0;

    if (!$isstudent) {
        redirect(
            new moodle_url('/local/boletimenamed/index.php'),
            get_string('notenrolled', 'local_boletimenamed'),
            null,
            \core\output\notification::NOTIFY_WARNING
        );
    }
}

// -----------------------------------------------------------------------
// Resolve o usuário alvo.
// -----------------------------------------------------------------------
$ra         = optional_param('ra', '', PARAM_TEXT);
$ra         = trim($ra);
$targetuser = null;
$notfound   = false;

if ($canviewall) {
    // Gestor/admin: filtra pelo RA informado.
    if ($ra !== '') {
        $targetuser = $DB->get_record('user', ['idnumber' => $ra, 'deleted' => 0]);
        if (!$targetuser) {
            $notfound = true;
        }
    }
} else {
    // Estudante: sempre filtra pelo próprio usuário.
    $targetuser = $USER;
}

// -----------------------------------------------------------------------
// Renderização.
// -----------------------------------------------------------------------
$dashboardurl = new moodle_url('/local/boletimenamed/index.php');
$url          = new moodle_url('/local/boletimenamed/simulado.php');
$moduletitle  = get_string('module_simulado', 'local_boletimenamed');
$plugintitle  = get_string('pluginname', 'local_boletimenamed');

$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');
$PAGE->set_title($plugintitle . ' — ' . $moduletitle);
$PAGE->set_heading($plugintitle);

// Breadcrumb.
$PAGE->navbar->add($plugintitle, $dashboardurl);
$PAGE->navbar->add($moduletitle);

echo $OUTPUT->header();

echo html_writer::tag('h2', $moduletitle, ['class' => 'mb-4']);

// -----------------------------------------------------------------------
// Filtro por RA — exibido apenas para gestores/admins.
// -----------------------------------------------------------------------
if ($canviewall) {
    $clearurl = clone $url;

    echo html_writer::start_tag('form', ['method' => 'get', 'action' => $url, 'class' => 'mb-4']);
    echo html_writer::start_div('input-group');
    echo html_writer::label(
        get_string('ra', 'local_boletimenamed'),
        'ra',
        true,
        ['class' => 'input-group-text']
    );
    echo html_writer::empty_tag('input', [
        'type'         => 'text',
        'id'           => 'ra',
        'name'         => 'ra',
        'value'        => s($ra),
        'class'        => 'form-control',
        'placeholder'  => get_string('ra', 'local_boletimenamed'),
        'autocomplete' => 'off',
    ]);
    echo html_writer::tag(
        'button',
        get_string('search', 'local_boletimenamed'),
        ['type' => 'submit', 'class' => 'btn btn-primary']
    );
    if ($ra !== '') {
        echo html_writer::link(
            $url,
            get_string('clearfilter', 'local_boletimenamed'),
            ['class' => 'btn btn-outline-secondary']
        );
    }
    echo html_writer::end_div(); // .input-group
    echo html_writer::end_tag('form');

    if ($notfound) {
        echo $OUTPUT->notification(
            get_string('nouserfound', 'local_boletimenamed', s($ra)),
            'warning'
        );
    } elseif ($targetuser === null) {
        echo html_writer::div(
            get_string('selectuserprompt', 'local_boletimenamed'),
            'alert alert-secondary'
        );
    }
}

// -----------------------------------------------------------------------
// Conteúdo do módulo — exibido quando há usuário alvo definido.
// -----------------------------------------------------------------------
if ($targetuser !== null) {
    if ($canviewall) {
        echo $OUTPUT->notification(
            get_string('userfound', 'local_boletimenamed',
                fullname($targetuser) . ' — RA: ' . s($targetuser->idnumber)),
            'info'
        );
    }

    // TODO: renderizar gráficos e tabelas de desempenho por simulado para $targetuser.
    echo html_writer::div(
        html_writer::tag('p', '🚧 Conteúdo do módulo em desenvolvimento.', ['class' => 'mb-0']),
        'alert alert-info'
    );
}

echo $OUTPUT->footer();
