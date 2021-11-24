<?php if (!defined('TL_ROOT')) die('You can not access this file directly!');

/**
 * Backend modules
 */
$GLOBALS['BE_MOD']['system']['form_submissions'] = [
    'tables' => ['tl_form_db']
];

/**
 * Hooks
 */
$GLOBALS['TL_HOOKS']['processFormData'][] = ['Doublespark\FormDatabase\Hooks\FormDatabaseHooks', 'processFormData'];