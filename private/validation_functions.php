<?php


// *valida la presencia de datos
// usa trim() para que los espacios vacíos no cuenten como caracteres. 
// usa === para evitar falsos positivos
// mejor usar trim() que empty() pues este segundo considera que "0" implicaría estar vacío.
// esta función retorna true/false (está vacío ? true o false)
function is_blank($value)
{
    return !isset($value) || trim($value) === '';
}

// valida la presencia de datos
// es lo contrario de is_blank() (está lleno? true o false?)
// utiliza la función anterior para validar si un valor está o no presente. 

function has_presence($value)
{
    // si tiene presencia devolverá true, si no devolverá false; 
    return !is_blank($value);
}

// valida la longitud de un string
// los espacios cuentan en esa longitud
// si no queremos que cuenten los espacios, usar trim()
function has_length_greater_than($value, $min)
{
    //strlen — Obtiene la longitud de un string
    $length = strlen($value);
    // Deuelve si es true o false que $length tiene mayor longitud que $min
    return $length > $min;
}

function has_length_less_than($value, $max)
{
    $length = strlen($value);
    return $length < $max;
}

function has_length_exactly($value, $exact)
{
    $length = strlen($value);
    return $length == $exact;
}

// puede pasar valores mínimos y máximos
// combina las funcioknes greater_than, less_than y _exactly
// los espacios cuentan como caracteres
// usa trim() si los espacios no debieran contarse. 

function has_length($value, $options)
{
    // si se ha fijado el valor $options['min'] y aplicando la función has_length_greater tenemos que $value no es mayor que $options['min] -1, 
    // devuelve falso; 
    if (isset($options['min']) &&  !has_length_greater_than($value, $options['min'] - 1)) {
        return false;
    } elseif (isset($options['max']) &&  !has_length_less_than($value, $options['max'] + 1)) {
        return false;
    } elseif (isset($options['exact']) &&  !has_length_exactly($value, $options['exact'])) {
        return false;
    } else {
        return true;
    }
}

// valida la inclusión de un $value dentro de un array($set)
// php tiene una función para ello, in_array() que devuelve true/false; 
function has_inclusion_of($value, $set){
    return in_array($value, $set); 
}

function has_exclusion_of($value, $set){
    return !in_array($value, $set);
}

// valida la inclusión de un caracter o caracteres
//strpos() devuelve la posición de inicio de un string o false; 
// usa !== false para prevenir que la posición 0 sea considerada como false; 
// strpos() es más rápida que preg_match(); 
function has_string($value, $required_string){
    return strpos($value, $required_string) !== false; 
}

// valida formato de mail
// formato: [chars]@[chars].[2+letters]
// preg_match usa una expresión regular y devuelve 1 si hay match y 0 si no lo hay
function has_valid_email_format($value){
    $email_regex = '/\A[A-Z0-9._%+-]+@[A-Z0-9.-]+\.[A-Z]{2,}\Z/i';
    return preg_match($email_regex, $value) === 1; 
}