<?php

namespace Test\InterviewBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;

class DefaultController extends Controller
{
    public function indexAction()
    {
        return new Response("<html><body>Index du Bundle Test/Interview</body></html>");
    }

    // fonction de test permettant de vérifier les query et les résultats
    public function testdbAction() {
        // Initialisation (captain obvious)
        $dm = $this->get('doctrine.odm.mongodb.document_manager');
        $repository = $dm->getRepository('TestInterviewBundle:Bios');

        // Test de findByFirstName(name) avec un retour JSON listant les Ids des entités trouvées
        /*------ Paramètre(s) utilisé(s) ------*/
            // param de findByFirstName
            $test_first_name = 'John';
            // param de findByContribution
            $test_contribution_name = 'OOP';
            // param de findByDeadBefore
            $test_date_dead_before = 2012;
        /*------ Fin ------*/

        // Test findByFirstName((string) name)
        // return array of bios id
        $result = $repository->findByFirstName($test_first_name);
        $ids_bios_by_first_name = array();
        if ($result != false)
            foreach ($result as $bios) {
                $ids_bios_by_first_name[] = $bios->getId();
            }

        // Test de findByContribution((string) name)
        // return array of bios id
        $result = $repository->findByContribution($test_contribution_name);
        $ids_bios_by_contribution_name = array();
        if ($result != false)
            foreach ($result as $bios) {
                $ids_bios_by_contribution_name[] = $bios->getId();
            }

        // Test de findByDeadBefore((integer) year)
        // return array of bios id
        $result = $repository->findByDeadBefore($test_date_dead_before);
        $ids_bios_by_dead_before = array();
        if ($result != false)
            foreach ($result as $bios) {
                $ids_bios_by_dead_before[] = $bios->getId();
            }

        // Test du Service et GetAllAwards
        $service = $this->forward('testinterview.biosservice:getAllAwards');
        
        // la réponse Html n'utilise pas de template Twig donc pas très jolie, c'est juste pour vérifier les données retournées par les fonctions
        // (si vide, un résultat ou plusieurs)
        return new Response("<html><body>"
            ."Test findByFirstName : Ids des Bios pour le first name $test_first_name : ".implode(",", $ids_bios_by_first_name)."<br/>"
            ."Test findByContribution : Ids des Bios pour le contribution name $test_contribution_name : ".implode(",", $ids_bios_by_contribution_name)."<br/>"
            ."Test findByDeadBefore : Ids des Bios pour les morts avant le 1er Janvier $test_date_dead_before 00:00:00 : ".implode(",", $ids_bios_by_dead_before)."<br/>"
            ."Test BiosService GetAllAwards (Format Json) : ".$service->getContent()."<br/>"
            ."</body></html>");
    }
}
