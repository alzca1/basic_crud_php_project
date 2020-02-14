<?php


// función para añadir de forma dinámica la ruta definida en WWW_ROOT
// se puede utilizar dentro de los href incluyendo siempre "echo"
// y la función con la ruta relativa del archivo respecto a public
// por ejemplo '/stylesheets/staff.css'


function url_for($script_path)
{
    if ($script_path[0] != '/') {
        $script_path = "/" . $script_path;
    }
    return WWW_ROOT . $script_path;
}


function u($string = "")
{
    return urlencode($string);
}

function raw_u($string = "")
{
    return rawurlencode($string);
}

function h($string = "")
{

    return htmlspecialchars($string);
}

function error_404()
{

    header($_SERVER["SERVER_PROTOCOL"] . " 404 Not Found");
    exit();
}


function error_500()
{
    header($_SERVER["SERVER_PROTOCOL"] . " 500 Internal Server Error");
    exit();
}

function redirect_to($location)
{
    header("Location: " . $location);
    exit;
}


function is_post_request()
{
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}


function is_get_request()
{
    return $_SERVER['REQUEST_METHOD'] === 'GET';
}

function is_checked($variable){
    if($variable > 0){
        return "checked"; 
    }
}

function is_selected($number, $variable){
 if($number == $variable){
     return 'selected';
 }
}

function display_errors($errors=array()){
    $output = ''; 
    if(!empty($errors)){
        $output .= "<div class=\"errors\">"; 
        $output .= "Please fix the following errors:"; 
        $output .= "<ul>"; 
        foreach($errors as $error){
            $output .="<li>" .h($error) . "</li>"; 
        }
        $output .="</ul>";
        $output .="</div>"; 
    }
    return $output; 
}
