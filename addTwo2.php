<?php
// Create class to store info about a number
class numAsStr {
    public $chars;
    public $length;
    public $decimal;
    
    function __construct($str) {
      $this->decimal = strpos($str,".");
      $this->length = strlen($str);
      if ($this->decimal === false) {
          $this->decimal = $this->length;
          $str = $str . ".0";
          $this->length += 2;
      }
      $this->chars = str_split($str,1);
    }
}

function align(&$a,&$b) {
    $deca = $a->decimal;
    $decb = $b->decimal;
    $num = abs($deca - $decb);
    if ($deca < $decb) {
        // add array elements at start with 0
        for ($i = 0; $i < $num; $i++) {
            array_unshift($a->chars,"0");
            $a->decimal++;
            $a->length++;
        }
    } else {
        for ($i = 0; $i < $num; $i++) {
            array_unshift($b->chars,"0");
            $b->decimal++;
            $b->length++;
        }
    }
    $diff = abs($a->length - $b->length)-1;
    if ($a->length < $b->length) {
        for ($i=0; $i <= $diff;$i++) {
            array_push ($a->chars,"0");
            $a->length++;
        }
    }else {
        for ($i=0; $i <= $diff;$i++) {
           array_push ($b->chars,"0") ;
           $b->length++;
        }
    }
    
}

function addTwo ($a, $b) {
    $a = new numAsStr($a);
    $b = new numAsStr($b);
    align ($a, $b);
    
    $carry = false;
    $output = "";
    for ($i=$a->length-1;$i>=0;$i--) {
        if ($a->chars[$i] == ".") {
            $output = ".".$output;
            continue;
        }
        $sum = (int)$a->chars[$i] + (int)$b->chars[$i];
        if ($carry == true) {
            $sum += 1;
        }
        if ($sum >= 10) {
           $digit= $sum % 10;
           $carry = true;
        } else {
            $digit = $sum;
            $carry = false;
        }
        $output = $digit.$output;
    }
    if ($carry == true) {
        $output = "1".$output;
    }
    $output = rtrim($output,"0");
    $output = rtrim($output,".");
    return ($output);
}

print addTwo("4000","4000")."\n";
print addTwo("3.123","4000")."\n";
print addTwo("3","4000.123")."\n";
print addTwo("3.123","4000.0000")."\n";
print addTwo("9.999","1.001")."\n";
print addTwo("1111","9")."\n";
print addTwo("0","4000")."\n";
print addTwo("4000","0")."\n";
print addTwo ("320000000000000000000000000000000000000000000000001","9")."\n";
?>