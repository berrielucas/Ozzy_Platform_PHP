<?php

class Url
{
    public static function getURI()
    {
        return $_SERVER['REQUEST_URI'];
    }

    public static function getMethod()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function decode()
    {

        $route = substr(self::getURI(), 1);
        $route_parts = explode("?", $route);
        if (count($route_parts)==1) {
            $URL_DECODED["params"] = self::explode_params($route_parts[0]);
            return $URL_DECODED;
        }
        $URL_DECODED["params"] = self::explode_params($route_parts[0]);
        $URL_DECODED["query"] = self::explode_query($route_parts[1]);
        return $URL_DECODED;
    }

    public static function explode_params($params)
    {
        if ($params!="") {
            $prs = explode("/", $params);
            if ($prs[count($prs)-1]=="") {
                array_pop($prs);
            }
            return $prs;
        }
        return ["/"];
    }

    public static function explode_query($q)
    {
        $list_query = [];
        $list = explode("&", $q);
        for($i=0; $i<count($list);$i++) {
            $key_value = explode("=", $list[$i]);
            if (count($key_value)==2&&$key_value[1]!="") {
                // var_dump($key_value);
                $query = [];
                $query[$key_value[0]] = $key_value[1];
                $list_query[$i] = $query;
            }
        }
        if (count($list_query)>0) {
            return $list_query;
        }
        return false;
    }
}

?>