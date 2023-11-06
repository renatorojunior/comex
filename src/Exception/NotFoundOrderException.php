<?php

namespace Renato\Comex\Exception;

use Exception;

// Desenvolvendo Classe NotFoundOrderException
class NotFoundOrderException extends Exception {
    public function __construct() {
        parent::__construct("Pedido não encontrado.");
    }
}

?>