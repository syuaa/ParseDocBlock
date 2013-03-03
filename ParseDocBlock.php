<?php
/**
 * Documentation block parser.
 * @version 1.0
 * @package ParseDocBlock
 * @author SyuaaSE
 * @license MIT License
 *      http://opensource.org/licenses/MIT
 */

class ParseDocBlock
{

    // Comment to parse.
    public $comment = '';
    
    // For multy value index.
    private $index = 0;
    
    private $is_multy = false;
    
    // Current key.
    private $key = '_global_';
    
    // Comments exploded by new line.
    private $lines = array();
    
    // Things to return
    private $result = array();
    
    //Start parsing the comments.
    public function parse(){
    
        // Reset them all
        $this->index = 0;
        $this->is_multy = false;
        $this->key = '_global_';
        $this->result = array();
        
        $comm = str_replace( array( "\r", "\r\n" ), "\n", $this->comment );
        $this->lines = explode( "\n", $this->comment );
        
        return $this->parse_line();
    }
    
    // Start parse the comment.
    private function parse_line(){
        foreach( $this->lines as $line ) {
            $trim_line = ltrim( $line );
            
            // Skip for opening and closing comment.
            if( preg_match( '!^\/\*{2,}$!', $line ) || preg_match( '!^\*{1,}\/$!', $trim_line ) )
                continue;
            
            // New key @{Key} {Value[s]}
            if( preg_match( '!^[ *]*@([\w_]+) (.*)!', $line, $match ) ){
            
                if( isset( $this->result[$this->key] ) ){
                    if( !$this->is_multy ){
                        if( $this->key == 'return' )
                            $this->result[$this->key]['description'] = rtrim( $this->result[$this->key]['description'] );
                        else
                            $this->result[$this->key] = rtrim( $this->result[$this->key] );
                        
                    }else{
                        if( isset( $this->result[$this->key][$this->index]['description'] ) )
                            $this->result[$this->key][$this->index]['description'] = rtrim( $this->result[$this->key][$this->index]['description'] );
                    }
                }
                
                $this->key = strtolower( $match[1] );
                
                // Multy-value
                if( in_array( $match[1], array( 'example', 'param' ) ) ) {
                    $this->is_multy = true;
                    if( !isset( $this->result[$this->key] ) )
                        $this->result[$this->key] = array();
                    $this->index = count( $this->result[$this->key] );
                    
                }else{
                    $this->is_multy = false;
                    $this->index = 0;
                    
                }
                
                // @param {Type} {Name} {Description, Default value.}
                if( $match[1] == 'param' ){
                    if( preg_match( '!([\w|]+) ([\w]+) (.+)!', $match[2], $matc ) ){
                        $default = '';
                        if( preg_match( '!Default ([\w]+)!i', $matc[3], $mat ) )
                            $default = $mat[1];
                        
                        $this->result[$this->key][$this->index] = array(
                            'name'          => $matc[2],
                            'type'          => $matc[1],
                            'default'       => $default,
                            'description'   => $matc[3],
                            );
                    }
                
                // @return {Type} {Description}
                }elseif( $match[1] == 'return' ){
                    if( preg_match( '!([\w|]+) (.+)!', $match[2], $mat ) ) {
                        $this->result[$this->key] = array(
                            'type'          => $mat[1],
                            'description'   => $mat[2]
                        );
                    }
                
                // @example {Number} {Title}
                }elseif( $match[1] == 'example' ){
                    if( preg_match( '!([#0-9]+) (.+)!', $match[2], $mat ) ){
                        $this->result[$this->key][$this->index] = array(
                            'title'         => $mat[2],
                            'number'        => preg_replace( '![^0-9]!', '', $mat[1] ),
                            'description'   => '',
                        );
                    }
                    
                // @{key} {value}
                }else{
                    $this->result[ $match[1] ] = $match[2];
                    
                }
                
            // Single key @{Key}
            }elseif( preg_match( '!^[ *]*@([\w_]+)!', $line, $match ) ){            
                $this->result[ $match[1] ] = true;
                
            // Continue add to previous key
            }else{
                $value = trim( $trim_line, '*' );
                
                if( $this->is_multy ){
                    $this->result[$this->key][$this->index]['description'].= "\n$value";
                        
                }else {
                    if( $this->key == 'return' ){
                        if( !isset( $this->result[$this->key]['description'] ) )
                            $this->result[$this->key]['description'] = '';
                        $this->result[$this->key]['description'].= "\n$value";
                        
                    }else{
                        if( !isset( $this->result[ $this->key ] ) )
                            $this->result[ $this->key ] = '';
                        $this->result[ $this->key ].= "\n$value";
                    }
                    
                }
                
            }
        }
        
        return $this->result;
    }
}