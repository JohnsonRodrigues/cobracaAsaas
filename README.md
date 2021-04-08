# Cobraça Asaas

SDK não-oficial de integração á API do serviço www.asaas.com

[comment]: <> ([![Maintainer]&#40;http://img.shields.io/badge/maintainer-@codephix-blue.svg?style=flat-square&#41;]&#40;https://twitter.com/codephix&#41;)

[comment]: <> ([![Source Code]&#40;https://img.shields.io/badge/source-codephix/asaas--sdk-blue.svg?style=flat-square&#41;]&#40;https://github.com/codephix/asaas-sdk&#41;)

[comment]: <> ([![PHP from Packagist]&#40;https://img.shields.io/packagist/php-v/codephix/asaas-sdk.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/codephix/asaas-sdk&#41;)

[comment]: <> ([![Latest Version]&#40;https://img.shields.io/github/release/codephix/asaas-sdk.svg?style=flat-square&#41;]&#40;https://github.com/codephix/asaas-sdk/releases&#41;)

[comment]: <> ([![Software License]&#40;https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square&#41;]&#40;LICENSE&#41;)

[comment]: <> ([![Build]&#40;https://img.shields.io/scrutinizer/build/g/codephix/asaas-sdk.svg?style=flat-square&#41;]&#40;https://scrutinizer-ci.com/g/codephix/asaas-sdk&#41;)

[comment]: <> ([![Quality Score]&#40;https://img.shields.io/scrutinizer/g/codephix/asaas-sdk.svg?style=flat-square&#41;]&#40;https://scrutinizer-ci.com/g/codephix/asaas-sdk&#41;)

[comment]: <> ([![Total Downloads]&#40;https://img.shields.io/packagist/dt/codephix/asaas-sdk.svg?style=flat-square&#41;]&#40;https://packagist.org/packages/codephix/asaas-sdk&#41;)


### Projeto em andamento


## Installation

```bash
composer require cobranca/asaas
```

Exemplo
-------

```php
<?php

require 'vendor/autoload.php';

use Cobranca\Asaas;

// Instancie o cliente Asaas usando a instância do adapter previamente criada.
$asaas = new Asaas('seu_token_de_acesso');
```

Endpoint
--------

Caso queira usar a API em modo teste basta especificar o `ambiente` no momento em que o cliente é instanciado.

```php
// Obs.: Caso não seja informado o segundo parâmetro a API entra em modo de produção
$asaas = new Asaas('seu_token_de_acesso', 'producao|homologacao');
```


Clientes
--------

```php
// Retorna a listagem de clientes
$clientes = $asaas->cliente->getAll(array $filtros);

// Retorna os dados do cliente de acordo com o Id
$cobranca = $asaas->cliente->getById(123);

// Retorna os dados do cliente de acordo com o Email
$clientes = $asaas->cliente->getByEmail('email@mail.com');

// Insere um novo cliente
$clientes = $asaas->cliente->create(array $dadosCliente);

// Atualiza os dados do cliente
$clientes = $asaas->cliente->update(123, array $dadosCliente);

// Restaura um cliente
$asaas->cliente->restaura(123);

// Deleta uma cliente
$asaas->cliente->delete(123);
```


Cobranças
------------

```php
// Retorna a listagem de cobranças
$cobrancas = $asaas->cobranca->getAll(array $filtros);

// Retorna os dados da cobrança de acordo com o Id
$cobranca = $asaas->cobranca->getById(123);

// Retorna a listagem de cobranças de acordo com o Id do Cliente
$cobrancas = $asaas->cobranca->getByCustomer($customer_id);

// Retorna a listagem de cobranças de acordo com o Id da Assinaturas
$cobrancas = $asaas->cobranca->getBySubscription($subscription_id);

// Insere uma nova cobrança
$cobranca = $asaas->cobranca->create(array $dadosCobranca);

// Insere uma nova cobrança parcelada
$cobranca = $asaas->cobranca->parcelada(array $dadosCobranca);

// Insere uma nova cobrança com split 
/* Saldo dividido em multiplas contas do Asaas*/
$cobranca = $asaas->cobranca->parcelada(array $dadosCobranca);

// Atualiza os dados da cobrança
$cobranca = $asaas->cobranca->update(123, array $dadosCobranca);

// Restaura cobrança removida
$cobranca = $asaas->cobranca->restore(id);

// Estorna cobrança
$cobranca = $asaas->cobranca->estorno(id);

// Confirmação em dinheiro
$cobranca = $asaas->cobranca->confirmacao(id);

// Deleta uma cobrança
$asaas->cobranca->delete(123);
```


Assinaturas
------------

```php



Os status possíveis de uma cobrança são os seguintes:

[PENDING] - Aguardando pagamento

[RECEIVED] - Recebida (saldo já creditado na conta)

[CONFIRMED] - Pagamento confirmado (saldo ainda não creditado)

[OVERDUE] - Vencida

[REFUNDED] - Estornada

[RECEIVED_IN_CASH] - Recebida em dinheiro (não gera saldo na conta)

[REFUND_REQUESTED] - Estorno Solicitado

[CHARGEBACK_REQUESTED] - Recebido chargeback

[CHARGEBACK_DISPUTE] - Em disputa de chargeback (caso sejam apresentados documentos para contestação)

[AWAITING_CHARGEBACK_REVERSAL] - Disputa vencida, aguardando repasse da adquirente

[DUNNING_REQUESTED] - Em processo de recuperação

[DUNNING_RECEIVED] - Recuperada

[AWAITING_RISK_ANALYSIS] - Pagamento em análise


// Retorna a listagem de assinaturas
$assinaturas = $asaas->assinatura->getAll(array $filtros);

// Retorna os dados da assinatura de acordo com o Id
$assinatura = $asaas->assinatura->getById(123);

// Retorna a listagem de assinaturas de acordo com o Id do Cliente
$assinaturas = $asaas->assinatura->getByCustomer($customer_id);

// Insere uma nova assinatura

/*

Assinatura via Boleto

$dadosAssinatura = array(
  "customer" => "{CUSTOMER_ID}",
  "billingType" => "BOLETO",
  "nextDueDate" => "2017-05-15",
  "value" => 19.9,
  "cycle" => "MONTHLY",
  "description" => "Assinatura Plano Pró",
  "discount" => array(
    "value" => 10,
    "dueDateLimitDays" => 0
  ),
  "fine" => array(
    "value": 1
  ),
  "interest" => array(
    "value": 2
  )
);


Assinatura via cartão de credito


$dadosAssinatura = array(
  "customer" => "{CUSTOMER_ID}",
  "billingType" => "CREDIT_CARD",
  "nextDueDate" => "2017-05-15",
  "value" => 19.9,
  "cycle" => "MONTHLY",
  "description" => "Assinatura Plano Pró",
  "creditCard" => array(
    "holderName" => "marcelo h almeida",
    "number" => "5162306219378829",
    "expiryMonth" => "05",
    "expiryYear" => "2021",
    "ccv" => "318"
  ),
  "creditCardHolderInfo" => array(
    "name" => "Marcelo Henrique Almeida",
    "email" => "marcelo.almeida@gmail.com",
    "cpfCnpj" => "24971563792",
    "postalCode" => "89223-005",
    "addressNumber" => "277",
    "addressComplement" => null,
    "phone" => "4738010919",
    "mobilePhone" => "47998781877"
  )
);

*/

$assinatura = $asaas->assinatura->create(array $dadosAssinatura);

// Atualiza os dados da assinatura
$assinatura = $asaas->assinatura->update(123, array $dadosAssinatura);

Listar notas fiscais das cobranças de uma assinatura

/*

$parametos = array(
'offset' => '',
'limit' => '',
'status' => '',

*/

$assinatura = $asaas->assinatura->getNotaFiscal($id, array $parametos);

// Deleta uma assinatura
$asaas->assinatura->delete(123);
```


Notificações
------------

```php
// Retorna a listagem de notificações
$notificacoes = $asaas->notificacao->getAll(array $filtros);

// Retorna os dados da notificação de acordo com o Id
$notificacao = $asaas->notificacao->getById(123);

// Retorna a listagem de notificações de acordo com o Id do Cliente
$notificacoes = $asaas->notificacao->getByCustomer($customer_id);

// Insere uma nova notificação
$notificacao = $asaas->notificacao->create(array $dadosNotificacao);

// Atualiza os dados da notificação
$notificacao = $asaas->notificacao->update(123, array $dadosNotificacao);

// Deleta uma notificação
$asaas->notificacao->delete(123);
```

Documentação Oficial
--------------------

Obs.: Esta é uma API não oficial. Foi feita com base na documentação disponibilizada [neste link](https://asaasv3.docs.apiary.io/).


