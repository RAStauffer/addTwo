<?php
// Create class to store info about a number
class numAsStr {
public $string;
public $decimal_pos;
public $length;
public $digits_bef;
public $digits_aft;

function __construct($str) {
  $this->string = $str;
  $this->decimal_pos = strpos($str,".");
  $this->length = strlen($str);
  
  if ($this->decimal_pos === false) {
    $this->decimal_pos = $this->length;
    $this->string = $this->string .".0";
    $this->length += 2;
  }
  
  $this->digits_bef = $this->length - ($this->length - $this->decimal_pos);
  $this->digits_aft = $this->length -  $this->digits_bef - 1;
  }
}

function align (&$a, &$b) {
    $diff = abs($a->digits_bef-$b->digits_bef);
    // Prepending zeros
    if ($a->digits_bef > $b->digits_bef) {
        for ($i = 0; $i < $diff; $i++) {
            $b->string = "0".$b->string;
            $b->length += 1;
            $b->decimal_pos += 1;
            $b->digits_bef += 1;
        }
    } else {
        for ($i = 0; $i < $diff; $i++) {
            $a->string = "0".$a->string;
            $a->length += 1;
            $a->decimal_pos += 1;
            $a->digits_bef += 1;
        }
    }
    
    // Appending zeros
    $diff = abs($a->digits_aft-$b->digits_aft);
    if ($a->digits_aft > $b->digits_aft) {
        for ($i = 0; $i < $diff; $i++) {
            $b->string = $b->string."0";
            $b->length += 1;
            $b->digits_aft += 1;
        }
    } else {
        for ($i = 0; $i < $diff; $i++) {
            $a->string = $a->string."0";
            $a->length += 1;
            $a->digits_aft += 1;
        }
    }
}

function addTwo ($a, $b) {
//print ($a . " + ". $b . " = ");
$a = new numAsStr($a);
$b = new numAsStr($b);

align ($a, $b);

$carry = false;
$output = "";
// Do digit arithmatic R to L and count from decimal position (dpos) starting at 1
for ($i = $a->length - 1,$dpos = 1; $i >= 0; $i--,$dpos++) {
  if ($dpos == $a->length - $a->decimal_pos) {
    $output = "." . $output;
    continue;
  }
  
  $num = (int)$a->string[$i] + (int)$b->string[$i];
  if ($carry == true) $num = $num+1;
  if ($num >= 10) { // Carry and get lower digit using modulo
    $carry = true;
    $digit = $num % 10;
  } else {
    $carry = false;
    $digit = $num;
  }
  $output= $digit . $output;
  
}
if ($carry ==  true) $output = "1". $output;
$output = trim($output,"0");
$output = rtrim($output,".");
print ($output."\n");
}

addTwo ("3.12", "4000.12"); 

addTwo ("3", "4000.12");
addTwo ("3", "4000");
addTwo ("3.0", "4000.12");
addTwo ("3.12", "4000.0");
addTwo ("3.0", "4000.0");
addTwo ("30000000000000000000000000000001", "4000.12");
addTwo ("390000000000000000000000000000001", "4000.12");

addTwo ("7.12", "4003.12");
addTwo ("7000", "4000.12");
addTwo ("7", "4000");
addTwo ("7.0", "4000.12");
addTwo ("7.12", "4000.0");
addTwo ("7.0", "4000.0");
addTwo ("70000000000000000000000000000003", "4007.12");
addTwo ("790000000000000000000000000000001", "4000.12");

addTwo("999999","1");

?>