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
    'smtpHost' => '',
    'username' => 'user',
    'password' => 'pass',
    'smtpSecure' => 'tls',
    'smtpPort' => 587,
    
    /**
     * Dados do destinatário
     */
    'toEmail' => 'brunodanca@gmail.com',
    'toName' => 'Bruno',
    /**
     * Dados do rementente
     */
    'fromEmail' => 'brunodanca@gmail.com',
    'fromName' => 'Site Bruno',
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