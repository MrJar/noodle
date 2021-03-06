<?php

class IndexController extends Noodle_Controller_Action
{
    
    public function init()
    {
        parent::init();
    }

    public function indexAction()
    {
        // action body
    }
   
    public function testDoctrineAction()
    {
         $testTable = Application_Model_TestTable::getInstance();
        $test = $testTable->findAll();
        $this->view->test = $test;
    }
    
    public function testIdeoneAction()
    {
        $this->_helper->layout->disableLayout();
        $ideone = new Noodle_Ideone_Api();
        
        //var_dump($ideone->getListOfMethod());
        //var_dump($ideone->getLanguages());
        //var_dump($ideone->testFunction());
        
        $sourceCode = "#include <stdio.h>\n
            int main(void) { int x; for(; scanf(\"%d\",&x) > 0 && x != 42; printf(\"%d\", x)); return 0; }";
        $language = 11;
        $input = '1 2 10 42 11';
        $run = true;
        $private = 'private';
        
        //$return = $ideone->createSubmission($sourceCode, $language, $input, $run, $private);
        
        //var_dump($return);
        
        //$link = "kVH0iG";
        //$link = "KpEBnJ";
        //$link = "8xHbK7";
        //$link = "aWwWPB";
        //$link = "1KREJ6";
        $link = "VMqnUy";
        
        var_dump($ideone->getSubmissionStatus($link));
        //echo "<hr />";
        
        $withSource = true;
        $withInput = true;
        $withOutput = true;
        $withStderr = true;
        $withCmpinfo = true;
        
        //var_dump($ideone->getSubmissionDetails($link, $withSource, $withInput, $withOutput, $withStderr, $withCmpinfo));
        
        return;
    }
    
    public function testMailsAction()
    {
        $this->_helper->layout->disableLayout();
        $subject="Test";
        $addresses=array('[jakisprawidlowy@mail.com]','ikolejny');
        $htmltemplate="test.phtml";
        $parameters=array("test"=>"cos tam testowego", "kolejnyparametr" => "wartosc");

        Noodle_View_Helper_Mail::sendHtml($subject, $addresses, $htmltemplate, $parameters);
    }
}

