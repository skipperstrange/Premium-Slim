<?php
/**
 * This file contains system functions 
 */

//get a cofiguration value
function get_config(string $key){
    global $config;
    return @$config[$key];
}

//get a cofiguration value from custom config file
function getr_config(string $config_file, string $key){
    load_config($config_file);
    return get_config($key);
}

//set a cofiguration value
function set_config(string $key, $value){
    global $config;
    return $config[$key] = $value;
}

//system encryption function. uses encrypt option in config file config 
function encrypt($value, $hash = ['sha512']){
    $enc_opt = get_config('encryption');
    foreach($hash as $h => $function){
        $value = hash($function, $value);
    }
    $value = ($enc_opt['enable'] == true)? crypt($value, $enc_opt['salt']) : $value;
  return  $value;
}

//loads files. return set to true returns full file path
function load_file(string $file, $return = false){
    if($return){
        return $file;
    }
    include_once $file;
}

//load a config file
function load_config(string $file){
    load_file(CONFIG_PATH.$file.'.php');
}

//load and instatiate class from anywhere
function load_class(string $file = null,  $instantiate=false , $class_name = ''){
    if(trim($file) !== '' ){
        load_file($file.'.php');
        if($instantiate == true){
            if(trim($class_name) !== ''){
                if(class_exists($class_name)){
                    return new $class_name();
                }
            }
        return $file = new $file();
        }
    }
}


//Sets title of pages
function set_page_title( $title=''){
    global $config;
    if(trim($title) == ''){
        return $config['page_title'] = APP;
    }
    return $config['page_title'] = APP.' - '.$title;
}

function json_response($message = null, $code = 200, $headers = [''])
{
    // clear the old headers
    header_remove();
    // set the actual code
    http_response_code($code);

    // set the header to make sure cache is forced
    header("Cache-Control: no-transform,public,max-age=300,s-maxage=900");
    // treat this as json
    header('Content-Type: application/json');
    if(count($headers) > 0):
        foreach($headers as $header => $value){
            header("$header: $value");
        }
    endif;
    $status = array(
        200 => '200 OK',
        201 => '201 Created',
        204 => '204 No Content',
        205 => 'Reset Content',
        304 => 'Not Modified',
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        402 => '402 Payment Required',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        408 => '408 Request Timeout',
        422 => '422 Unprocessable Entity',
        500 => '500 Internal Server Error'
        );
    // ok, validation error, or failure
    header('Status: '.$status[$code]);
    // return the encoded json
    return json_encode(array(
        'status' => $code , // success or not?
        'message' => $message
        ));
}