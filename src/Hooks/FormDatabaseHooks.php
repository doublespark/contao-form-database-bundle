<?php

namespace Doublespark\FormDatabase\Hooks;

use Doublespark\FormDatabase\Models\FormDbModel;

class FormDatabaseHooks
{
    /**
     * Process submitted form
     * @param array $arrPost
     * @param array $arrForm
     */
    public function processFormData(array $arrPost, array $arrForm): void
    {
        if(count($arrPost) > 0)
        {
            $objFormSubmission                 = new FormDbModel();
            $objFormSubmission->tstamp         = time();
            $objFormSubmission->submitted_date = time();
            $objFormSubmission->form_data      = json_encode($arrPost);
            $objFormSubmission->form_name      = $arrForm['title'];
            $objFormSubmission->save();
        }
    }
}