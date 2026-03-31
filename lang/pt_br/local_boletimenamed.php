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
 * Strings em português (Brasil) para local_boletimenamed.
 *
 * @package     local_boletimenamed
 * @category    string
 * @copyright   2026 Lauro Rosas Neto
 * @license     https://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

defined('MOODLE_INTERNAL') || die();

// Geral.
$string['pluginname']            = 'Boletim ENAMED';
$string['manageplugin']          = 'Gerenciar Boletim ENAMED';
$string['settings']              = 'Configurações';
$string['plugindescription']     = 'Boletim ENAMED — acompanhamento de rendimento com gráficos e insights.';
$string['plugindisabled']        = 'O Boletim ENAMED está desativado no momento.';
$string['notenrolled']           = 'Você não está matriculado como estudante em nenhum curso.';
$string['accessdenied']          = 'Você não tem permissão para acessar este recurso.';

// Configurações admin.
$string['enabled']               = 'Ativar plugin';
$string['enabled_desc']          = 'Quando desativado, a página do plugin fica inacessível para todos os usuários.';
$string['showinnavigation']      = 'Exibir plugin na navegação';
$string['showinnavigation_desc'] = 'Exibe um atalho para o plugin no menu de navegação do Moodle.';

// Painel inicial — cards de módulos.
$string['dashboard']             = 'Painel';
$string['dashboardwelcome']      = 'Bem-vindo ao Boletim ENAMED. Selecione um módulo para começar.';
$string['accessmodule']          = 'Acessar';

// Módulo: Boletim por Simulado.
$string['module_simulado']       = 'Boletim por Simulado';
$string['module_simulado_desc']  = 'Visualize e compare o desempenho do estudante em cada simulado realizado.';

// Filtro por RA (usado dentro dos módulos).
$string['filterbyra']            = 'Filtrar por RA';
$string['ra']                    = 'RA (Registro Acadêmico)';
$string['ra_help']               = 'Informe o RA do estudante para visualizar o boletim.';
$string['search']                = 'Buscar';
$string['clearfilter']           = 'Limpar filtro';
$string['userfound']             = 'Exibindo resultado de: {$a}';
$string['nouserfound']           = 'Nenhum estudante encontrado com o RA "{$a}".';
$string['selectuserprompt']      = 'Informe o RA de um estudante acima para carregar o boletim.';

// Privacidade.
$string['privacy:metadata']      = 'O plugin local_boletimenamed não armazena dados pessoais.';
