<?php

class PatientController extends Zend_Controller_Action
{
    private $DOLPHIN_ASSESSMENT_URL = null;
    //private $DOLPHIN_ASSESSMENT_URL = "";

    public function init() 
    { 
        $config = new Zend_Config_Ini(APPLICATION_PATH . "/configs/application.ini", "production");
        
        $this->DOLPHIN_ASSESSMENT_URL = $config->assessment->url;
    }

    public function assessmentAction()
    {
        $request                = $this->getRequest();
    	$params		            = $request->getParams();

        //TODO Add account number format verification here.
        
        $this->view->account    = $params["account"];
        $this->view->patient    = $params["patient"];
    }

    public function getassessmentAction()
    {
    	$request    = $this->getRequest();
        $response   = $this->getResponse();
    	$params		= $request->getParams();
        $url        = sprintf($this->DOLPHIN_ASSESSMENT_URL, $params["account"], $params["patient"]);

        //TODO Add account number format verification here.

        //Set the content type appropriately since this will be called via AJAX.
        $response->setHeader("Content-type", "text/html");

        $remoteAssessment  = @file_get_contents($url);

        if($remoteAssessment === false) 
        {
            //There was an exception on the remote end, handle it.

            $this->view->account    = $params["account"];
            $this->view->patient    = $params["patient"];

            $this->_helper->layout->disableLayout();
        } 
        else
        {
            echo $remoteAssessment;
            exit();
        }
    }
}

