<?php

namespace Vor\StoreBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class VorStoreBundle extends Bundle
{
    public function getParent()
    {
        return 'MsiStoreBundle';
    }
}
