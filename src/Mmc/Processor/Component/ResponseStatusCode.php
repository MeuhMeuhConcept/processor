<?php

namespace Mmc\Processor\Component;

use Greg0ire\Enum\AbstractEnum;

class ResponseStatusCode extends AbstractEnum
{
    const OK = 200;
    const INTERNAL_ERROR = 500;
    const NOT_IMPLEMENTED = 501;
    const NOT_SUPPORTED = 505;
}
