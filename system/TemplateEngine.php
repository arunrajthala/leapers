<?php

/**
 * @author Arun Rajthala 
 * @copyright 2010
 */

class TemplateParser
{
    private $arJSFiles;
    private $arCSSFiles;
    private $mainTpl;
    private $arJScript;
    private $arTags = array();
    private $arrSharedData = array();
    
    public function __construct()
    {
        $this->arJSFiles = array();
        $this->arCSSFiles = array();
        $this->arPageData = array();
        $this->arJScript = array();
        $this->arPageData['root'] = ABS_URL;
    }
    
    public function setTemplate($strTpl)
    {
        $this->mainTpl = $strTpl;
//        echo $this->mainTpl;die();
        if(!file_exists($this->mainTpl))
        {
            $this->mainTpl='';
        }
        $content = file_get_contents($this->mainTpl);
        preg_match_all('/{(.*)}/', $content, $arTags);
        $this->arTags = array_flip($arTags[1]);
    }
    
    public function getTemplate()
    {
        ob_start();
        extract( $this->arrSharedData );
        include( $this->mainTpl );
        $strContent = ob_get_contents();
        ob_end_clean();
        
        return $strContent;        
    }
    
    public function returnContent()
    {
        $strContent = $this->getTemplate();
        
        $arDiffs = array_diff_key($this->arTags, $this->arPageData);

        if(count($arDiffs)>0)
        {
            foreach($arDiffs as $key=>$value)
                $this->arPageData[$key] = '';
        }
        
        $strContent = loadFormat($strContent, $this->arPageData);
        
        return $strContent;
    }
    
    /**
     * Public function to set and get the shared data 
     * */
    public function setSharedData( $arrData )
    {
        $this->arrSharedData = array_merge_recursive($this->arrSharedData, $arrData);
    }

}

?>