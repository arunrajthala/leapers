
<?php
$objDb = new PDODatabase(DB_HOST,DB_NAME,DB_USER,DB_PASS);
    
       
    //Its a sample Module
    //Here are autodefined varaibles like: $strModuleName, $arrSharedData
    //If you want to pass the values to template then populate it to $arrSharedData
    //Either you can populate it manually or use + like: $arrSharedData = compact('xyz','abc') + $arrSharedData
    //die();
    
            echo defaultModule( $strModuleName, $arrSharedData );
        
    
    //$arrSharedData['title'] = $title;
    //$arrSharedData['content']=$content;
    
    
?>