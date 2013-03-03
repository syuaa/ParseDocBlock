ParseDocBlock
=============

Simple PHP class to parse PHP documentation from comment block.

Usage
-----
    <?php
        $comments = '/**
        * Somedesc about functions.
        * @param String str Some parameter description.
        * @param Boolean ret Some return parameter. Default true.
        * @return String Some description about function return.
        */';
    
        require_once( 'ParseDocBlock.php' );
    
        $pdb = new ParseDocBlock();
        $pdb->comment = $comments;
    
        print_r( $pdb->parse() );
    ?>

Above example will print something like :

    Array
    (
        [_global_] => 
    Somedesc about functions.
        [param] => Array
            (
                [0] => Array
                    (
                        [name] => str
                        [type] => String
                        [default] => 
                        [description] => Some parameter description.
                    )
    
                [1] => Array
                    (
                        [name] => ret
                        [type] => Boolean
                        [default] => true
                        [description] => Some return parameter. Default true.
                    )
    
            )
    
        [return] => Array
            (
                [type] => String
                [description] => Some description about function return.
            )
    
    )