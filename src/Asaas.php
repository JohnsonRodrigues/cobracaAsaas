<?php

namespace Cobranca\Asaas;

use Cobranca\Asaas\Assinatura;
use Cobranca\Asaas\Cliente;
use Cobranca\Asaas\Cobranca;
use Cobranca\Asaas\Notificacao;
use Cobranca\Asaas\Transferencia;
use Cobranca\Asaas\Webhook;

class Asaas {
    
    public $cidade;
    public $assinatura;
    public $cliente;
    public $cobranca;
    public $notificacao;
    public $transferencia;
    public $webhook;
    
    public function __construct($token, $status = false) {
        $connection = new Connection($token, ((!empty($status)) ? $status : 'producao'));

        $this->assinatura  = new Assinatura($connection);
        $this->cidade      = new Cidades($connection);
        $this->cliente     = new Cliente($connection);
        $this->cobranca    = new Cobranca($connection);
        $this->notificacao = new Notificacao($connection);
        $this->transferencia = new Transferencia($connection);
        $this->webhook     = new Webhook($connection);
    }
}
