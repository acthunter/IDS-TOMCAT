<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Librairie REST Full Client 
 * @author Yoann VANITOU
 * @license http://www.apache.org/licenses/LICENSE-2.0 Apache 2.0
 * @link https://github.com/maltyxx/restclient
 */
class Restclient
{
    /**
     * Instance de Codeigniter
     * @var object
     */
    private $CI;

    /**
     * Configuration
     * @var array 
     */
    private $config = array(
        'port'          => NULL,
        'auth'          => FALSE,
        'auth_type'     => 'basic',
        'auth_username' => '',
        'auth_password' => '',
        'header'        => FALSE,
        'cookie'        => FALSE,
        //'timeout'       => 30,
		'timeout'       =>3,
        'result_assoc'  => TRUE,
        'cache'         => FALSE,
        'tts'           => 3600
    );

    /**
     * Information sur la requ�te
     * @var array 
     */
    private $info = array();

    /**
     * Code de retour
     * @var integer 
     */
    private $errno;

    /**
     * Erreurs
     * @var string 
     */
    private $error;

    /**
     * Valeur de l'envoi
     * @var array
     */
    private $output_value = array();

    /**
     * En-t�te de l'envoi
     * @var array 
     */
    private $output_header = array();

    /**
     * Valeur du retour
     * @var string 
     */
    private $input_value;

    /**
     * En-t�te du retour
     * @var string 
     */
    private $input_header;
    
    /**
     * Code du retour
     * @var integer|NULL
     */
    private $http_code;
    
    /**
     * type de contenu retour
     * @var string|NULL 
     */
    private $content_type;

    /**
     * Constructeur
     * @param array $config
     */
    public function __construct(array $config = array())
    {

        // Initialise la configuration, si elle existe
        $this->initialize($config);

        // Charge l'instance de CodeIgniter
        $this->CI = &get_instance();
    }

    /**
     * Configuration
     * @param array $config
     */
    public function initialize(array $config = array())
    {
        // Si il y a pas de fichier de configuration
        if (empty($config)) {
            return;
        }

        $this->config = array_merge($this->config, (isset($config['restclient'])) ? $config['restclient'] : $config);
    }

    /**
     * Requ�te GET
     * @param type $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    public function get($url, $data = array(), array $options = array())
    {
        $url = "$url?".http_build_query($data);
        return $this->_query('get', $url, $data, $options);
    }

    /**
     * Requ�te POST
     * @param type $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    public function post($url, $data = array(), array $options = array())
    {
        return $this->_query('post', $url, $data, $options);
    }

    /**
     * Requ�te PUT
     * @param type $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    public function put($url, $data = array(), array $options = array())
    {
        return $this->_query('put', $url, $data, $options);
    }
    
    /**
     * Requ�te PATCH
     * @param type $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    public function patch($url, $data = array(), array $options = array())
    {
        return $this->_query('patch', $url, $data, $options);
    }

    /**
     * Requ�te DELETE
     * @param type $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    public function delete($url, $data = array(), array $options = array())
    {
        return $this->_query('delete', $url, $data, $options);
    }

    /**
     * R�cup�re les cookies
     * @return array
     */
    public function get_cookie()
    {
        $cookies = array();

        // Recherche dans les en-t�tes les cookies
        preg_match_all('/Set-Cookie: (.*?);/is', $this->input_header, $data, PREG_PATTERN_ORDER);

        // Si il y a des cookies
        if (isset($data[1])) {
            foreach ($data[1] as $i => $cookie) {
                if (!empty($cookie)) {
                    list($key, $value) = explode('=', $cookie);
                    $cookies[$key] = $value;
                }
            }
        }

        return $cookies;
    }
    
    /**
     * Les derni�res informations de la requ�te
     * @return array
     */
    public function info()
    {        
        return $this->info;
    }
    
    /**
     * Le dernier code de retour http
     * @return interger|NULL
     */
    public function http_code()
    {        
        return $this->http_code;
    }

    /**
     * Mode debug
     * @param  boolean $return retournera l'information plut�t que de l'afficher
     * @return string le code HTML
     */
    public function debug($return = FALSE)
    {
        $input = "=============================================<br/>".PHP_EOL;
        $input .= "=============================================<br/>".PHP_EOL;
        $input .= "<h1>Debug</h1>".PHP_EOL;
        $input .= "=============================================<br/>".PHP_EOL;
        $input .= "<h2>Envoi</h2>".PHP_EOL;
        $input .= "=============================================<br/>".PHP_EOL;
        $input .= "<h3>En-tete</h3>".PHP_EOL;
        $input .= "<pre>".PHP_EOL;
        $input .= print_r($this->output_header, TRUE);
        $input .= "</pre>".PHP_EOL;
        $input .= "<h3>Valeur</h3>".PHP_EOL;
        $input .= "<pre>".PHP_EOL;
        $input .= print_r($this->output_value, TRUE);
        $input .= "</pre>".PHP_EOL;
        $input .= "<h3>Informations</h3>".PHP_EOL;
        $input .= "</pre>".PHP_EOL;
        $input .= print_r($this->info, TRUE);
        $input .= "</pre><br/>".PHP_EOL;
        $input .= "=============================================<br/>".PHP_EOL;
        $input .= "<h2>Response</h2>".PHP_EOL;
        $input .= "=============================================<br/>".PHP_EOL;
        $input .= "<h3>En-tete</h3>".PHP_EOL;
        $input .= "<pre>".PHP_EOL;
        $input .= print_r($this->input_header, TRUE);
        $input .= "</pre>".PHP_EOL;
        $input .= "<h3>Valeur</h3>".PHP_EOL;
        $input .= "<pre>".PHP_EOL;
        $input .= print_r($this->input_value, TRUE);
        $input .= "</pre>".PHP_EOL;
        $input .= "=============================================<br/>".PHP_EOL;

        // Si il y a des erreurs
        if (!empty($this->error)) {
            $input .= "<h3>Errors</h3>".PHP_EOL;
            $input .= "<strong>Code:</strong> ".$this->errno."<br/>".PHP_EOL;
            $input .= "<strong>Message:</strong> ".$this->error."<br/>".PHP_EOL;
            $input .= "=============================================<br/>".PHP_EOL;
        }

        // Type de sortie
        if ($return) {
            return $input;
        } else {
            echo $input;
        }
    }

    /**
     * Envoi la requ�te
     * @param string $method
     * @param string $url
     * @param array $data
     * @param array $options
     * @return string|boolean
     */
    private function _query($method, $url, $data = array(), array $options = array())
    {
        // Initialise la configuration, si elle existe
        $this->initialize($options);

        // Initialisation
        $this->output_header = array();
        $this->output_value = array();
        $this->input_header = '';
        $this->input_value = '';
        $this->http_code = NULL;
        $this->content_type = NULL;

        // Si le cache est activ�
        if ($this->config['cache']) {
            // Parse l'URL
            $url_indo = parse_url($url);

            // D�finition de l'api
            $api = 'rest'.str_replace('/', '_', $url_indo['path']);

            // D�finition de la cl�
            $cache_key = (isset($url_indo['query'])) ? "{$api}_".md5($url_indo['query']) : "{$api}";

            // Si la m�thode est de type GET
            if ($method == 'get') {
                // Si il existe une cl�
                if ($result = $this->CI->cache->get($cache_key)) {
                    return $result;
                }

                // Si la m�thode n'est pas de type GET
            } else {
                // Si l'arbre de cl�s existe
                if ($keys = $this->CI->cache->get($api)) {
                    if (is_array($keys)) {
                        // Parcours les cl�s pour les supprimer
                        foreach ($keys as $key) {
                            $this->CI->cache->delete($key);
                        }
                    }

                    // Supprime l'arbre de cl�s
                    $this->CI->cache->delete($api);
                }
            }
        }

        // Cr�ation d'une nouvelle ressource cURL
        $curl = curl_init();

        // Configuration de l'URL et d'autres options
        curl_setopt($curl, CURLOPT_URL, $url);

        // Si le port est sp�cifi�
        if (!empty($this->config['port'])) {
            curl_setopt($curl, CURLOPT_PORT, $this->config['port']);
        }

        curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, $this->config['timeout']);
        curl_setopt($curl, CURLOPT_FAILONERROR, FALSE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, FALSE);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, strtoupper($method));
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_HEADER, FALSE);
        curl_setopt($curl, CURLOPT_HEADERFUNCTION, array($this, '_headers'));
        curl_setopt($curl, CURLOPT_COOKIESESSION, TRUE);
        curl_setopt($curl, CURLINFO_HEADER_OUT, TRUE);

        // Si il y a une authentification
        if ($this->config['auth']) {
            switch ($this->config['auth_type']) {
                // Authentification http basic
                case 'basic':
                    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
                    curl_setopt($curl, CURLOPT_USERPWD, "{$this->config['auth_username']}:{$this->config['auth_password']}");
            }
        }

        // Si il y a des headers
        if (!empty($this->config['header']) && is_array($this->config['header'])) {
            // Ajoute les en-t�tes
            foreach ($this->config['header'] as $key => $value) {
                $this->output_header[] = "$key: $value";
            }
        }

        // R�f�rence du data
        $this->output_value =& $data;

        // Encodage des datas
        switch ($method) {
            case 'post':
                curl_setopt($curl, CURLOPT_POST, TRUE);

                if (!empty($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
                }
                break;
            case 'put':
            case 'patch':
            case 'delete':
                if (!empty($data)) {
                    curl_setopt($curl, CURLOPT_POSTFIELDS, (is_array($data)) ? http_build_query($data) : $data);
                }
                break;
            case 'get':
            default:
        }

        // D�finition des headers d'envoi
        curl_setopt($curl, CURLOPT_HTTPHEADER, $this->output_header);

        // Si y il a un cookie
        if (!empty($this->config['cookie']) && is_array($this->config['cookie'])) {
            $cookies = array();

            foreach ($this->config['cookie'] as $key => $value) {
                $cookies[] = "$key=$value";
            }

            curl_setopt($curl, CURLOPT_COOKIE, implode(";", $cookies));
        }

        // R�cup�ration de l'URL et affichage sur le naviguateur
        $response = curl_exec($curl);
        
        // R�cup�ration du code http
        $this->http_code = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        
        // R�cup�ration du type de contenu
        $this->content_type = curl_getinfo($curl, CURLINFO_CONTENT_TYPE);

        // Information sur la requete
        $this->info = curl_getinfo($curl);
        
        // Gestion des erreurs
        if ($response === FALSE) {
            $this->errno = curl_errno($curl);
            $this->error = curl_error($curl);
            return FALSE;
        }

        // Fermeture de la session cURL
        curl_close($curl);
                
        // Si le contenu est du json
        if (strstr($this->content_type, 'json')) {
            $result = json_decode($response, $this->config['result_assoc']);
        
        // Si autre format
        } else {
            $result = $response;
        }
        
        // R�f�rence de la r�ponse
        $this->input_value = & $response;

        // Si le cahche est activ� et que la m�thode est de type GET 
        if ($this->config['cache'] && $method == 'get') {
            // Si la cl� existe dans le noeud
            if (!$keys = $this->CI->cache->get($api) OR ! isset($keys[$cache_key])) {
                // R�cup�re les cl�s existantes
                $keys = (is_array($keys)) ? $keys : array();

                // Enregistre la cl�
                $keys[$cache_key] = $cache_key;

                // Sauvegarde les cl�s
                $this->CI->cache->save($api, $keys, $this->config['tts']);
            }

            // Sauvegarde les donn�es
            $this->CI->cache->save($cache_key, $result, $this->config['tts']);
        }

        // Retourne les r�sultats
        return $result;
    }

    /**
     * R�cup�re les en-t�tes
     * @param resource $curl
     * @param string $data
     * @return integer
     */
    public function _headers($curl, $data)
    {
        if (!empty($data)) {
            $this->input_header .= $data;
        }
        
        return strlen($data);
    }
    
}

/* End of file Restclient.php */
/* Location: ./libraries/Restclient/Restclient.php */
