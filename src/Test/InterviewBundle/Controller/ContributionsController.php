<?php
// Demande 10
namespace Test\InterviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ContributionsController extends Controller
{
    // Demande 11
    public function contributionsAction ()
    {
        return $this->forward('testinterview.biosservice:getAllContributions');
    }

    // Demande 12
    public function biosByContributionAction ($contributionName)
    {
        return $this->forward('testinterview.biosservice:getBiosByContributionName',array("contributionName" => $contributionName));
    }
}