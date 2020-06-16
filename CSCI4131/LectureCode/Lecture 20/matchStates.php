<!DOCTYPE html>


<html>
   <head>
      <meta charset="utf-8">
      <title>MatchStates</title>
   </head>  
   <body>
      <?php
         $states = "Mississippi Alabama Texas Massachusetts Kansas";
         
         if ( preg_match( "/\b(\w*xas)\b/i", $states, $matches ) )
            $statesArray[ 0 ] = $matches[ 1 ];
         
         if ( preg_match( "/\b(k\w*s)\b/i", $states, $matches ) )
            $statesArray[ 1 ] = $matches[ 1 ];
         
         if ( preg_match( "/\b(m\w*s)\b/i", $states, $matches ) )
            $statesArray[ 2 ] = $matches[ 1 ];
         
         if ( preg_match( "/\b(a\w*)\b/i", $states, $matches ) )
            $statesArray[ 3 ] = $matches[ 1 ];
         
         if ( preg_match( "/\b(m\w*)\b/i", $states, $matches ) )
            $statesArray[ 4 ] = $matches[ 1 ];

         foreach ( $statesArray as $key => $value )
            print "<p>$value</p>";
      ?><!-- end PHP script -->
   </body>
</html>

