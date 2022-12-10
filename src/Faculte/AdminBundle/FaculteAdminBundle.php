<?php

namespace Faculte\AdminBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class FaculteAdminBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }

}
