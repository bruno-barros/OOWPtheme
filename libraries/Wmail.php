<?php
/**
 * Classe responsável pelo envio de emails
 * 
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
    public $host = 'smtp1.example.com;smtp2.example.com';
    public $username = ''; // SMTP username
    public $password = ''; // SMTP password
    public $smtpSecure = 'tls';
    public $defaults = array();
    private $phpMailer = null;
    public $subject = '';
    public $error = false;
    public $templateFolder = 'email';
    public $templateVars = array();
    public $body = '';
    public $urlOrigin = '';
    public $respondTo = array();

    public function __construct()
    {
        require_once TEMPLATEPATH . '/libraries/phpmailer/extras/class.html2text.php';
        require_once TEMPLATEPATH . '/libraries/phpmailer/class.phpmailer.php';
        $this->phpMailer = new PHPMailer();
        $this->phpMailer->SetLanguage('br');
        $this->defaults = $this->loadConfig();
        $this->setAuthParams($this->defaults);
        if(isset($_GET['p']))
        {
            $this->urlOrigin = trim($_GET['p'], '/');
        }
    }

    /**
     * Instancia parâmetros de autenticação
     * @param array $authParams
     */
    public function setAuthParams($authParams = array())
    {
        if (empty($authParams))
        {
            $this->smtpAuth = false;
        }

        $this->smtpAuth = true;
        $this->host = $authParams['host'];
        $this->username = $authParams['username'];
        $this->password = $authParams['password'];
        $this->smtpSecure = $authParams['smtpSecure'];
    }

    /**
     * Retorna configurações de autenticação
     * @return array
     */
    public function getAuthParams()
    {
        return array(
            'smtpAuth' => $this->smtpAuth,
            'host' => $this->host,
            'username' => $this->username,
            'password' => $this->password,
            'smtpSecure' => $this->smtpSecure
        );
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
     * @param string $templateView
     */
    public function setTemplate($templateView = 'email')
    {
        $this->templateFolder = $templateView;
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
     * Combina variáveis via POST com o template e retorna corpo do e-mail
     */
    public function renderBody()
    {
        $path = templates_folder($this->templateFolder);
        $html = '';
        
        $tmpl = new Wtmpl();
        $tmpl->assign($this->templateVars);
        
//        foreach ($this->templateVars as $key => $value)
//        {
//            ${$key} = $value;
//        }
        // carrega header
        if (file_exists($path . '/header.html'))
        {
//            include $path . '/header.php';
            $html .= $tmpl->fetch($this->templateFolder . '/header.html');
        }
        // carrega body
        if (file_exists($path . '/body.html'))
        {
//            include $path . '/body.php';
            $html .= $tmpl->fetch($this->templateFolder . '/body.html');
        }
        // carrega footer
        if (file_exists($path . '/footer.html'))
        {
//            include $path . '/footer.php';
            $html .= $tmpl->fetch($this->templateFolder . '/footer.html');
        }
        // concatena
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

    public function send()
    {
//        dd($this->urlOrigin);
//        
        dd($this->renderBody(), true);

        if ($this->smtpAuth)
        {
            $this->phpMailer->IsSMTP();
            $this->phpMailer->Host = $this->host;
            $this->phpMailer->SMTPAuth = true;
            $this->phpMailer->Username = $this->username;
            $this->phpMailer->Password = $this->password;
            $this->phpMailer->SMTPSecure = $this->smtpSecure;
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

        if (!$this->phpMailer->Send())
        {
            $this->error = $this->phpMailer->ErrorInfo;
            return false;
        }

        return true;
    }

    public function redirect()
    {
        
        if ($this->error === false)
        {
//            header("Location: {$this->urlOrigin}" . '/?fail&amp;message=' . urlencode($this->error));
            $url = $this->urlOrigin . '/?fail&amp;message=' . urlencode($this->error);
        }
        else
        {
//            header("Location: {$this->urlOrigin}" . '/?success');
            $url = $this->urlOrigin . '/?success';            
        }
            
        echo '<script type="text/javascript">';
        echo 'window.location.href="' . $url . '";';
        echo '</script>';
        echo '<noscript>';
        echo '<meta http-equiv="refresh" content="0;url=' . $url . '" />';
        echo '</noscript>';
    }

}