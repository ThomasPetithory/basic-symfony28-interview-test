<?php

namespace Test\InterviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
//use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return $this->render('TestInterviewBundle:Default:index.html.twig');
    }

    public function testdbAction() {
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $entities = $dm->getRepository('TestInterviewBundle:Bios')->findAll();
        $entities = array_values($entities);
        //var_dump($entities);

        // Partie Test
        $repository = $dm->getRepository('TestInterviewBundle:Bios');

        // Test de findByFirstName(name) avec un retour JSON listant les Ids des entités trouvées
        $test_first_name = 'John';
        $result = $repository->findByFirstName($test_first_name);
        $ids_bios_by_first_name = array();
        if ($result != false)
            foreach ($result as $bios) {
                $ids_bios_by_first_name[] = $bios->getId();
            }

        // Test de findByContribution(name)
        $test_contribution_name = 'OOP';
        $result = $repository->findByContribution($test_contribution_name);
        $ids_bios_by_contribution_name = array();
        if ($result != false)
            foreach ($result as $bios) {
                $ids_bios_by_contribution_name[] = $bios->getId();
            }

        // Test de findByDeadBefore(year)
        $test_date_dead_before = 2012;
        $result = $repository->findByDeadBefore($test_date_dead_before);
        $ids_bios_by_dead_before = array();
        if ($result != false)
            foreach ($result as $bios) {
                $ids_bios_by_dead_before[] = $bios->getId();
            }

        // Test du Service et GetAllAwards
        $service = $this->forward('testinterview.biosservice:getAllAwards');
        //var_dump($service);
        $service2 = $this->forward('testinterview.biosservice:getById',array("id" => 3));
        

        return new Response("<html><body>"
            ."Test findByFirstName : Ids des Bios pour le first name $test_first_name : ".implode(",", $ids_bios_by_first_name)."<br/>"
            ."Test findByContribution : Ids des Bios pour le contribution name $test_contribution_name : ".implode(",", $ids_bios_by_contribution_name)."<br/>"
            ."Test findByDeadBefore : Ids des Bios pour les morts avant le 1er Janvier $test_date_dead_before 00:00:00 : ".implode(",", $ids_bios_by_dead_before)."<br/>"
            ."Test BiosService GetAllAwards (Format Json) : ".$service->getContent()."<br/>"
            ."</body></html>");
        /*return new JsonResponse(array(
            "Test findByFirstName : Ids des Bios pour le first name $test_first_name" => $ids_bios_by_first_name,
            "Test findByContribution : Ids des Bios pour le contribution name $test_contribution_name" => $ids_bios_by_contribution_name,
            "Test findByDeadBefore : Ids des Bios pour les morts avant le 1er Janvier $test_date_dead_before 00:00:00" => $ids_bios_by_dead_before,
            "Test Service : " => $service,
        ));*/
    }
}
