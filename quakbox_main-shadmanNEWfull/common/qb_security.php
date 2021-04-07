<?php
class QB_SqlInjection
{
	/**
*
* QbSqlInjection class prevents the sql injection and xss attack.
*
* @class QbSqlInjection

*/

/* function uses to generate a random code */
function QbgenerateRandomString($length = 10) { //$length : default defined variable always the length of code is 10
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // can be mixing of these strings and characters
    $charactersLength = strlen($characters); // $charactersLength : stores thge length of $characters , always 62.
    $randomString = ''; // declare a variable by assigning value null
    for ($i = 0; $i < $length; $i++) { // check the generated code length upto 10
        $randomString .= $characters[rand(0, $charactersLength - 1)]; //$randomString stores 10 coded randoum number between the length 0 ,61
    }
    return $randomString; // here result of this function ,10 coded random number
}

	/**
	* This function used to encrypt the variable with an encryption key which is defined by programmers
	*/
function Qbencrypt($pure_string,$encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
	/*
	mcrypt_get_iv_size Returns the size of the IV belonging to a specific cipher/mode combination..
	here is the combinations MCRYPT_BLOWFISH and MCRYPT_MODE_ECB cipher
	*/
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND); // mcrypt_create_iv : Creates an initialization vector (IV) from a random source
    $encrypted_string = mcrypt_encrypt(MCRYPT_BLOWFISH, $encryption_key, utf8_encode($pure_string), MCRYPT_MODE_ECB, $iv);
	// mcrypt_encrypt :Encrypts plaintext with given parameters
    return $encrypted_string; // code return to the function
}

/**
 * This function Returns decrypted original string
 */
function Qbdecrypt($encrypted_string, $encryption_key) {
    $iv_size = mcrypt_get_iv_size(MCRYPT_BLOWFISH, MCRYPT_MODE_ECB);
		/* Returns the size of the IV belonging to a specific cipher/mode combination.. here is the combinations MCRYPT_BLOWFISH and MCRYPT_MODE_ECB cipher
		should be same as encrypt */

    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypted_string = mcrypt_decrypt(MCRYPT_BLOWFISH, $encryption_key, $encrypted_string, MCRYPT_MODE_ECB, $iv);
	// mcrypt_decrypt :decrypt encrypted string with given parameters
    return $decrypted_string;
}

/**
 * This function Returns clean variables with no scope of sql injection
 */
function qbClean($str,$con) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
		// is turned on for the copy of PHP you are using all Get, Post & Cookie variables (gpc, get it?) in PHP will already have special characters like ", ' and \ escaped so it is safe to put them directly into an SQL query.
			$str = stripslashes($str);//Un-quotes a quoted string
		}
		return mysqli_real_escape_string($con,$str); // Escapes special characters in a string for use in an SQL statement
	}

function qbCheckSpecialChars($variable)
{
if (preg_match('/[\'^£$%&*()}{@#~?><>,"|=_+¬-]/', $variable))
{
 return false;
}
else
{
return true;
}
}
function qbErrorMessage($error_message,$return_page)
{

echo '<div style="background-color:#e3f7fc;
    color:#555;
    border:.1em solid;
    border-color: #8ed9f6;
    border-radius:10px;
    font-family:Tahoma,Geneva,Arial,sans-serif;
    font-size:1.1em;
    padding:250px 30px 10px 40px;
    margin:10px;
    height:1000px;

    cursor: default;">
<h3 align="center" style="color: #D8000C;">'.$error_message.'</h3>
<h4 align="center" style="color:##3333CC;"><a href="'.$return_page.'">Back To Home</a></h4>
</div>';
return true;

}

/**
 * Translates a number to a short alhanumeric version
 *
 * Translated any number up to 9007199254740992
 * to a shorter version in letters e.g.:
 * 9007199254740989 --> PpQXn7COf
 *
 * specifiying the second argument true, it will
 * translate back e.g.:
 * PpQXn7COf --> 9007199254740989
 *
 * this function is based on any2dec && dec2any by
 * fragmer[at]mail[dot]ru
 * see: http://nl3.php.net/manual/en/function.base-convert.php#52450
 *
 * If you want the alphaID to be at least 3 letter long, use the
 * $pad_up = 3 argument
 *
 * In most cases this is better than totally random ID generators
 * because this can easily avoid duplicate ID's.
 * For example if you correlate the alpha ID to an auto incrementing ID
 * in your database, you're done.
 *
 * The reverse is done because it makes it slightly more cryptic,
 * but it also makes it easier to spread lots of IDs in different
 * directories on your filesystem. Example:
 * $part1 = substr($alpha_id,0,1);
 * $part2 = substr($alpha_id,1,1);
 * $part3 = substr($alpha_id,2,strlen($alpha_id));
 * $destindir = "/".$part1."/".$part2."/".$part3;
 * // by reversing, directories are more evenly spread out. The
 * // first 26 directories already occupy 26 main levels
 *
 * more info on limitation:
 * - http://blade.nagaokaut.ac.jp/cgi-bin/scat.rb/ruby/ruby-talk/165372
 *
 * if you really need this for bigger numbers you probably have to look
 * at things like: http://theserverpages.com/php/manual/en/ref.bc.php
 * or: http://theserverpages.com/php/manual/en/ref.gmp.php
 * but I haven't really dugg into this. If you have more info on those
 * matters feel free to leave a comment.
 *
 * The following code block can be utilized by PEAR's Testing_DocTest
 * <code>
 * // Input //
 * $number_in = 2188847690240;
 * $alpha_in  = "SpQXn7Cb";
 *
 * // Execute //
 * $alpha_out  = alphaID($number_in, false, 8);
 * $number_out = alphaID($alpha_in, true, 8);
 *
 * if ($number_in != $number_out) {
 *	 echo "Conversion failure, ".$alpha_in." returns ".$number_out." instead of the ";
 *	 echo "desired: ".$number_in."\n";
 * }
 * if ($alpha_in != $alpha_out) {
 *	 echo "Conversion failure, ".$number_in." returns ".$alpha_out." instead of the ";
 *	 echo "desired: ".$alpha_in."\n";
 * }
 *
 * // Show //
 * echo $number_out." => ".$alpha_out."\n";
 * echo $alpha_in." => ".$number_out."\n";
 * echo alphaID(238328, false)." => ".alphaID(alphaID(238328, false), true)."\n";
 *
 * // expects:
 * // 2188847690240 => SpQXn7Cb
 * // SpQXn7Cb => 2188847690240
 * // aaab => 238328
 *
 * </code>
 *
 * @author	Kevin van Zonneveld <kevin@vanzonneveld.net>
 * @author	Simon Franz
 * @author	Deadfish
 * @author  SK83RJOSH
 * @copyright 2008 Kevin van Zonneveld (http://kevin.vanzonneveld.net)
 * @license   http://www.opensource.org/licenses/bsd-license.php New BSD Licence
 * @version   SVN: Release: $Id: alphaID.inc.php 344 2009-06-10 17:43:59Z kevin $
 * @link	  http://kevin.vanzonneveld.net/
 *
 * @param mixed   $in	  String or long input to translate
 * @param boolean $to_num  Reverses translation when true
 * @param mixed   $pad_up  Number or boolean padds the result up to a specified length
 * @param string  $pass_key Supplying a password makes it harder to calculate the original ID
 *
 * @return mixed string or long
 */
function QB_AlphaID($in, $to_num = false, $pad_up = false, $pass_key = null)
{
	$out   =   '';
	$index = 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$base  = strlen($index);

	if ($pass_key !== null) {
		// Although this function's purpose is to just make the
		// ID short - and not so much secure,
		// with this patch by Simon Franz (http://blog.snaky.org/)
		// you can optionally supply a password to make it harder
		// to calculate the corresponding numeric ID

		for ($n = 0; $n < strlen($index); $n++) {
			$i[] = substr($index, $n, 1);
		}

		$pass_hash = hash('sha256',$pass_key);
		$pass_hash = (strlen($pass_hash) < strlen($index) ? hash('sha512', $pass_key) : $pass_hash);

		for ($n = 0; $n < strlen($index); $n++) {
			$p[] =  substr($pass_hash, $n, 1);
		}

		array_multisort($p, SORT_DESC, $i);
		$index = implode($i);
	}

	if ($to_num) {
		// Digital number  <<--  alphabet letter code
		$len = strlen($in) - 1;

		for ($t = $len; $t >= 0; $t--) {
			$bcp = bcpow($base, $len - $t);
			$out = $out + strpos($index, substr($in, $t, 1)) * $bcp;
		}

		if (is_numeric($pad_up)) {
			$pad_up--;

			if ($pad_up > 0) {
				$out -= pow($base, $pad_up);
			}
		}
	} else {
		// Digital number  -->>  alphabet letter code
		if (is_numeric($pad_up)) {
			$pad_up--;

			if ($pad_up > 0) {
				$in += pow($base, $pad_up);
			}
		}

		for ($t = ($in != 0 ? floor(log($in, $base)) : 0); $t >= 0; $t--) {
			$bcp = bcpow($base, $t);
			$a   = floor($in / $bcp) % $base;
			$out = $out . substr($index, $a, 1);
			$in  = $in - ($a * $bcp);
		}
	}

	return $out;
}




}
/* Create object for class  QbSqlInjection  */
$QbSecurity=new QB_SqlInjection;
