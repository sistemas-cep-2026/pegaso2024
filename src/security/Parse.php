<?php
class Parse
{
    final public static function Clean($property)
    {
        $property = trim($property);
        $property = stripslashes($property);
        $property = htmlspecialchars($property);
        $property = str_replace("'","&#39;",$property);

        return $property;
    }
}
