<?php
/*
    Hash
    Copyright (C) 2013 Ryan Strug

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License along
    with this program; if not, write to the Free Software Foundation, Inc.,
    51 Franklin Street, Fifth Floor, Boston, MA 02110-1301 USA.
 */

/**
 * Hasher class.
 */
class Hasher
{
    /**
     * error
     * 
     * (default value: null)
     * 
     * @var string
     * @access private
     */
    private $_error = null;
    
    /**
     * input
     * 
     * (default value: null)
     * 
     * @var string
     * @access private
     */
    public $input = null;
    
    /**
     * length
     * 
     * (default value: 32)
     * 
     * @var integer
     * @access public
     */
    public $length = 64;
    
    /**
     * _type
     * 
     * (default value: 'Unidentifiable hash or non-hash.')
     * 
     * @var string
     * @access private
     */
    private $_type = 'Unidentifiable hash or non-hash.';
    
    /**
     * _hashes
     * 
     * @var array
     * @access private
     */
    private $_hashes = array();
    
    /**
     * _special_hashes
     * 
     * @var array
     * @access private
     */
    private $_special_hashes = array(
        'base64',
        'crypt'
    );
    
    /**
     * _strings
     * 
     * @var array
     * @access private
     */
    private $_strings = array(
        'all' => null,
        'all_no_quotes' => null,
        'alphanumeric' => null,
        'hex' => null,
        'numeric' => null
    );
    
    /**
     * _tests
     * 
     * @var array
     * @access private
     */
    private $_tests = array(
        8 => array(
            'adler32',
            'crc32',
            'crc32b',
            'fnv131',
            'fnv1a32'
        ),
        16 => array(
            'fnv164',
            'fnv1a64'
        ),
        32 => array(
            'hashval128,3',
            'hashval128,4',
            'hashval128,5',
            'md2',
            'md4',
            'md5',
            'ripemd128',
            'tiger128,3',
            'tiger128,4'
        ),
        40 => array(
            'hashval160,3',
            'hashval160,4',
            'hashval160,5',
            'ripemd160',
            'sha1',
            'tiger160,3',
            'tiger160,4'
        ),
        48 => array(
            'hashval192,3',
            'hashval192,4',
            'hashval192,5',
            'tiger192,3',
            'tiger192,4'
        ),
        56 => array(
            'hashval224,3',
            'hashval224,4',
            'hashval224,5',
            'sha224'
        ),
        64 => array(
            'gost',
            'hashval256,3',
            'hashval256,4',
            'hashval256,5',
            'ripemd256',
            'sha256',
            'snefru',
            'snefru256'
        ),
        80 => array(
            'ripemd320'
        ),
        96 => array(
            'sha384'
        ),
        128 => array(
            'salsa10',
            'salsa20',
            'sha512',
            'whirlpool'
        )
    );
    
    /**
     * __construct function.
     * Initializes.
     * 
     * @access public
     * @return void
     */
    public function __construct()
    {
        // null
    }
    
    /**
     * load_form function.
     * 
     * @access public
     * @return void
     */
    public function load_form()
    {
        if ($_POST)
            foreach ($_POST as $key => $value)
                if ($key != 'submit')
                    $this->$key = $value;
        
        include_once('content/form.php');
    }
    
    /**
     * load_content function.
     * Dynamically loads content.
     * 
     * @access public
     * @return void
     */
    public function load_content()
    {        
        // Load content
        $actions = array();
        $handle = opendir('content');
        while (($file = readdir($handle)) !== false) {
            $action = strstr($file, '.', true);
            if (method_exists($this, $action)) {
                $actions[] = $action;
                $this->$action();
            }
        }
        closedir($handle);
        krsort($actions);
        
        $this->display_error();
        
        include_once('content/form.php');
        include_once('content/strings.php');
        include_once('content/hash.php');
        include_once('content/type.php');
    }
    
    /**
     * display_error function.
     * 
     * @access private
     * @return void
     */
    private function display_error()
    {
        if ($this->_error)
            echo '<div id="error">'.$this->_error.'</div>';
    }
    
    /**
     * hash function.
     * Generates hashes for the input data.
     * 
     * @access private
     * @return void
     */
    private function hash()
    {
        foreach (hash_algos() as $hash)
            $this->_hashes[$hash] = hash($hash, $this->input);
        
        foreach ($this->_special_hashes as $hash)
            $this->_hashes[$hash] = $this->$hash($this->input);
            
        ksort($this->_hashes);
    }
    
    /**
     * strings function.
     * Generates random strings of the specified length.
     * 
     * @access private
     * @return void
     */
    private function strings()
    {
        if ($this->length && is_numeric($this->length) && $this->length > 0) {
            $this->_strings['all'] = htmlentities($this->generate_string($this->salt(' ', '~')));
            $this->_strings['all_no_quotes'] = htmlentities($this->generate_string(str_replace(array('"', "'") , '', $this->salt(' ', '~'))));
            $this->_strings['alphanumeric'] = $this->generate_string($this->salt(0, 9).$this->salt('A', 'Z').$this->salt('a', 'z'));
            $this->_strings['hex'] = $this->generate_string($this->salt(0, 9).$this->salt('a', 'f'));
            $this->_strings['numeric'] = $this->generate_string($this->salt(0, 9));
        } elseif (!is_numeric($this->length) || $this->length <= 0)
            $this->_error = 'Please enter a valid string length.';
    }
    
    /**
     * type function.
     * Determines the type of input hash.
     * 
     * @access private
     * @return void
     */
    private function type()
    {
        if ($this->input)
            foreach ($this->_tests as $length => $hashes)
                foreach ($hashes as $test)
                    if ($this->validate_hash($this->input, $length)) {
                        $first = true;
                        foreach ($hashes as $test) {
                            if (!$first)
                                $this->_type .= ', ';
                            else {
                                $this->_type = '';
                                $first = false;
                            }
                            
                            $this->_type .= $test;
                            $this->length = $length;
                        }
                        break;
                    }
    }
        
    /**
     * get_hashes function.
     * 
     * @access public
     * @return void
     */
    public function get_hashes()
    {
        foreach ($this->_hashes as $hash => $result)
            echo '<tr>'
                .'    <th>'.$hash.':</th>'
                .'    <td>'.$result.'</td>'
                .'</tr>';
    }
    
    /**
     * get_strings function.
     * 
     * @access public
     * @return void
     */
    public function get_strings()
    {
        foreach ($this->_strings as $string => $result)
            echo '<tr>'
                .'    <th>'.$string.':</th>'
                .'    <td>'.$result.'</td>'
                .'</tr>';
    }
    
    /**
     * get_type_info function.
     * 
     * @access public
     * @return void
     */
    public function get_type_info()
    {
        echo '<tr>'
            .'    <th>type(s):</th>'
            .'    <td>'.$this->_type.'</td>'
            .'</tr>'
            .'<tr>'
            .'    <th>length:</th>'
            .'    <td>'.strlen($this->input).'</td>'
            .'</tr>';
    }
        
    /**
     * base64 function.
     * Uses base64 algorithm.
     * 
     * @access private
     * @param mixed $input (default: null)
     * @return string
     */
    private function base64($input = null)
    {
        return base64_encode($input);
    }
    
    /**
     * crypt function.
     * Uses UNIX DES algorithm.
     * 
     * @access private
     * @param mixed $input (default: null)
     * @return string
     */
    private function crypt($input = null)
    {
        return crypt($input);
    }
    
    /**
     * salt function.
     * Generates a string of ASCII characters from start to end.
     * 
     * @access private
     * @param character $start (default: null)
     * @param character $end (default: null)
     * @return string
     */
    private function salt($start = null, $end = null)
    {
        $salt = null;
        for ($i = ord($start); $i <= ord($end); $i++)
            $salt .= chr($i);
        
        return $salt;
    }
    
    /**
     * generate_string function.
     * Generates a string of specified length based on the character set.
     * 
     * @access private
     * @param mixed $characters (default: null)
     * @return string
     */
    private function generate_string($characters = null)
    {
        $string = null;
        for ($i = 0; $i < $this->length; $i++)
            $string .= substr($characters, rand(0, strlen($characters)) - 1, 1);
        
        return $string;
    }
    
    /**
     * validate_hash function.
     * Validates the input using the hash test type.
     * 
     * @access private
     * @param mixed $input (default: null)
     * @param integer $length (default: 0)
     * @return boolean
     */
    private function validate_hash($input = null, $length = 0)
    {
        return strlen($input) == $length && $this->validate_chars($this->salt(0, 9).$this->salt('a', 'f'), $input);
    }
        
    /**
     * validate_chars function.
     * Validates whether or not the string has the proper characters.
     * 
     * @access private
     * @param mixed $characters (default: null)
     * @param mixed $input (default: null)
     * @return boolean $valid
     */
    private function validate_chars($characters = null, $input = null)
    {
        for ($i = 0; $i < strlen($input); $i++)
            if (strstr($characters, substr($input, $i, 1)) === false)
                return false;
        return true;
    }
}
