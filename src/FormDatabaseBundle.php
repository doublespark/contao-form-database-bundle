<?php

/***
 * FormDatabase bundle
 */
namespace Doublespark\FormDatabase;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Class FormDatabaseBundle
 *
 * @package FormDatabase
 */
class FormDatabaseBundle extends Bundle
{
    public function getPath(): string
    {
        return \dirname(__DIR__);
    }
}
