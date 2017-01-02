<?php
// Demande 9
namespace Test\InterviewBundle\Service;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Log\LoggerInterface;

class BiosService
{
    // Ici on injecte l'entitymanager en arguments depuis la config dans services.yml du bundle
    private $em;
    private $logger;

    public function __construct($em,LoggerInterface $logger) {
        $this->em = $em;
        $this->logger = $logger;

    }

    // Demande 9
    public function getAllAwards()
    {
        $entities = $this->em
            ->getRepository('TestInterviewBundle:Bios')
            ->findAll();
        if (empty($entities)) {
            $this->logger->info('BiosService: Aucun éléments trouvé');
            $result = false;
        } else {
            $result = array();
            if ($entities) {
                foreach ($entities as $bios) {
                    if (!is_null($bios->getAwards())) {
                        $this->logger->info("BiosService: Awards pour le bios d'id : ".strval($bios->getId()));
                        $result[] = $bios->getAwards();
                    } else {
                        $this->logger->info("BiosService: Awards inexistants pour le bios d'id : ".strval($bios->getId()));
                    }
                }
            }
        }
        // La je fais un retour JsonResponse pour mes tests mais il n'y a pas de précisions dans la demande
        return new JsonResponse($result);
    }

    // Demande 11
    public function getAllContributions()
    {
        $entities = $this->em
            ->getRepository('TestInterviewBundle:Bios')
            ->findAll();
        if (empty($entities)) {
            $result = false;
        } else {
            $result = array();
            if ($entities) {
                foreach ($entities as $bios) {
                    if (!is_null($bios->getContribs())) {
                        $result[] = $bios->getContribs();
                    }
                }
            }
        }
        return new JsonResponse($result);
    }

    // Demande 12
    public function getBiosByContributionName($contributionName)
    {
        $result = $this->em
            ->getRepository('TestInterviewBundle:Bios')
            ->createQueryBuilder()
            ->find()
            ->field('contribs')->equals($contributionName)
            ->getQuery()
            ->execute()
            ->toArray();
        $data = array();
        if (empty($result)) {
            // demande 13 pour le test /contributions/fake => 404
            throw new NotFoundHttpException('Sorry not existing!');
        }
        foreach($result as $bios){
            $data[] = $bios;
        }
        return new JsonResponse($data);
    }

    // Demande 15
    public function getById($id)
    {
        $result = $this->em
            ->getRepository('TestInterviewBundle:Bios')
            // ne fonctionne pas, pas moyen de mapper avec l'id des objets...
            // => https://github.com/Automattic/mongoose/issues/3079 (avec mongoose mais j'ai exactement le même soucis)
            //->find($id);
            ->findAll();
        // vu que j'arrive pas à le faire 'normalement' avec un find(id) tout simple
        // ben je vais le faire en PHP...
        if (empty($result))
            return false;
        $rendu = false;
        foreach($result as $bios){
            if ($bios->getId() == $id)
                $rendu = true;
        }
        return new JsonResponse($rendu);
    }



}