<?php

namespace Vor\SearchBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class VorSearchBundle extends Bundle
{
    public function getParent()
    {
        return 'MsiSearchBundle';
    }
}
