<?php

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