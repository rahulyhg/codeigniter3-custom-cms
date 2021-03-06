<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Security Class Extension.
 *     extension of security class.
 *     
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 * 
 * @version 3.0
 * 
 * @category Core
 * 
 */
class FAT_Security extends CI_Security 
{
    /**
     * Class constructor.
     *     load parent constructor.
     */
    function __construct() 
    {
        parent::__construct();
    }
    
    /**
     * Reset to login page if csrf is expired.
     */
    public function csrf_show_error() 
    {
        // show_error('The action you have requested is not allowed.');  // default code
        $redirect_url = PATH_ROOT.'error/csrf_redirect';
        if( ! empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
            echo json_encode(['redirect_auth' => $redirect_url]);
        }

        header('Location: '.$redirect_url.'', TRUE, 302);
        exit();
    }

}
/* End of file FAT_Security.php */
/* Location: ./application/core/FAT_Security.php */
