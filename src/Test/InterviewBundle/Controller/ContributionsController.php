<?php
namespace Test\InterviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContributionsController extends Controller
{
    public function contributionsAction ()
    {
        return $this->forward('testinterview.biosservice:getAllContributions');
    }

    public function biosByContributionAction ($contributionName)
    {
        return $this->forward('testinterview.biosservice:getBiosByContributionName',array("contributionName" => $contributionName));
    }
}