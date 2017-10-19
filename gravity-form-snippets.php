<?php 
/*
 * adding random_number parameter to Gravity Forms field
 * use random_number as a parameter for a hidden field to produce a unique ID with each form submit
 * it can be used as a query string for the success-page
 */
add_filter("gform_field_value_random_number", "generate_random_number");
function generate_random_number($value){
   return uniqid();
}
?>
