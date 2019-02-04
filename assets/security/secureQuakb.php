<?php

//This function will be used to decode a base32 encrypted string
function decodebase32($str)
{
    $decodeTable = array(
        'A' => 0, 'B' => 1, 'C' => 2, 'D' => 3, 'E' => 4, 'F' => 5, 'G' => 6, 'H' => 7, 'I' => 8, 'J' => 9, 'K' => 10, 'L' => 11, 'M' => 12, 'N' => 13,
        'O' => 14, 'P' => 15, 'Q' => 16, 'R' => 17, 'S' => 18, 'T' => 19, 'U' => 20, 'V' => 21, 'W' => 22, 'X' => 23, 'Y' => 24, 'Z' => 25, '2' => 26,
        '3' => 27, '4' => 28, '5' => 29, '6' => 30, '7' => 31,);
    $str = strtoupper($str);
    $l = strlen($str);
    $n = 0;
    $b = 0;
    $decoded = null;
    for ($i = 0; $i < $l; $i++) {
        $n = $n << 5;
        $n = $n + $decodeTable[$str[$i]];
        $b = $b + 5;
        if ($b >= 8) {
            $b = $b - 8;
            $decoded .= chr(($n & (0xFF << $b)) >> $b);
        }
    }
    return $decoded;
}

//Safe comparision Between Srings 
function compareSafe($safe, $user)
{
    /* Prevent issues if string length is 0. */
    $safe .= chr(0);
    $user .= chr(0);

    $safeLen = strlen($safe);
    $userLen = strlen($user);

    /* Set the result to the difference between the lengths. */
    $result = $safeLen - $userLen;

    for ($i = 0; $i < $userLen; $i++) {
        $result |= (ord($safe[$i % $safeLen]) ^ ord($user[$i]));
    }

    // They are only identical strings if $result is exactly 0...
    return $result === 0;
}

/*FOR XSS Scripting
 * %variables: stip mode of f() is used.
 * !variables: escapeAll mode of f() is used.
 * @variables: escape mode of f() is used.
 * &variables: url mode of f() is used.
 */
function t($str, $args)
{
    /* Loop trough the args and apply the filters. */
    while (list($name, $data) = each($args)) {
        $safeData = false;
        $filterType = mb_substr($name, 0, 1);
        switch ($filterType) {
            case '%':
                /* %variables: HTML tags are stripped of from the string
                   before it is in inserted. */
                $safeData = f($data, 'strip');
                break;
            case '!':
                /* !variables: HTML and special characters are escaped from the string
                   before it is used. */
                $safeData = f($data, 'escapeAll');
                break;
            case '@':
                /* @variables: Only HTML is escaped from the string. Special characters
                 * is kept as it is. */
                $safeData = f($data, 'escape');
                break;
            case '&':
                /* Encode a string according to RFC 3986 for use in a URL. */
                $safeData = f($data, 'url');
                break;
            default:
                //throw new \phpSec\Exception\InvalidArgumentException('Unknown variable type');
                break;
        }
        if ($safeData !== false) {
            $str = str_replace($name, $safeData, $str);
        }
    }

    return $str;
}

function f($str, $mode = 'escape')
{
    $_charset = 'UTF-8';
    switch ($mode) {
        case 'strip':
            /* HTML tags are stripped from the string
               before it is used. */
            return strip_tags($str);
        case 'escapeAll':
            /* HTML and special characters are escaped from the string
               before it is used. */
            return htmlentities($str, ENT_QUOTES, $_charset);
        case 'escape':
            /* Only HTML tags are escaped from the string. Special characters
               is kept as is. */
            return htmlspecialchars($str, ENT_NOQUOTES, $_charset);
        case 'url':
            /* Encode a string according to RFC 3986 for use in a URL. */
            return rawurlencode($str);
        case 'filename':
            /* Escape a string so it's safe to be used as filename. */
            return str_replace('/', '_', $str);
        default:
            //throw new \phpSec\Exception\InvalidArgumentException('Unknown variable type');
    }
}


/**
 * Generate pseudorandom bytes.
 *
 * @param integer $len
 * @return binary
 */
function bytes($len)
{
    /* Code inspired by this blogpost by Enrico Zimuel
     * http://www.zimuel.it/en/strong-cryptography-in-php/ */
    $strong = false;
    if (function_exists('openssl_random_pseudo_bytes')) {
        $rnd = openssl_random_pseudo_bytes($len, $strong);
        if ($strong === true) {
            return $rnd;
        }
    }

    /* Either we dont have the OpenSSL library or the data returned was not
     * considered secure. Fall back on this less secure code. */
    if (function_exists('mcrypt_create_iv')) {
        $rnd = mcrypt_create_iv($len, MCRYPT_DEV_URANDOM);
        return $rnd;
    }

    /* Either we dont have the MCrypt library and OpenSSL library or the data returned was not
     * considered secure. Fall back on this less secure code. */
    $rnd = '';
    for ($i = 0; $i < $len; $i++) {
        $sha = hash('sha256', mt_rand());
        $char = mt_rand(0, 30);
        $rnd .= chr(hexdec($sha[$char] . $sha[$char + 1]));
    }
    return (binary)$rnd;
}

/**bytes
 * Generate a random integer.
 *
 * @param integer $min
 * @param integer $max
 * @return integer
 */
function int($min, $max)
{
    $delta = $max - $min;
    $bytes = ceil($delta / 256);
    $rnd = bytes($bytes);
    $add = 0;
    for ($i = 0; $i < $bytes; $i++) {
        $add += ord($rnd[$i]);
    }
    $add = $add % ($delta + 1);
    return $min + $add;
}

/**
 * Generate a random string.
 *
 * @param integer $len
 * @param string $_charset
 * @return string
 */
function str($len)
{
    $_charset = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $str = '';
    for ($i = 0; $i < $len; $i++) {
        $pos = int(0, strlen($_charset) - 1);
        $str .= $_charset[$pos];
    }
    return $str;
}


/**
 * Return random hexadecimal data.
 *
 * @param integer $len
 * @return string
 */
function hex($len)
{
    return bin2hex(bytes($len));
}


/**
 * Return one or more random random keys from an array.
 *
 * @param array $array
 *   Input array.
 *
 * @param integer $num
 *   Number of keys to pick.
 *
 * @return mixed
 *   String with the key, or array containing multiple keys.
 */
function arrayRand($array, $num = 1)
{
    $keys = array_keys($array);
    $numKeys = sizeof($keys);
    if ($num == 1) {
        return $keys[int(0, $numKeys - 1)];
    }

    for ($i = 0; $i < $num; $i++) {
        $picked[] = $keys[int(0, $numKeys - 1)];
    }
    return $picked;
}

/**
 * Return a random boolean.
 *
 * @return boolean
 */
function bool()
{
    $byte = bytes(1);
    if ((ord($byte) + 1) % 2 === 0) {
        return false;
    }
    return true;
}

/**
 * Check structure of an array.
 * This method checks the structure of an array (only the first layer of it) against
 * a defined set of rules.
 *
 * @param array $array
 *   Array to check.
 *
 * @param array $structure
 *   Expected array structure. Defined for example like this:
 *   array(
 *     'string' => array(
 *       'callback' => 'strlen',
 *       'params'   => array('%val'),
 *       'match'    => 3,
 *     ),
 *     'not allowed' = false, // Only makes sense with $strict = false
 *     'needed'      = true,
 *   ),
 *
 * @param bool $strict
 *   If strict is set to false we will allow keys that's not defined in the structure.
 *
 * @return bool
 *   Returns true on match, and false on mismatch.
 */
function arrayCheck($array, $structure, $strict = true)
{

    $success = true;

    /* First compare the size of the two arrays. Return error if strict is enabled. */

    if (sizeof($array) != sizeof($structure) && $strict === true) {

        //self::error('Array does not match defined structure');

        return false;

    }


    /* Loop trough all the defined keys defined in the structure. */

    foreach ($structure as $key => $callbackArray) {

        if (isset($array[$key])) {

            /* The key exists in the array we are checking. */


            if (is_array($callbackArray) && isset($callbackArray['callback'])) {

                /* We have a callback. */


                /* Replace %val with the acutal value of the key. */

                $callbackArray['params'] = str_replace('%val', $array[$key], $callbackArray['params']);


                if (call_user_func_array($callbackArray['callback'], $callbackArray['params']) !== $callbackArray['match']) {

                    /* Call the *duh* callback. If this returns false throw error, or an axe. */

                    //self::error('Array does not match defined structure. The '.$key.' key did not pass the '.$callbackArray['callback'].' callback');

                    $success = false;

                }

            } elseif ($callbackArray === false) {

                /* We don't have a callback, but we have found a disallowed key. */

                //self::error('Array does not match defined structure. '.$key.' is not allowed');

                $success = false;

            }

        } else {

            /* The key don't exist in the array we are checking. */


            if ($callbackArray !== false) {

                /* As long as this is not a disallowed key, sound the general alarm. */

                //self::error('Array does not match defined structure. '.$key.' not defined');

                $success = false;

            }

        }

    }

    return $success;

}


/**
 * Returns a unique identifier.
 *
 * @return string
 *   Returns a unique identifier.
 */
function genUid()
{

    $hex = bin2hex(bytes(32));

    $str = substr($hex, 0, 16) . '-' . substr($hex, 16, 8) . '-' . substr($hex, 24, 8) . '-' . substr($hex, 32, 8) . '-' . substr($hex, 40, 24);

    return $str;

}

/**
 * Get/set the current phpSec UID.
 *
 * The phpSec UID is required for some sub classes of phpSec, for
 * example Cache.
 *
 * @return string
 *   Return the current phpSec UID.
 */

function getUid()
{

    /* Create a random token for each visitor and store it the users session.

     This is for example used to identify owners of cache data. */

    if (!isset($_SESSION['phpSec-uid'])) {

        $_SESSION['phpSec-uid'] = genUid();

    }

    return $_SESSION['phpSec-uid'];

}

$_algo = 'rijndael-256';
$_mode = 'ctr';

$_padding = false;
const HASH_TYPE = 'sha256';

/**
 * phpSec core Pimple container.
 */
$psl = null;
/**
 * Encrypt data returning a JSON encoded array safe for storage in a database
 * or file. The array has the following structure before it is encoded:
 * array(
 *   'cdata' => 'Encrypted data, Base 64 encoded',
 *   'iv'    => 'Base64 encoded IV',
 *   'algo'  => 'Algorythm used',
 *   'mode'  => 'Mode used',
 *   'mac'   => 'Message Authentication Code'
 * )
 *
 * @param mixed $data
 *   Data to encrypt.
 *
 * @param string $key
 *   Key to encrypt data with.
 *
 * @return string
 *   Serialized array containing the encrypted data along with some meta data.
 */
function encrypt($data, $key)
{

    /* Make sure both algorithm and mode are either block or non-block. */
    $isBlockCipher = mcrypt_module_is_block_algorithm($_algo);
    $isBlockMode = mcrypt_module_is_block_algorithm_mode($_mode);
    if ($isBlockCipher !== $isBlockMode) {
        //throw new \phpSec\Exception\InvalidAlgorithmParameterException('You can not mix block and non-block ciphers and modes');
        return false;
    }

    $td = mcrypt_module_open($_algo, '', $_mode, '');

    /* Check key size. */
    $keySize = strlen($key);
    $keySizes = mcrypt_enc_get_supported_key_sizes($td);
    if (count($keySizes) > 0) {
        /* Encryption method requires a specific key size. */
        if (!in_array($keySize, $keySizes)) {
            //throw new \phpSec\Exception\InvalidKeySpecException('Key is out of range. Should be one of: '. implode(', ', $keySizes));
            return false;
        }
    } else {
        /* No specific size is needed. */
        if ($keySize == 0 || $keySize > mcrypt_enc_get_key_size($td)) {
            //throw new \phpSec\Exception\InvalidKeySpecException('Key is out of range. Should be between  1 and ' . mcrypt_enc_get_key_size($td).' bytes.');
            return false;
        }
    }

    /* Using PBKDF with constant salts dedicated to each purpose 
     * can securely derivce two keys from one */
    $key1 = pbkdf2($key, "encrypt", 1, $keySize);
    $key2 = pbkdf2($key, "HMAC", 1, $keySize);

    /* Create IV. */

    $iv = bytes(mcrypt_enc_get_iv_size($td));

    /* Init mcrypt. */
    mcrypt_generic_init($td, $key1, $iv);

    /* Prepeare the array with data. */
    $serializedData = serialize($data);

    /* Enable padding of data if block cipher moode. */
    if (mcrypt_module_is_block_algorithm_mode($_mode) === true) {
        $_padding = true;
    }

    /* Add padding if enabled. */
    if ($_padding === true) {
        $block = mcrypt_enc_get_block_size($td);
        $serializedData = pad($block, $serializedData);
        $encrypted['padding'] = 'PKCS7';
    }

    $encrypted['algo'] = $_algo;                                        /* Algorithm used to encrypt. */
    $encrypted['mode'] = $_mode;                                        /* Algorithm mode. */
    $encrypted['iv'] = base64_encode($iv);                                  /* Initialization vector, just a bunch of randomness. */
    $encrypted['cdata'] = base64_encode(mcrypt_generic($td, $serializedData)); /* The encrypted data. */
    $encrypted['mac'] = base64_encode(                                       /* The message authentication code. Used to make sure the */
        pbkdf2($encrypted['cdata'], $key2, 1, 32)  /* message is valid when decrypted. */
    );
    return json_encode($encrypted);
}

/**
 * Strip PKCS7 padding and decrypt
 * data encrypted by encrypt().
 *
 * @param string $data
 *   JSON string containing the encrypted data and meta information in the
 *   excact format as returned by encrypt().
 *
 * @return mixed
 *   Decrypted data in it's original form.
 */
function decrypt($data, $key)
{

    /* Decode the JSON string */
    $data = json_decode($data, true);

    $dataStructure = array(
        'algo' => true,
        'mode' => true,
        'iv' => true,
        'cdata' => true,
        'mac' => true,
    );

    if ($data === NULL || arrayCheck($data, $dataStructure, false) !== true) {
        //throw new \phpSec\Exception\GeneralSecurityException('Invalid data passed to decrypt()');
        return false;
    }
    /* Everything looks good so far. Let's continue.*/
    $td = mcrypt_module_open($data['algo'], '', $data['mode'], '');
    $block = mcrypt_enc_get_block_size($td);

    /* Using PBKDF with constant salts dedicated to each purpose 
     * can securely derivce two keys from one */
    $keySize = strlen($key);
    $key1 = pbkdf2($key, "encrypt", 1, $keySize);
    $key2 = pbkdf2($key, "HMAC", 1, $keySize);

    /* Check MAC. */
    if (base64_decode($data['mac']) != pbkdf2($data['cdata'], $key2, 1, 32)) {
        //throw new \phpSec\Exception\GeneralSecurityException('Message authentication code invalid');
        return false;
    }

    /* Init mcrypt. */
    mcrypt_generic_init($td, $key1, base64_decode($data['iv']));

    $decrypted = rtrim(mdecrypt_generic($td, base64_decode(stripPadding($block, $data['cdata']))));

    /* Close up. */
    mcrypt_generic_deinit($td);
    mcrypt_module_close($td);

    /*Return decrypted data. */
    return unserialize($decrypted);

}

/**
 * Implement PBKDF2 as described in RFC 2898.
 *
 * @param string $p
 *   Password to protect.
 *
 * @param string $s
 *   Salt.
 *
 * @param integer $c
 *   Iteration count.
 *
 * @param integer $dkLen
 *   Derived key length.
 *
 * @param string $a
 *   A hash algorithm.
 *
 * @return binary
 *   Derived key.
 */
function pbkdf2($p, $s, $c, $dkLen, $a = 'sha256')
{
    $hLen = strlen(hash($a, null, true)); /* Hash length. */
    $l = ceil($dkLen / $hLen);         /* Length in blocks of derived key. */
    $dk = '';                           /* Derived key. */

    /* Step 1. Check dkLen. */
    if ($dkLen > (2 ^ 32 - 1) * $hLen) {
        //throw new \phpSec\Exception\GeneralSecurityException('Derived key too long');
        return false;
    }

    for ($block = 1; $block <= $l; $block++) {
        /* Initial hash for this block. */
        $ib = $b = hash_hmac($a, $s . pack('N', $block), $p, true);
        /* Do block iterations. */
        for ($i = 1; $i < $c; $i++) {
            /* XOR iteration. */
            $ib ^= ($b = hash_hmac($a, $b, $p, true));
        }
        /* Append iterated block. */
        $dk .= $ib;
    }
    /* Returned derived key. */
    return substr($dk, 0, $dkLen);
}

/**
 * PKCS7-pad data.
 * Add bytes of data to fill up the last block.
 * PKCS7 padding adds bytes with the same value that the number of bytes that are added.
 * @see http://tools.ietf.org/html/rfc5652#section-6.3
 *
 * @param integer $block
 *   Block size.
 *
 * @param string $data
 *   Data to pad.
 *
 * @return string
 *   Padded data.
 */
function pad($block, $data)
{
    $pad = $block - (strlen($data) % $block);
    $data .= str_repeat(chr($pad), $pad);

    return $data;
}

/**
 * Strip PKCS7-padding.
 *
 * @param integer $block
 *   Block size.
 *
 * @param string $data
 *   Padded data.
 *
 * @return string
 *   Original data.
 */
function stripPadding($block, $data)
{
    $pad = ord($data[($len = strlen($data)) - 1]);

    /* Check that what we have at the end of the string really is padding, and if it is remove it. */
    if ($pad && $pad < $block && preg_match('/' . chr($pad) . '{' . $pad . '}$/', $data)) {
        return substr($data, 0, -$pad);
    }
    return $data;
}

const PBKDF2 = '$pbkdf2$';
const BCRYPT = '$2y$';
const BCRYPT_BC = '$2a$';
const SHA256 = '$5$';
const SHA512 = '$6$';
const DRUPAL = '$S$';
/**
 * Default hashing method.
 */
$method = BCRYPT;

/**
 * PBKDF2: Iteration count.
 */
$pbkdf2_c = 8192;

/**
 * PBKDF2: Derived key length.
 */
$pbkdf2_dkLen = 128;

/**
 * PBKDF2: Underlying hash method.
 */
$pbkdf2_prf = 'sha256';

/**
 * Bcrypt: Work factor.
 */
$bcrypt_cost = 12;

/**
 * SHA2: Number of rounds.
 */
$sha2_c = 6000;

/**
 * Drupal: Hash length.
 */
$drupal_hashLen = 55;

/**
 * Drupal: Iteration count (log 2).
 */
$drupal_count = 15;

/**
 * Salt charsets.
 */
$charsets = array(
    'itoa64' => './0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz',
);


/**
 * Creates a salted hash from a string.
 *
 * @param string $str
 *     String to hash.
 *
 * @return string
 *     Returns hashed string, or false on error.
 */
function create($str)
{

    switch ($method) {
        case BCRYPT:
            $saltRnd = str(22, $charsets['itoa64']);
            $salt = sprintf('%s%s$%s', BCRYPT, $bcrypt_cost, $saltRnd);
            $hash = crypt($str, $salt);
            break;

        case PBKDF2:
            $salt = bytes(64);
            $hash = pbkdf2($str, $salt, $pbkdf2_c, $pbkdf2_dkLen, $pbkdf2_prf);

            $hash = sprintf('$pbkdf2$c=%s&dk=%s&f=%s$%s$%s',
                $pbkdf2_c,
                $pbkdf2_dkLen,
                $pbkdf2_prf,
                base64_encode($hash),
                base64_encode($salt)
            );
            break;

        case DRUPAL;
            $setting = '$S$';
            $setting .= $tcharsets['itoa64'][$drupal_count];
            $setting .= b64Encode($rand->bytes(6), 6);

            return substr(phpassHash($str, $setting), 0, $drupal_hashLen);
            break;

        case SHA256:
        case SHA512:
            $saltRnd = str(16, $charsets['itoa64']);
            $salt = sprintf('%srounds=%s$%s', $method, $sha2_c, $saltRnd);
            $hash = crypt($str, $salt);
            break;
    }

    if (strlen($hash) > 13) {
        return $hash;
    }
    return false;
}

/**
 * Check a string against a hash.
 *
 * @param string $str
 *   String to check.
 *
 * @param string $hash
 *   The hash to check the string against.
 *
 * @return bool
 *   Returns true on match.
 */
function check($str, $hash)
{


    $hashInfo = getInfo($hash);

    switch ($hashInfo['algo']) {
        case PBKDF2:
            $param = array();
            list(, , $params, $hash, $salt) = explode('$', $hash);
            parse_str($params, $param);

            return timingSafe(pbkdf2($str, base64_decode($salt), $param['c'], $param['dk'], $param['f']), base64_decode($hash));
            break;

        case DRUPAL:
            $test = strpos(phpassHash($str, $hash), $hash);
            if ($test === false || $test !== 0) {
                return false;
            }
            return true;
            break;

        case BCRYPT;
        case BCRYPT_BC;
        case SHA256:
        case SHA512:
            return timingSafe(crypt($str, $hash), $hash);
            break;

        default:
            /* Not any of the supported formats. Try plain hash methods. */
            $hashLen = strlen($hash);
            switch ($hashLen) {
                case 32:
                    $mode = 'md5';
                    break;
                case 40:
                    $mode = 'sha1';
                    break;
                case 64:
                    $mode = 'sha256';
                    break;
                case 128:
                    $mode = 'sha512';
                    break;
                default:
                    return false;
            }
            return timingSafe(hash($mode, $str), $hash);
            break;
    }
}

/**
 * Returns settings used to generate a hash.
 *
 * @param string $hash
 *   Hash to get settings for.
 *
 * @return array
 *   Returns an array with settings used to create $hash.
 */
function getInfo($hash)
{
    $regex_pattern = '/^\$[a-z, 1-6]{1,6}\$/i';
    preg_match($regex_pattern, $hash, $matches);

    if (sizeof($matches) > 0) {
        list($method) = $matches;
    } else {
        $method = null;
    }

    switch ($method) {
        case SHA256:
        case SHA512:
        case PBKDF2:
            $param = array();
            list(, , $params) = explode('$', $hash);
            parse_str($params, $param);
            $info['options'] = $param;
            break;

        case BCRYPT;
            list(, , $cost) = explode('$', $hash);
            $info['options'] = array(
                'cost' => $cost,
            );
            break;
    }
    $info['algo'] = $method;
    return $info;
}

function phpassHash($password, $setting, $method = 'sha512')
{
    /* First 12 characters are the settings. */
    $setting = substr($setting, 0, 12);
    $salt = substr($setting, 4, 8);
    $count = 1 << strpos($charsets['itoa64'], $setting[3]);

    $hash = hash($method, $salt . $password, TRUE);
    do {
        $hash = hash($method, $hash . $password, TRUE);
    } while (--$count);

    $len = strlen($hash);
    $output = $setting . b64Encode($hash, $len);
    $expected = 12 + ceil((8 * $len) / 6);

    return substr($output, 0, $expected);
}

function b64Encode($input, $count)
{
    $itoa64 = $charsets['itoa64'];

    $output = '';
    $i = 0;
    do {
        $value = ord($input[$i++]);
        $output .= $itoa64[$value & 0x3f];
        if ($i < $count) {
            $value |= ord($input[$i]) << 8;
        }
        $output .= $itoa64[($value >> 6) & 0x3f];
        if ($i++ >= $count) {
            break;
        }
        if ($i < $count) {
            $value |= ord($input[$i]) << 16;
        }
        $output .= $itoa64[($value >> 12) & 0x3f];
        if ($i++ >= $count) {
            break;
        }
        $output .= $itoa64[($value >> 18) & 0x3f];
    } while ($i < $count);

    return $output;
}

/**
 * Name of GET variable to pass security token trough.
 */
$getParam = 'pstkn';


/**
 * Create a security token for a URL.
 *
 * @param string $url
 *   URL to create token for.
 *
 * @return string
 *   Return a URL with the security token included.
 */
function createUrl($url)
{
    $part = parse_url($url);

    $appendQuery = false;


    if (isset($part['query'])) {

        $appendQuery = true;

    }

    $request = getRequest($url);
    $token = getToken($request);

    if ($appendQuery === true) {
        return $url . '&' . $getParam . '=' . $token;
    } else {
        return $url . '?' . $getParam . '=' . $token;
    }
}

/**
 * Verify if a URL.
 *
 * @return boolean
 *   Return true if a security token was included in the request
 *   and the URL was not manipulated.
 */
function verify($url = null)
{
    if ($url === null) {
        $url = $_SERVER['REQUEST_URI'];
    }

    $part = parse_url($url);

    if (isset($part['query'])) {

        parse_str($part['query'], $query);
    }

    if (!isset($query[$getParam])) {

        return false;

    }

    $request = getRequest($url);
    if (gettoken($request) === $query[$getParam]) {
        return true;
    }
    return false;
}

/**
 * Get the request from a string to create a security token from.
 *
 * @param string $url
 *   URL to get request striong from.
 *
 * @return string
 *   Request string.
 */
function getRequest($url)
{
    $part = parse_url($url);


    if (isset($part['query'])) {

        parse_str($part['query'], $query);
        if (isset($query[$getParam])) {
            unset($query[$getParam]);
        }
        if (sizeof($query) > 0) {
            $request = $part['path'] . http_build_query($query);
        } else {
            $request = $part['path'];
        }

    } else {

        $request = $part['path'];

    }

    return $request;
}

/**
 * Get a security token from a request.
 *
 * @param string $request
 *   Request to create token from.
 *
 * @return string
 *   Returns a security token.
 */
function getToken($request)
{
    $hash = hash('sha256', $request . getUid());

    return substr($hash, 0, 4) . substr($hash, 16, 4) . substr($hash, 32, 4) . substr($hash, 48, 4);

}

$maxAge = 31536000;

/**
 * Enables HSTS.
 */
function enable()
{
    if (detectHttps() === true) {

        header('Strict-Transport-Security: max-age=' . $maxAge);

    } else {

        header('Location: https://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'], true, 301);

        /* Prevent further execution and output. */

        die();

    }
}

function detectHttps()
{
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') {
        return true;
    }
    return false;
}


//Function to sanitize values received from the form. Prevents SQL injection
function clean($str, $con)
{
    $str = @trim($str);
    if (get_magic_quotes_gpc()) {
        $str = stripslashes($str);
    }
    return mysqli_real_escape_string($con, $str);
}

