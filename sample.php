<?php


// Get function `my_strpos' docComment.
$func = new ReflectionFunction( 'my_strpos' );
$comments = $func->getDocComment();

require_once( 'ParseDocBlock.php' );

// Create the ParseDocBlock object.
$pdb = new ParseDocBlock();
$pdb->comment = $comments;

echo '<pre>';
echo htmlspecialchars( print_r( $pdb->parse(), true ), ENT_QUOTES );
echo '</pre>';







// Below is block documentation sample.







/**
 * Find the position of the first occurrence of a substring in a string
 * Find the numeric position of the first occurrence of needle in the haystack string.
 * @package PHP 5.4.12
 * @version 5.4.12
 * @namespace String
 * @author The PHP Group
 * @license Copyright (c) 2001-2013 The PHP Group
 * @param String haystack The string to search in.
 * @param Integer needle If needle is not a string, it is converted to an integer and applied as the ordinal value of a character.
 * @param Integer offset If specified, search will start this number of characters counted from the beginning of the string. Default 0.
 *        Unlike strrpos() and strripos(), the offset cannot be negative.
 * @return Integer Returns the position of where the needle exists relative to the beginning of the haystack string (independent of offset).
 *         Also note that string positions start at 0, and not 1.
 *         Returns FALSE if the needle was not found.
 * @warning This function may return Boolean FALSE, but may also return a non-Boolean value which evaluates to FALSE.
 *          Please read the section on Booleans for more information. Use the === operator for testing the return value of this function.
 * @example #1 Using ===
<?php
$mystring = 'abc';
$findme   = 'a';
$pos = strpos($mystring, $findme);

// Note our use of ===.  Simply == would not work as expected
// because the position of 'a' was the 0th (first) character.
if ($pos === false) {
    echo "The string '$findme' was not found in the string '$mystring'";
} else {
    echo "The string '$findme' was found in the string '$mystring'";
    echo " and exists at position $pos";
}
?>

 * @example #2 Using !==
<?php
$mystring = 'abc';
$findme   = 'a';
$pos = strpos($mystring, $findme);

// The !== operator can also be used.  Using != would not work as expected
// because the position of 'a' is 0. The statement (0 != false) evaluates 
// to false.
if ($pos !== false) {
     echo "The string '$findme' was found in the string '$mystring'";
         echo " and exists at position $pos";
} else {
     echo "The string '$findme' was not found in the string '$mystring'";
}
?>

 * @example #3 Using an offset
<?php
// We can search for the character, ignoring anything before the offset
$newstring = 'abcdef abcdef';
$pos = strpos($newstring, 'a', 1); // $pos = 7, not 0
?>

 */
function my_strpos( $heystack, $needle, $offset=0 ){
    return strpos( $heystack, $needle, $offset );
}