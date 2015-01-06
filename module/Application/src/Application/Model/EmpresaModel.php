<?php

namespace Application\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Adapter\Adapter;
use Zend\Db\Sql\Sql;
use Zend\Db\ResultSet\ResultSet;

class EmpresaModel extends TableGateway {

    private $dbAdapter;

    public function __construct(Adapter $adapter = null, $databaseSchema = null, ResultSet $selectResultPrototype = null) {
        // Conseguimos el adaptador
        $this->dbAdapter = $adapter;

        /*
         * Al estar utilizando TableGateway necesitamos
         * montar el constructor de la clase padre al que le pasamos
         * como parámetros principales la tabla de la base de datos que
         * corresponde a este modelo y le pasamos el adaptador de conexión
         */
        return parent::__construct('n7_propiedades_e', $this->dbAdapter, $databaseSchema, $selectResultPrototype);
    }

    public function getEmpresaById($id) {
        $sql = new Sql($this->dbAdapter);
        $select = $sql->select();
        $select->columns(array(
            'id',
            'codigo',
            'nombre'
        ))->from('empresas')->where(array(
            'id' => $id
        ));

        $selectString = $sql->getSqlStringForSqlObject($select);
        $execute = $this->dbAdapter->query($selectString, Adapter::QUERY_MODE_EXECUTE);
        $result = $execute->toArray();
        return $result [0];
    }

}
