<?php

/**
 * Classe responsável pelo envio de emails
 * * Dependências:
 * - libraries/PHPMailer
 * - libraires/Validation
 * <code>
 * </code>
 * 
 * @package OOWPtheme
 * @subpackage libraries
 * @author Bruno Barros  <bruno@brunobarros.com>
 * @copyright   Copyright (c) 2013 Bruno Barros
 * 
 */
// path do template
if (!defined('TEMPLATEPATH'))
{
    $thisDir = dirname(realpath(__FILE__));
    define('TEMPLATEPATH', str_replace('\libraries', '', $thisDir));
}
if (!defined('ENVIROMENT'))
{
    define('ENVIROMENT', '');
}
require_once TEMPLATEPATH . '/core/WpThemeStart.php';

class Wmail {

    public $smtpAuth = false; // Enable SMTP authentication
    public $smtpHost = 'smtp1.example.com;smtp2.example.com';
    public $username = ''; // SMTP username
    public $password = ''; // SMTP password
    public $smtpSecure = 'tls';
    public $smtpPort = 587;
    public $defaults = array();
    private $phpMailer = null;
    public $subject = '';
    public $error = false;
    public $template = '';
    public $templateVars = null;
    public $body = '';
    public $urlOrigin = '';
    public $respondTo = array();
    public $debug = false;
    public $validation = null;

    public function __construct()
    {
        require_once TEMPLATEPATH . '/libraries/phpmailer/extras/class.html2text.php';
        require_once TEMPLATEPATH . '/libraries/phpmailer/class.phpmailer.php';
        $this->validation = new Validation();
        $this->phpMailer = new PHPMailer();
        $this->phpMailer->SetLanguage('br');
        $this->defaults = $this->loadConfig();
        $this->setAuthParams($this->defaults);
        if (isset($_GET['p']))
        {
            $this->urlOrigin = trim($_GET['p'], '/');
        }
    }
    
    /**
     * Limpa array da sessão com erros de validação
     */
    public function clearSession()
    {
        $_SESSION['oowpvalidationerrors'] = null;
        unset($_SESSION['oowpvalidationerrors']);
    }

    /**
     * Instancia parâmetros de autenticação
     * @param array $authParams
     */
    public function setAuthParams($authParams = array())
    {
        if (empty($authParams) || $authParams['smtpHost'] == '')
        {
            $this->smtpAuth = false;
        }
        else
        {
            $this->smtpAuth = true;
            $this->smtpHost = $authParams['smtpHost'];
            $this->username = $authParams['username'];
            $this->password = $authParams['password'];
            $this->smtpSecure = $authParams['smtpSecure'];
            $this->smtpPort = $authParams['smtpPort'];
        }
    }

    /**
     * Retorna configurações de autenticação
     * @return array
     */
    public function getAuthParams()
    {
        return array(
            'smtpAuth' => $this->smtpAuth,
            'smtpHost' => $this->smtpHost,
            'username' => $this->username,
            'password' => $this->password,
            'smtpSecure' => $this->smtpSecure,
            'smtpPort' => $this->smtpPort
        );
    }

    /**
     * Ao fazer testes chame este método antes do send() para exibir o email
     * montado e interromper o envio.
     */
    public function debugModeOn()
    {
        $this->debug = true;
    }

    public function printDebug()
    {
        echo $this->renderBody();
        echo '<pre>';
        print_r($this->getAuthParams());
        exit;
    }

    /**
     * Dados do usuário que receberá a resposta
     * @param string $email
     * @param string $name
     * @return array
     */
    public function respondTo($email = '', $name = '')
    {
        $this->respondTo = array(
            'email' => $email,
            'name' => $name
        );
    }

    /**
     * Carrega configurações do arquivo 'config/email.php'
     * @return array|boolean
     */
    public function loadConfig()
    {
        if (file_exists(TEMPLATEPATH . '/config/email.php'))
        {
            return require TEMPLATEPATH . '/config/email.php';
        }

        return false;
    }

    /**
     * Carrega template de email dentro da pasta 'templates'
     * @param string $template
     */
    public function setTemplate($templateView = '')
    {
        $this->template = $templateView;
    }

    /**
     * Prepara as variáveis usadas no template.
     * Se não for passado um array associativo $_POST será usado como padrão.
     * @param array $array
     */
    public function setTemlateVars($array = null)
    {
        if ($array === null)
        {
            $array = $_POST;
        }

        $this->templateVars = $array;
    }

    /**
     * Salva os campos de validação
     * @param array $rules
     */
    public function setRules($rules = array())
    {
        if (!is_array($rules))
        {
            return;
        }
        foreach ($rules as $rule)
        {
            $field = (isset($rule[0])) ? $rule[0] : null;
            $type = (isset($rule[1])) ? $rule[1] : null;
            $req = (isset($rule[2])) ? $rule[2] : false;
            $min = (isset($rule[3])) ? $rule[3] : 0;
            $max = (isset($rule[4])) ? $rule[4] : null;
            $trim = (isset($rule[5])) ? $rule[5] : true;
//            dd($rule);
            $this->validation->addRule($field, $type, $req, $min, $max, $trim);
        }
    }

    /**
     * Performa a validação de acordo com as regas estabelecidas
     */
    public function runValidation()
    {
        $this->validation->addSource($_POST);
        return $this->validation->isValid();
    }

    public function getErros()
    {
        return $this->validation->errors;
    }

    /**
     * Renderiza template, salva e retorna HTML final
     */
    public function renderBody()
    {
        $template = templates_folder($this->template);
        $html = '';
        if ($this->templateVars === null)
        {
            $this->setTemlateVars();
        }

        // instancia o template
        $tmpl = new Wtmpl();
        // insere as variáveis no template
        $tmpl->assign($this->templateVars);

        // renderiza template
        if (file_exists($template))
        {
            $html .= $tmpl->fetch($this->template);
        }
        // salva
        $this->body = $html;
        return $this->body;
    }

    /**
     * Converte corpo HTML e texto
     */
    public function renderText()
    {
        $t = new html2text($this->body, false);
        return $t->get_text();
    }

    /**
     * Seta o assunto
     * @param string $subject
     * @return string
     */
    public function setSubject($subject = '')
    {
        if ($subject == '')
        {
            $subject = 'Contato pelo site';
        }

        return $this->subject = $subject;
    }

    /**
     * Retorna o assunto
     * @return string
     */
    public function getSubject()
    {
        return $this->subject;
    }

    /**
     * Anexa aquivo na classe PHPMailer.
     * Se não for passado o nome do input como argumento, 
     * por padrão será buscado $_FILES['file']
     * @param string $postField
     */
    public function setAttachment($postField = NULL)
    {
        if (isset($_FILES[$postField]))
        {
            $file = $_FILES[$postField];
        }
        else
        {
            $file = $_FILES['file'];
        }

        if (isset($file['tmp_name']))
        {
            $this->phpMailer->AddAttachment($file['tmp_name']);
        }
    }

    /**
     * Faz o envio da mensagem
     * @return boolean
     */
    public function send()
    {
        $this->clearSession();
        
        if ($this->runValidation() === false)
        {
            // colocar os error na sessão
            $_SESSION['oowpvalidationerrors'] = $this->getErros();
            // salva dados na sessão para repopular
            $_SESSION['oowpformdata'] = $_POST;
            $this->error = "Campos inválidos.";
            $this->redirect();
        }

        // verifica se o modo de debug está ativo e sobrepõe autenticação
        if ($this->defaults['sendToDebug'])
        {
            $this->setAuthParams(array(
                'smtpHost' => $this->defaults['smtpHostDebug'],
                'username' => $this->defaults['usernameDebug'],
                'password' => $this->defaults['passwordDebug'],
                'smtpSecure' => $this->defaults['smtpSecureDebug'],
                'smtpPort' => $this->defaults['smtpPortDebug']
            ));
        }

        if ($this->smtpAuth)
        {
            $this->phpMailer->IsSMTP();
            $this->phpMailer->Host = $this->smtpHost;
            $this->phpMailer->SMTPAuth = true;
            $this->phpMailer->Username = $this->username;
            $this->phpMailer->Password = $this->password;
            $this->phpMailer->SMTPSecure = $this->smtpSecure;
            $this->phpMailer->Port = $this->smtpPort;
        }

        $this->phpMailer->From = $this->defaults['fromEmail'];
        $this->phpMailer->FromName = $this->defaults['fromName'];
        $this->phpMailer->AddAddress($this->defaults['toEmail'], $this->defaults['toName']);

        $this->phpMailer->AddReplyTo($this->respondTo['email'], $this->respondTo['name']);

        if ($this->defaults['bccEmail'] != '')
        {
            $this->phpMailer->AddBCC($this->defaults['bccEmail']);
        }

        $this->phpMailer->WordWrap = 50;
        $this->phpMailer->IsHTML(true);

        $this->phpMailer->Subject = $this->getSubject();
        $this->phpMailer->Body = $this->renderBody();
        $this->phpMailer->AltBody = $this->renderText();

        // antes de enviar verifica se está em modo de debug
        if ($this->debug)
        {
            $this->printDebug();
        }

        if (!$this->phpMailer->Send())
        {
            $this->error = $this->phpMailer->ErrorInfo;
            return false;
        }

        return true;
    }

    /**
     * Método chamado após o envio para redirecionar o usuário para a página de destino
     * Por padrão, o script está dentro de uma página de template, por isso header()
     * não pode ser usado, caso o script de envio não esteja em um template WP 
     * é possível habilitar o redirecionamento via header().
     * @param boolean $usingHeaderRedirect
     */
    public function redirect($usingHeaderRedirect = false)
    {

        if ($this->error !== false)
        {
            $url = $this->urlOrigin . '/?fail&message=' . urlencode($this->error);
        }
        else
        {
            $url = $this->urlOrigin . '/?success';
        }

        if ($usingHeaderRedirect)
        {
            header("Location: {$url}");
            exit;
        }

        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        echo '</noscript>';
        exit;
    }

    /**
     * Faz o envio e executa redirecionamento na mesma função.
     * Um atalho para não precisar chamar as duas funções no template.
     * @param boolean $usingHeaderRedirect
     */
    public function sendAndRedirect($usingHeaderRedirect = false)
    {
        $sent = $this->send();
        $this->redirect($usingHeaderRedirect);
    }

}
