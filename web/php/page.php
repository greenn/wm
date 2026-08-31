s<?php



//0.4
/*
    web-страница
        состоящая из компонентов
*/

function buildPage(){

    $page = new page();

    $page->set('doctype', '<!DOCTYPE HTML>');
    $page->set('title', '{ title }');
    $page->set('meta', array('content' => '"text/html; charset=UTF-8"', 'content-type' => 'http-equiv'));
    $page->set('cssFile', '');
    $page->set('jsFile', '');
    $page->set('body', '');
    $page->set('body', '');

    $page->outputOrder('meta', '~meta-rules');
    $page->outputOrder('body', array('cmpt'));

    $page->outputOrder = array( //page
        'doctype',
        '<html>',
            '<head>',
                'title',
                'meta',
                'cssFile',
                'jsFile',
            '</head>',
            '<body>',
                'body',
            '</body>',
        '</html>',
    );



}

class pageComponentHandlers {
    var $handlers = array(
        'meta' => array('self', 'outputMeta'),
        'doctype' => array('self', 'outputDoctype'),
        'jsfile' => array('self', 'outputJsFile'),
        'cssfile' => array('self', 'outputCssFile'),
        'cssstyle' => array('self', 'outputCssStyle')
    );

    function setHandler($sectionName, $sectionHandler){}

    function getHandler($sectionName){
        $handler = false;
        if (isset($this->handlers[$sectionName])) {
            $handler = $this->handlers[$sectionName];
            if (is_array($handler) && ($handler[0] === 'self')) {
                $handler[0] = $this;
            }
            //todo check if callable //http://jmfeurprier.com/2010/01/03/method_exists-vs-is_callable/
        }
        return $handler;
    }

    function outputMeta(){}
    function outputDoctype(){}
    function outputJsFile(){}
    function outputCssFile(){}
    function outputCssStyle(){}
}

class pageComponent extends pageComponentHandlers{
    var $sections = array();


    function set($sectionName, $sectionValue){
        if (!$this->_hasSection($sectionName)) {
            $this->_createSection($sectionName);
        }
        $this->_addSectionValue($sectionValue);
    }
    function _hasSection($name){
        return isset($this->section[$name]);
    }
    function _createSection($name){
        $this->sections[$name] = array();
    }
    function _addSectionValue($name, $data){
        array_push($this->sections[$name], $data);
    }


    function outputOrder($orderArray) {
        $this->outputOrder = $orderArray;
    }
    function setOutput($orderArray, $sectionsData = false) {
        $this->outputOrder($orderArray);

        if (is_array($sectionsData))
            foreach ($sectionsData as $sectionName => $sectionValue)
                $this->set($sectionName, $sectionValue);
    }

    function outputSection($name){
        $outputString = '';
        if (isset($this->sections[$name]))
            foreach ($this->sections[$name] as $sectionData) {
                $handler = $this->getHandler();
                if ($handler) {
                    $sectionResult = call_user_func_array($handler, array($sectionData));
                    if (is_string($sectionResult))
                        $outputString .= $sectionResult;
                    //else php('log');
                } else {
                    $outputString .= $sectionData;
                }

            }
        return $outputString;
    }
    function output($outputOrder = true) {
        $outputString = '';

        if ($outputOrder === true)
            $outputOrder = $this->outputOrder;

        if (is_string($outputOrder))
            $outputOrder = array($outputOrder);

        foreach ($outputOrder as $index => $section) {
            $sectionName = $section;


            $outputString .= $this->outputSection($sectionName);
        }

        return $outputString;
    }
}


class page extends pageComponent {
    var $components = array();
}



