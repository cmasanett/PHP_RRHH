<?php

namespace Application\Form;

use Zend\Form\Form;

//use Zend\Db\Sql\Sql;
//use Zend\Db\Adapter\AdapterInterface;

class EmpresaForm extends Form {

    protected $entityManager;
//    protected $dbAdapter;
    protected $userId;

//    public function __construct(AdapterInterface $dbAdapter, $userId) {
    public function __construct(\Doctrine\ORM\EntityManager $entityManager, $userId) {
//        $this->setDbAdapter($dbAdapter);
        $this->setEntityManager($entityManager);
        $this->setUserId($userId);

        parent::__construct('form');

        $this->setAttributes(array(
            'action' => "",
            'method' => 'post',
            'class' => 'form-signin'
        ));

        $this->add(array(
            'name' => 'empresa',
            'type' => 'Zend\Form\Element\Select',
            'attributes' => array(
                'class' => 'form-control input-lg'
            ),
            'options' => array(
                'label' => 'Empresa: ',
                'value_options' => $this->getOptionsForSelectEmpresa()
            )
        ));

        $this->add(array(
            'name' => 'submit',
            'attributes' => array(
                'type' => 'submit',
                'value' => 'Seleccionar',
                'title' => 'Seleccionar',
                'class' => 'btn btn-lg btn-primary btn-block'
            )
        ));
    }

    public function setDbAdapter(AdapterInterface $dbAdapter) {
        $this->dbAdapter = $dbAdapter;
        return $this;
    }

    public function getDbAdapter() {
        return $this->dbAdapter;
    }

    public function setEntityManager(\Doctrine\ORM\EntityManager $entityManager) {
        $this->entityManager = $entityManager;
        return $this;
    }

    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setUserId($userId) {
        if (!is_int($userId)) {
            $this->userId = 0;
        }
        $this->userId = $userId;
        return $this;
    }

    public function getUserId() {
        return $this->userId;
    }

    public function getOptionsForSelectEmpresa() {
        $entityManager = $this->getEntityManager();
        $qb0 = $entityManager->createQueryBuilder();
        $qb0->select('l.id', 'l.nombre')
                ->from('Application\Entity\N7EmpresaUsuario', 'p')
                ->innerJoin('Application\Entity\N7Empresas', 'l', 'WITH', 'p.empresa = l.id')
                ->where('p.usuario = ?1');
        $qb0->setParameter(1, $this->getUserId());
        $query0 = $qb0->getQuery();
        $result = $query0->getArrayResult();

//        $dbAdapter = $this->getDbAdapter();
//        $sql = new Sql($dbAdapter);
//        $select = $sql->select();
//        $select->from(array(
//            'p' => 'empresa_usuario'
//                ), array(
//            '*'
//        ))->join(array(
//            'l' => 'empresas'
//                ), 'p.empresa_id = l.id', array(
//            '*'
//        ))->where(array(
//            'usuario_id' => $this->getUserId()
//        ));
//        $selectString = $sql->getSqlStringForSqlObject($select);
//        $execute = $dbAdapter->query($selectString, $dbAdapter::QUERY_MODE_EXECUTE);
//        $result = $execute->toArray();

        $selectData = array();

        foreach ($result as $res) {
            $selectData [$res ['id']] = $res ['nombre'];
        }

        return $selectData;
    }

}
