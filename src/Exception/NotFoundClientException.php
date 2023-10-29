<?php

namespace Renato\Comex\Exception;

use Exception;

class NotFoundClientException extends Exception {
    public function __construct() {
        parent::__construct("Cliente não encontrado.");
    }
}

?>