<?php

defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Lang Class Extension.
 *
 * @author ivan lubis <ivan.z.lubis@gmail.com>
 *
 * @version 3.0
 *
 * @category Core
 * @desc extension of lang class to support internationalization
 */
class FAT_Lang extends CI_Lang
{
    /**************************************************
      configuration
     ************************************************* */

    // languages
    private $languages = [
        'id' => 'indonesia',
        'en' => 'english',
    ];
    // special URIs (not localized)
    private $special = [
        //"xms"
    ];
    // where to redirect if no language in URI
    private $uri;
    private $default_uri;
    private $lang_code;

    /*     * *********************************************** */

    public function __construct()
    {
        parent::__construct();

        global $CFG;
        global $URI;
        global $RTR;

        $this->uri = $URI->uri_string();
        $this->default_uri = $RTR->default_controller;

        $uri_segment = $this->get_uri_lang($this->uri);
        $this->lang_code = $uri_segment['lang'];

        $url_ok = false;
        if ((!empty($this->lang_code)) && (array_key_exists($this->lang_code, $this->languages))) {
            $language = $this->languages[$this->lang_code];
            $CFG->set_item('language', $language);
            $url_ok = true;
        }

        if ((!$url_ok) && (!$this->is_special($uri_segment['parts'][0]))) { // special URI -> no redirect
            // set default language
            $CFG->set_item('language', $this->languages[$this->default_lang()]);

            $uri = (!empty($this->uri)) ? $this->uri : $this->default_uri;
            $uri = ($uri[0] != '/') ? '/'.$uri : $uri;
            $new_url = $CFG->config['base_url'].$this->default_lang().$uri;

            header('Location: '.$new_url, true, 302);
            exit;
        }
    }

    // get current language
    // ex: return 'en' if language in CI config is 'english'
    public function lang()
    {
        global $CFG;
        $language = $CFG->item('language');

        $lang = array_search($language, $this->languages);
        if ($lang) {
            return $lang;
        }

            // this should not happen
    }

    public function is_special($lang_code)
    {
        if ((!empty($lang_code)) && (in_array($lang_code, $this->special))) {
            return true;
        } else {
            return false;
        }
    }

    public function switch_uri($lang)
    {
        if ((!empty($this->uri)) && (array_key_exists($lang, $this->languages))) {
            if ($uri_segment = $this->get_uri_lang($this->uri)) {
                $uri_segment['parts'][0] = $lang;
                $uri = implode('/', $uri_segment['parts']);
            } else {
                $uri = $lang.'/'.$this->uri;
            }
        }

        return $uri;
    }

    //check if the language exists
    //when true returns an array with lang abbreviation + rest
    public function get_uri_lang($uri = '')
    {
        if (!empty($uri)) {
            $uri = ($uri[0] == '/') ? substr($uri, 1) : $uri;

            $uri_expl = explode('/', $uri, 2);
            $uri_segment['lang'] = null;
            $uri_segment['parts'] = $uri_expl;

            if (array_key_exists($uri_expl[0], $this->languages)) {
                $uri_segment['lang'] = $uri_expl[0];
            }

            return $uri_segment;
        } else {
            return false;
        }
    }

    // default language: first element of $this->languages
    public function default_lang()
    {
        //$browser_lang = !empty($_SERVER['HTTP_ACCEPT_LANGUAGE']) ? strtok(strip_tags($_SERVER['HTTP_ACCEPT_LANGUAGE']), ',') : '';
        //$browser_lang = substr($browser_lang, 0, 2);
        /* original file
          return (array_key_exists($browser_lang, $this->languages)) ? $browser_lang: 'en';
         */
        //return (array_key_exists($browser_lang, $this->languages)) ? 'id': 'en';
        $language = 'en';

        return $language;
    }

    // add language segment to $uri (if appropriate)
    public function localized($uri)
    {
        if (!empty($uri)) {
            $uri_segment = $this->get_uri_lang($uri);
            if (!$uri_segment['lang']) {
                if ((!$this->is_special($uri_segment['parts'][0])) && (!preg_match('/(.+)\.[a-zA-Z0-9]{2,4}$/', $uri))) {
                    $uri = $this->lang().'/'.$uri;
                }
            }
        }

        return $uri;
    }

    /**
     * get active uri language.
     *
     * @return string language uri
     */
    public function get_active_uri_lang()
    {
        return $this->lang_code;
    }
}
/* End of file FAT_Lang.php */
/* Location: ./application/core/FAT_Lang.php */
