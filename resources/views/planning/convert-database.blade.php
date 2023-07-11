<?php
if (!function_exists('convert_databases_name')) {
    function convert_databases_name($database_id) {
        if($database_id == 1){
            return "IEEE";
        }
        else if($database_id == 2){
            return "Scopus";
        }
        else if($database_id == 3){
            return "Science Direct";
        }
        else if($database_id == 4){
            return "Engineering Village";
        }
        else if($database_id == 5){
            return "Springer Link";
        }
        else{
            return "Not Found";
        }
    }
}
