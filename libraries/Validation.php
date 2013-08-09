<?php

/**
 *  $POST = array(
  'name' => 'Fred Scuttle',
  'age' => 42,
  'contact_email'=>'fred@example.com',
  'url'=>'http://phpro.org');

  //*** an array of rules
  $rules_array = array(
  'name'=>array('type'=>'string',  'required'=>true, 'min'=>30, 'max'=>50, 'trim'=>true),
  'age'=>array('type'=>'numeric', 'required'=>true, 'min'=>1, 'max'=>120, 'trim'=>true));

  //*** a new validation instance
  $val = new validation;

  //*** use POST as the source
  $val->addSource($POST);

  //*** add a form field rule
  $val->addRule('contact_email', 'email', true, 1, 255, true)
  ->addRule('url', 'url', false, 10, 150, false);

  //*** add an array of rules
  $val->addRules($rules_array);

  //*** run the validation rules
  $val->run();

  //*** if there are errors show them
  if(sizeof($val->errors) > 0)
  {
  print_r($val->errors);
  }

  //*** show the array of validated and sanitized variables
  print_r($val->sanitized);
 */

/**
 * Tipos válidos:
 * - email
 * - string
 * - numeric
 * - url
 * - float
 * - ipv4
 * - ipv6
 * - bool
 */
class Validation {
    /*
     * @errors array
     */

    public $errors = array();

    /*
     * @the validation rules array
     */
    private $validation_rules = array();

    /*
     * @the sanitized values array
     */
    public $sanitized = array();

    /*
     * @the source 
     */
    private $source = array();
    
    /**
     * Default max number
     * @var int
     */
    private $maxDef = 9999999999999999999999999999999999;

    /**
     *
     * @the constructor, duh!
     *
     */
    public function __construct()
    {
        
    }

    /**
     *
     * @add the source
     *
     * @paccess public
     *
     * @param array $source
     *
     */
    public function addSource($source, $trim = false)
    {
        $this->source = $source;
    }

    /**
     *
     * @run the validation rules
     *
     * @access public
     *
     */
    public function run()
    {
        $this->clearValidation();
        // set the vars
        foreach (new ArrayIterator($this->validation_rules) as $var => $opt)
        {
            if ($opt['required'] == true)
            {
                $this->is_set($var);
            }

            // Trim whitespace from beginning and end of variable
            if (array_key_exists('trim', $opt) && $opt['trim'] == true)
            {
                $this->source[$var] = trim($this->source[$var]);
            }

            switch ($opt['type'])
            {
                case 'email':
                    $this->validateEmail($var, $opt['required']);
                    if (!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeEmail($var);
                    }
                    break;

                case 'url':
                    $this->validateUrl($var);
                    if (!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeUrl($var);
                    }
                    break;

                case 'numeric':
                    $this->validateNumeric($var, $opt['min'], $opt['max'], $opt['required']);
                    if (!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeNumeric($var);
                    }
                    break;

                case 'string':
                    $this->validateString($var, $opt['min'], $opt['max'], $opt['required']);
                    if (!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeString($var);
                    }
                    break;

                case 'float':
                    $this->validateFloat($var, $opt['required']);
                    if (!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeFloat($var);
                    }
                    break;

                case 'ipv4':
                    $this->validateIpv4($var, $opt['required']);
                    if (!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeIpv4($var);
                    }
                    break;

                case 'ipv6':
                    $this->validateIpv6($var, $opt['required']);
                    if (!array_key_exists($var, $this->errors))
                    {
                        $this->sanitizeIpv6($var);
                    }
                    break;

                case 'bool':
                    $this->validateBool($var, $opt['required']);
                    if (!array_key_exists($var, $this->errors))
                    {
                        $this->sanitized[$var] = (bool) $this->source[$var];
                    }
                    break;
            }
        }
    }

    /**
     * Roda validação e retorna boolean
     * @return boolean
     */
    public function isValid()
    {
        $this->run();
        if (empty($this->errors) || sizeof($this->errors) == 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    /**
     * Remove quaisquer dado armazenado.
     */
    public function clearValidation()
    {
        $this->errors = array();
    }

    /**
     * add a rule to the validation rules array
     * @param string $varname The variable name
     * @param string $type The type of variable
     * @param bool $required If the field is required
     * @param int $min The minimum length or range
     * @param int $max the maximum length or range
     * @param bool $trim Crop space around
     * @return \Validation
     */
    public function addRule($varname, $type, $required = false, $min = 0, $max = null, $trim = true)
    {
        if($max === null){
            $max = $this->maxDef;
        }
        $this->validation_rules[$varname] = array('type' => $type, 'required' => $required, 'min' => $min, 'max' => $max, 'trim' => $trim);
        //allow chaining
        return $this;
    }

    /**
     *
     * @add multiple rules to teh validation rules array
     *
     * @access public
     *
     * @param array $rules_array The array of rules to add
     *
     */
    public function AddRules(array $rules_array)
    {
        $this->validation_rules = array_merge($this->validation_rules, $rules_array);
    }

    /**
     *
     * @Check if POST variable is set
     *
     * @access private
     *
     * @param string $var The POST variable to check
     *
     */
    private function is_set($var)
    {
        if (!isset($this->source[$var]))
        {
            $this->errors[$var] = $var . ' é obrigatório.';
        }
    }

    /**
     *
     * @validate an ipv4 IP address
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param bool $required
     *
     */
    private function validateIpv4($var, $required = false)
    {
        if ($required == false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if (filter_var($this->source[$var], FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === FALSE)
        {
            $this->errors[$var] = $var . ' não é um IPv4 válido';
        }
    }

    /**
     *
     * @validate an ipv6 IP address
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param bool $required
     *
     */
    public function validateIpv6($var, $required = false)
    {
        if ($required == false && strlen($this->source[$var]) == 0)
        {
            return true;
        }

        if (filter_var($this->source[$var], FILTER_VALIDATE_IP, FILTER_FLAG_IPV6) === FALSE)
        {
            $this->errors[$var] = $var . ' não é um IPv6 válido.';
        }
    }

    /**
     *
     * @validate a floating point number
     *
     * @access private
     *
     * @param $var The variable name
     *
     * @param bool $required
     */
    private function validateFloat($var, $required = false)
    {
        if ($required == false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if (filter_var($this->source[$var], FILTER_VALIDATE_FLOAT) === false)
        {
            $this->errors[$var] = $var . ' não é um número decimal válido.';
        }
    }

    /**
     *
     * @validate a string
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param int $min the minimum string length
     *
     * @param int $max The maximum string length
     *
     * @param bool $required
     *
     */
    private function validateString($var, $min = 0, $max = 0, $required = false)
    {
        if ($required == false && strlen($this->source[$var]) == 0)
        {
            return true;
        }

        if (isset($this->source[$var]))
        {
            if (strlen($this->source[$var]) < $min)
            {
                $this->errors[$var] = $var . ' é muito curto';
            }
            elseif (strlen($this->source[$var]) > $max)
            {
                $this->errors[$var] = $var . ' é muito grande';
            }
            elseif (!is_string($this->source[$var]))
            {
                $this->errors[$var] = $var . ' não é válido.';
            }
        }
    }

    /**
     *
     * @validate an number
     *
     * @access private
     *
     * @param string $var the variable name
     *
     * @param int $min The minimum number range
     *
     * @param int $max The maximum number range
     *
     * @param bool $required
     *
     */
    private function validateNumeric($var, $min = 0, $max = null, $required = false)
    {
        if($max === null)
        {
            $max = $this->maxDef;
        }
        if ($required == false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if (filter_var($this->source[$var], FILTER_VALIDATE_INT, array("options" => array("min_range" => $min, "max_range" => $max))) === FALSE)
        {
            $this->errors[$var] = $var . ' não é um número válido.';
        }
    }

    /**
     *
     * @validate a url
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @param bool $required
     *
     */
    private function validateUrl($var, $required = false)
    {
        if ($required == false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if (filter_var($this->source[$var], FILTER_VALIDATE_URL) === FALSE)
        {
            $this->errors[$var] = $var . ' não é uma URL válida.';
        }
    }

    /**
     *
     * @validate an email address
     *
     * @access private
     *
     * @param string $var The variable name 
     *
     * @param bool $required
     *
     */
    private function validateEmail($var, $required = false)
    {
        if ($required == false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        if (filter_var($this->source[$var], FILTER_VALIDATE_EMAIL) === FALSE)
        {
            $this->errors[$var] = $var . ' não é um e-mail válido.';
        }
    }

    /**
     * @validate a boolean 
     *
     * @access private
     *
     * @param string $var the variable name
     *
     * @param bool $required
     *
     */
    private function validateBool($var, $required = false)
    {
        if ($required == false && strlen($this->source[$var]) == 0)
        {
            return true;
        }
        filter_var($this->source[$var], FILTER_VALIDATE_BOOLEAN);
        {
            $this->errors[$var] = $var . ' não é válido.';
        }
    }

    ########## SANITIZING METHODS ############

    /**
     *
     * @santize and email
     *
     * @access private
     *
     * @param string $var The variable name
     *
     * @return string
     *
     */
    public function sanitizeEmail($var)
    {
        $email = preg_replace('((?:\n|\r|\t|%0A|%0D|%08|%09)+)i', '', $this->source[$var]);
        $this->sanitized[$var] = (string) filter_var($email, FILTER_SANITIZE_EMAIL);
    }

    /**
     *
     * @sanitize a url
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeUrl($var)
    {
        $this->sanitized[$var] = (string) filter_var($this->source[$var], FILTER_SANITIZE_URL);
    }

    /**
     *
     * @sanitize a numeric value
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeNumeric($var)
    {
        $this->sanitized[$var] = (int) filter_var($this->source[$var], FILTER_SANITIZE_NUMBER_INT);
    }

    /**
     *
     * @sanitize a string
     *
     * @access private
     *
     * @param string $var The variable name
     *
     */
    private function sanitizeString($var)
    {
        $this->sanitized[$var] = (string) filter_var($this->source[$var], FILTER_SANITIZE_STRING);
    }

}

/*** end of class ***/