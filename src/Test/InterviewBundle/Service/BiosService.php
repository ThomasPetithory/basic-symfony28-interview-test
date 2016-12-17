<?php
namespace Test\InterviewBundle\Service;

//use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Test\InterviewBundle\Document\Bios;

class BiosService
{
    private $em;

    public function __construct($em) {
        $this->em = $em;
    }

    // Rajout pour la commande test:command ,demande 15
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

    public function getAllAwards()
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
                    if (!is_null($bios->getAwards())) {
                        $result[] = $bios->getAwards();
                    }
                }
            }
        }
        // La je fais un retour JsonResponse pour mes tests mais il n'y a pas de précisions dans la demande
        return new JsonResponse($result);
    }

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
        // La je fais un retour JsonResponse pour mes tests mais il n'y a pas de précisions dans la demande
        return new JsonResponse($result);
    }

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
        // La je fais un retour JsonResponse pour mes tests mais il n'y a pas de précisions dans la demande
        return new JsonResponse($data);
    }
}