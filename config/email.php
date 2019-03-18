<?php

/**
 * Dados de configuração do envio de email
 * 
 * @package OOWPtheme
 * @subpackage config
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
return array(
    /**
     * Dados de autenticação
     */
    'smtpHost' => 'smtp.omb.org.br',
    'username' => 'autentica@omb.org.br',
    'password' => 'autentica1omb',
    'smtpSecure' => 'autentica@omb.org.br',
    'smtpPort' => 587,
    
    /**
     * Dados do destinatário
     */
    'toEmail' => 'omb@omb.org.br',
    'toName' => 'OMB',
    /**
     * Dados do rementente
     */
    'fromEmail' => 'omb@omb.org.br',
    'fromName' => 'OMB',
    'bccEmail' => '',
    
    /**
     * Dados de autenticação para debug
     * Sobrepõe dados de autenticação padrão
     */
    'sendToDebug' => false,
    'smtpHostDebug' => 'debug',
    'usernameDebug' => '',
    'passwordDebug' => '',
    'smtpSecureDebug' => 'tls',
    'smtpPortDebug' => 587,
);