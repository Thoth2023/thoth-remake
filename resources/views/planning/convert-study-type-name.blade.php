<?php
if (!function_exists('convert_study_type_name')) {
    function convert_study_type_name($study_type_id) {
        if($study_type_id == 1){
            return "Book";
        }
        else if($study_type_id == 2){
            return "Thesis";
        }
        else if($study_type_id == 3){
            return "Article in Press";
        }
        else if($study_type_id == 4){
            return "Article";
        }
        else if($study_type_id == 5){
            return "Conference Paper";
        }
        else{
            return "Not Found";
        }
    }
}
