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
    'host' => 'yourhost',
    'username' => 'user',
    'password' => 'pass',
    'smtpSecure' => 'tls',
    'host' => 'mail.brunobarros.com',
    'username' => 'bruno@brunobarros.com',
    'password' => 'bb020476',
    'smtpSecure' => '',
    
    /**
     * Dados de autenticação para debug
     */
    'hostDebug' => 'yourhost',
    'usernameDebug' => 'user',
    'passwordDebug' => 'pass',
    'smtpSecureDebug' => 'tls',
    
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
    'bccEmail' => ''
);