<?php
    function ExecuteQuery($strSQL, $strLine = '', $strFile = '' ){
        $result = @mysql_query( $strSQL );
        if(mysql_error()!==''){
            die('<br/>SQL: Error: '.mysql_error().'<br/>Line:'.$strLine.'<br/>File: '.$strFile);
        }
        return $result;
    }
    
?>