<?php

namespace Damcclean\Sendinblue;

use Illuminate\Support\Facades\Facade;

class SendinblueFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'sendinblue';
    }
}
