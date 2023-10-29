<?php

namespace Renato\Comex\Exception;

use Exception;

// Desenvolvendo Classe NotFoundProductException
class NotFoundProductException extends Exception {
    public function __construct() {
        parent::__construct("Produto não encontrado.");
    }
}

?>