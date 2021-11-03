<?php

use Illuminate\Support\Str;

if (!function_exists('is_boolean')) {

  function is_boolean($var)
  {
    if (is_bool($var)) {
      return true;
    }

    if ((!is_string($var)) && (!is_numeric($var))) {
      return false;
    }

    switch (strtolower($var))
    {
      case '0':
      case '1':
      case 'false':
      case 'true':
      case 'f':
      case 't':
      case 'v':
      case 'off':
      case 'on':
      case 'no':
      case 'yes':
      case 'n':
      case 'y':
      case 'nao':
      case 'não':
      case 'sim':
      case 's':
        return true;
      default:
        return false;
    }
  }

}

if (!function_exists('uuid_v4')) {
  function uuid_v4()
  {
    return \Ramsey\Uuid\Uuid::uuid4()->toString();
  }
}


if(!function_exists('uuid_to_hex')){
  function uuid_to_hex($uuid) {
    return str_replace('-', '', $uuid);
  }
}

if (! function_exists('str_random')) {
  /**
   * Generate a more truly "random" alpha-numeric string.
   *
   * @param  int  $length
   * @return string
   *
   * @throws \RuntimeException
   */
  function str_random($length = 16)
  {
    return Str::random($length);
  }
}

if (!function_exists('to_boolean')) {

  function to_boolean($var)
  {
    if (!is_string($var)) {
      return (bool) $var;
    }

    switch (strtolower($var))
    {
      case '1':
      case 'true':
      case 't':
      case 'on':
      case 'yes':
      case 'y':
      case 'sim':
      case 's':
        return true;
      default:
        return false;
    }
  }

}

if ( ! function_exists('random_password'))
{

  function random_password( ?int $length = 14,
                            ?string $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890'
  ): string
  {
    $pass = []; //remember to declare $pass as an array
    for ($i = 0; $i < $length; $i++) {
      $n = rand(0, strlen($alphabet) -1);
      $pass[] = $alphabet[$n];
    }
    return implode($pass); //turn the array into a string
  }

}

if (!function_exists('random_string')) {

  function random_string($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';

    for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
    }

    return $randomString;
  }

}

if(! function_exists('convert_json_detail')) {
  /**
   * @param array $errors
   * @param int $code
   * @return array
   */
  function convert_json_detail(array $errors,int $code = 422)
  {
    $countErrors = 0;
    $result = [];

    foreach ($errors as $title => $details)
    {
      foreach ($details as $detail)
      {
        $result['errors'][$countErrors]['code'] = $code;
        $result['errors'][$countErrors]['title'] = $title;
        $result['errors'][$countErrors]['detail'] = $detail;
      }
      $countErrors++;
    }

    return $result;
  }
}

if (!function_exists('is_empty')) {

  function is_empty($value, $defaultCheck = false)
  {
    if ($defaultCheck) {
      return empty($value);
    }

    if (is_collection($value)) {
      return $value->isEmpty();
    }

    if (empty($value) && (($value === false) || ($value == '0'))) {
      return false;
    }

    return empty($value);
  }

}

if (!function_exists('is_collection')) {

  function is_collection($value)
  {
    return is_a($value, "\Illuminate\Support\Collection") || is_a($value, "\Illuminate\Database\Eloquent\Collection");
  }

}

if (!function_exists('is_not_empty')) {

  function is_not_empty($value, $defaultCheck = false)
  {
    return (!is_empty($value, $defaultCheck));
  }

}

if (!function_exists('get')) {

  /**
   * Get value of given target<br>
   * If array or object get an item using "dot" notation.
   *
   * @param  mixed   $target
   * @param  mixed   $key|$default
   * @param  mixed   $default
   * @return mixed
   */
  function get()
  {
    $args = func_get_args();
    $target = $key = $default = null;
    $trim = true;

    switch (func_num_args())
    {
      case 0: return;
      case 1:
        $target = $args[0];
        break;
      case 2:
        $target = $args[0];
        if(is_array($target) || is_object($target)) {
          $key = $args[1];
        } else {
          $default = $args[1];
        }
        break;

      default:
        $target = $args[0];
        $key = $args[1];

        if(array_key_exists(3, $args)) {
          $default = $args[2];
          $trim = $args[3];
        } else {
          $default = $args[2];
        }

        break;
    }

    if (is_array($target) || is_object($target)) {
      $value = data_get($target, $key, $default);
    } else {
      $value = (is_not_empty($target) ? $target : $default);
    }

    if($trim && is_string($value)) {
      $value = trim($value);
    }

    return $value;
  }

}

if (!function_exists('var_get')) {

  /**
   * Get value of given target<br>
   * If array or object get an item using "dot" notation.
   *
   * @param  mixed   $target
   * @param  mixed   $key|$default
   * @param  mixed   $default
   * @return mixed
   */
  function var_get()
  {
    return call_user_func_array("get", func_get_args());
  }

}

if (!function_exists('encryptjs')) {
  function encryptjs ($message, $method, $secret, &$hmac) {
    //$iv = substr(bin2hex(openssl_random_pseudo_bytes(16)),0,16);    //use this in production
    $iv = substr($secret, 0, 16);        //using this for testing purposes (to have the same encryption IV in PHP and Node encryptors)
    $encrypted = base64_encode($iv) . openssl_encrypt($message, $method, $secret, 0, $iv);
    $hmac = hash_hmac('md5', $encrypted, $secret);
    return $encrypted;
  }
}

if (!function_exists('decryptjs')) {
  function decryptjs ($encrypted, $method, $secret, $hmac) {
    if (hash_hmac('md5', $encrypted, $secret) == $hmac) {
      $iv = base64_decode(substr($encrypted, 0, 24));
      return openssl_decrypt(substr($encrypted, 24), $method, $secret, 0, $iv);
    }
  }
}

if (!function_exists('encryptjs_ts_validation')) {
  function encryptjs_ts_validation ($message, $method, $secret, &$hmac) {
    date_default_timezone_set('UTC');
    $message = substr(date('c'),0,19) . "$message";
    return encryptjs($message, $method, $secret, $hmac);
  }
}

if (!function_exists('decryptjs_ts_validation')) {
  function decryptjs_ts_validation ($encrypted, $method, $secret, $hmac, $intervalThreshold) {
    $decrypted = decryptjs($encrypted, $method, $secret, $hmac);
    $now = new DateTime();
    $msgDate = new DateTime(str_replace("T"," ",substr($decrypted,0,19)));
    if (($now->getTimestamp() - $msgDate->getTimestamp()) <= $intervalThreshold) {
      return substr($decrypted,19);
    }
  }
}

if (!function_exists('compare')) {

  function compare($value, $operator, $filter = null, bool $caseInsensitive = true, bool $unaccent = true, bool $trimmed = true)
  {
    $v = $value;
    $f = $filter;

    if ($caseInsensitive === true) {
      $v = is_array($v) ? array_map('mb_strtolower', $v) : mb_strtolower($v);
      $f = is_array($f) ? array_map('mb_strtolower', $f) : mb_strtolower($f);
    }

    if ($unaccent === true) {
      $v = is_array($v) ? array_map('unaccent', $v) : unaccent($v);
      $f = is_array($f) ? array_map('unaccent', $f) : unaccent($f);
    }

    if ($trimmed === true) {
      $v = is_array($v) ? array_map('trim', $v) : trim($v);
      $f = is_array($f) ? array_map('trim', $f) : trim($f);
    }

    switch ($operator) {
      case '=':
        return $v == $f;
      case '===':
        return $v === $f;
      case '<>':
      case '!=':
        return $v != $f;
      case '!==':
        return $v !== $f;
      case '>':
        if ($v instanceof \Carbon\Carbon && $f instanceof \Carbon\Carbon) {
          return $v->gt($f);
        } else {
          return $v > $f;
        }
      case '>=':
        if ($v instanceof \Carbon\Carbon && $f instanceof \Carbon\Carbon) {
          return $v->gte($f);
        } else {
          return $v >= $f;
        }
      case '<':
        if ($v instanceof \Carbon\Carbon && $f instanceof \Carbon\Carbon) {
          return $v->lt($f);
        } else {
          return $v < $f;
        }
      case '<=':
        if ($v instanceof \Carbon\Carbon && $f instanceof \Carbon\Carbon) {
          return $v->lte($f);
        } else {
          return $v <= $f;
        }
      case 'contains':
        return (stripos($v, $f) !== false);
      case '!contains':
        return (stripos($v, $f) === false);
      case 'in':
        $list = explode(',', $f);
        return (count($list) > 0 && in_array($v, $list));
      case '!in':
        $list = explode(',', strtolower($f));
        return (count($list) > 0 && ( ! in_array($v, $list)));
      case 'between':
        $list = explode(',', $filter);
        if(is_numeric($v)) {
          return ((count($list) === 2) && is_numeric($f[0]) && is_numeric($f[1]) &&
            ($v >= $f[0]) && ($v <= $f[1]));
        } else if ($v instanceof \Carbon\Carbon) {
          return $v->between($f[0], $f[1]);
        }

        return false;
      case '!between':
        $list = explode(',', $filter);
        if(is_numeric($v)) {
          return ((count($list) === 2) && is_numeric($f[0]) && is_numeric($f[1]) &&
            ( ! (($v >= $f[0]) && ($v <= $f[1]))));
        } else if ($v instanceof \Carbon\Carbon) {
          return ! $v->between($f[0], $f[1]);
        }

        return false;
      case 'empty':
        return is_empty($v);
      case '!empty':
        return is_not_empty($v);
      default:
        false;
        break;
    }
  }

}

if (!function_exists('current_locale')) {

  function current_locale(): string
  {
    # From user if authenticated
    if ( ! \Auth::guest()) {
      return \Auth::user()->getLang();
    }

    # From App Config
    return \Config::get('app.locale');
  }

}

if (!function_exists('object_to_array')) {

  function object_to_array($obj)
  {
    if (is_object($obj))
      $obj = (array) $obj;
    if (is_array($obj)) {
      $new = array();
      foreach ($obj as $key => $val) {
        $new[$key] = object_to_array($val);
      }
    } else
      $new = $obj;
    return $new;
  }
}

if (!function_exists('extract_numbers_from_string')) {

  /**
   * Extract numbers from a given string<br />
   * Returns as a string type to not broke left zeros
   *
   * @param  string   $value
   * @return string
   */
  function extract_numbers_from_string($value)
  {
    if (is_empty($value)) {
      return null;
    }

    preg_match_all('/\d+/', $value, $matches);
    return implode("", $matches[0]);
  }

if(! function_exists('convert_error_return')) {

  /**
   * @param array $data
   * @return array
   */
  function convert_error_return(array $data)
  {
    $result = [];

    foreach ($data as $key => $value)
    {
      $result['errors'][$key]  = $value;
    }
    return $result;
  }
}

}

if (!function_exists('validar_cpf')) {

  function validar_cpf($cpf)
  {
    $cpf = preg_replace('/[^0-9]/', '', (string)$cpf);

    if (count(array_count_values(str_split($cpf))) === 1) {
      return false;
    }

    // Valida tamanho
    if (strlen($cpf) != 11)
      return false;
    // Calcula e confere primeiro dígito verificador
    for ($i = 0, $j = 10, $soma = 0; $i < 9; $i++, $j--)
      $soma += $cpf[$i] * $j;
    $resto = $soma % 11;
    if ($cpf[9] != ($resto < 2 ? 0 : 11 - $resto))
      return false;
    // Calcula e confere segundo dígito verificador
    for ($i = 0, $j = 11, $soma = 0; $i < 10; $i++, $j--)
      $soma += $cpf[$i] * $j;

    $resto = $soma % 11;

    return $cpf[10] == ($resto < 2 ? 0 : 11 - $resto);
  }

}

if (!function_exists('name_format')) {

  function name_format($value, $lang = 'pt_BR')
  {
    if ($lang === 'pt_BR') {
      $exceptions = [
        ' Da ', ' Das ', ' De ', ' Des ', ' Di ', ' Dis ', ' Do ', ' Dos ', ' Du ', ' Dus ',
        ' Na ', ' Nas ', ' Ne ', ' Nes ', ' Ni ', ' Nis ', ' No ', ' Nos ', ' Nu ', ' Nus ',
        ' E ', ' Es ', ' Em '
      ];
    } else {
      $exceptions = [];
    }

    mb_internal_encoding('UTF-8');

    $exceptionsReplace = array_map('mb_strtolower', $exceptions);


    return trim(
      remove_emoji(
        preg_replace('!\s+!', ' ', str_replace($exceptions, $exceptionsReplace, mb_convert_case($value, MB_CASE_TITLE, "UTF-8")))
      )
    );
  }

}

if ( ! function_exists('remove_emoji')) {

  function remove_emoji($string){
    return preg_replace('/([0-9|#][\x{20E3}])|[\x{00ae}|\x{00a9}|\x{203C}|\x{2047}|\x{2048}|\x{2049}|\x{3030}|\x{303D}|\x{2139}|\x{2122}|\x{3297}|\x{3299}][\x{FE00}-\x{FEFF}]?|[\x{2190}-\x{21FF}][\x{FE00}-\x{FEFF}]?|[\x{2300}-\x{23FF}][\x{FE00}-\x{FEFF}]?|[\x{2460}-\x{24FF}][\x{FE00}-\x{FEFF}]?|[\x{25A0}-\x{25FF}][\x{FE00}-\x{FEFF}]?|[\x{2600}-\x{27BF}][\x{FE00}-\x{FEFF}]?|[\x{2900}-\x{297F}][\x{FE00}-\x{FEFF}]?|[\x{2B00}-\x{2BF0}][\x{FE00}-\x{FEFF}]?|[\x{1F000}-\x{1F6FF}][\x{FE00}-\x{FEFF}]?/u', '', $string);
  }

}
