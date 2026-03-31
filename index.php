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
 * Painel principal do Boletim ENAMED — grade de módulos.
 *
 * @package     local_boletimenamed
 * @copyright   2026 Lauro Rosas Neto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once(__DIR__ . '/../../config.php');

$context = context_system::instance();

require_login();

// Plugin desativado nas configurações.
if (!get_config('local_boletimenamed', 'enabled')) {
    $url = new moodle_url('/local/boletimenamed/index.php');
    $PAGE->set_context($context);
    $PAGE->set_url($url);
    $PAGE->set_pagelayout('standard');
    $PAGE->set_title(get_string('pluginname', 'local_boletimenamed'));
    $PAGE->set_heading(get_string('pluginname', 'local_boletimenamed'));
    echo $OUTPUT->header();
    echo $OUTPUT->notification(get_string('plugindisabled', 'local_boletimenamed'), 'warning');
    echo $OUTPUT->footer();
    die();
}

// Verifica permissão básica de acesso.
if (!has_capability('local/boletimenamed:view', $context) && !is_siteadmin()) {
    require_capability('local/boletimenamed:view', $context); // dispara erro padrão Moodle.
}

// Estudantes sem papel student em nenhum curso não devem acessar.
$canviewall = has_capability('local/boletimenamed:viewall', $context) || is_siteadmin();

if (!$canviewall) {
    $sql = "SELECT COUNT(ra.id)
              FROM {role_assignments} ra
              JOIN {role} r            ON r.id   = ra.roleid
              JOIN {context} ctx       ON ctx.id  = ra.contextid
             WHERE ra.userid      = :userid
               AND r.shortname    = 'student'
               AND ctx.contextlevel = :courselevel";

    $isstudent = $DB->count_records_sql($sql, [
        'userid'      => $USER->id,
        'courselevel' => CONTEXT_COURSE,
    ]) > 0;

    if (!$isstudent) {
        $url = new moodle_url('/local/boletimenamed/index.php');
        $PAGE->set_context($context);
        $PAGE->set_url($url);
        $PAGE->set_pagelayout('standard');
        $PAGE->set_title(get_string('pluginname', 'local_boletimenamed'));
        $PAGE->set_heading(get_string('pluginname', 'local_boletimenamed'));
        echo $OUTPUT->header();
        echo $OUTPUT->notification(get_string('notenrolled', 'local_boletimenamed'), 'warning');
        echo $OUTPUT->footer();
        die();
    }
}

// -----------------------------------------------------------------------
// Monta a lista de módulos disponíveis.
// Cada entrada: ['key' => string-key, 'icon' => fa-icon, 'url' => moodle_url]
// -----------------------------------------------------------------------
$modules = [
    [
        'title'    => get_string('module_simulado', 'local_boletimenamed'),
        'desc'     => get_string('module_simulado_desc', 'local_boletimenamed'),
        'icon'     => 'fa-file-text',
        'url'      => new moodle_url('/local/boletimenamed/simulado.php'),
        'disabled' => false,
    ],
];

// -----------------------------------------------------------------------
// Renderização da página.
// -----------------------------------------------------------------------
$url   = new moodle_url('/local/boletimenamed/index.php');
$title = get_string('pluginname', 'local_boletimenamed');

$PAGE->set_context($context);
$PAGE->set_url($url);
$PAGE->set_pagelayout('standard');
$PAGE->set_title($title);
$PAGE->set_heading($title);

echo $OUTPUT->header();

echo html_writer::start_div('local-boletimenamed-dashboard');

// Saudação.
echo html_writer::tag(
    'p',
    get_string('dashboardwelcome', 'local_boletimenamed'),
    ['class' => 'lead mb-4']
);

// Grade de cards.
echo html_writer::start_div('row');

foreach ($modules as $mod) {
    $cardclass = 'card h-100 shadow-sm' . ($mod['disabled'] ? ' opacity-50' : '');

    $icon = html_writer::tag('i', '', ['class' => 'fa ' . $mod['icon'] . ' fa-3x mb-3 text-primary', 'aria-hidden' => 'true']);

    if ($mod['disabled']) {
        $btn = html_writer::tag(
            'button',
            get_string('accessmodule', 'local_boletimenamed'),
            ['class' => 'btn btn-secondary', 'disabled' => 'disabled']
        );
    } else {
        $btn = html_writer::link(
            $mod['url'],
            get_string('accessmodule', 'local_boletimenamed'),
            ['class' => 'btn btn-primary stretched-link']
        );
    }

    $cardbody = html_writer::div(
        $icon .
        html_writer::tag('h5', $mod['title'], ['class' => 'card-title']) .
        html_writer::tag('p', $mod['desc'], ['class' => 'card-text text-muted small']) .
        $btn,
        'card-body d-flex flex-column align-items-center text-center'
    );

    $card = html_writer::div(
        html_writer::div($cardbody, $cardclass),
        'col-12 col-sm-6 col-md-4 col-lg-3 mb-4'
    );

    echo $card;
}

echo html_writer::end_div(); // .row
echo html_writer::end_div(); // .local-boletimenamed-dashboard

echo $OUTPUT->footer();
