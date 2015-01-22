<?php

namespace Application\Repository;

use Doctrine\ORM\EntityRepository;

class N7EmpresaUsuarioRepository extends EntityRepository {

    public function empresasByUsuario(array $criteria) {
        $r = $this->createQueryBuilder('s')
                        ->select('s')
                        ->innerJoin("s.empresa", "u", "WITH", "u.id=s.empresa")
                        ->where('s.usuario = ?1')
                        ->setParameter(1, $criteria['usuario'])
                        ->getQuery()->getResult();
        return $r;

//        $entityManager = $this->getEntityManager();
//        $qb0 = $entityManager->createQueryBuilder();
//        $qb0->select('l.id', 'l.nombre')
//                ->from('Application\Entity\N7EmpresaUsuario', 'p')
//                ->innerJoin('Application\Entity\N7Empresas', 'l', 'WITH', 'p.empresa = l.id')
//                ->where('p.usuario = ?1');
//        $qb0->setParameter(1, $criteria['usuario']);
//        $query0 = $qb0->getQuery();
//        $result = $query0->getArrayResult();
//
//        $selectData = array();
//
//        foreach ($result as $res) {
//            $selectData [$res ['id']] = $res ['nombre'];
//        }
//
//        return $selectData;
    }

}
