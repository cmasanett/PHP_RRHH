<?php

namespace Application\Model\Entity;

/*
 * Usamos el componente tablegateway que nos permite hacer consultas
 * utilizando una capa de abstracción, aremos las consultas sobre
 * una tabla que indicamos en el constructor
 */
use Zend\Db\TableGateway\TableGateway;

/*
 * Usamos el componente Dd\Adapter que nos permite hacer consultas
 * convencionales en formato SQL así como para servir de conexión
 * para el componente SQL que nos provee de una capa de abstracción
 * mas potente que la que da tablagateway
 */
use Zend\Db\Adapter\Adapter;

/*
 * Usamos el componente SQL que nos permite realizar consultas
 * utilizando métodos.
 */
use Zend\Db\Sql\Sql;

/*
 * Igual que el anterior pero solamente con la cláusula select
 */
use Zend\Db\Sql\Select;

/*
 * Nos da algunas herramientas para trabajar con el resulset de las consultas, puede ser prescindible
 */
use Zend\Db\ResultSet\ResultSet;

class EmpresaLiquidacionModel extends TableGateway {
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
		return parent::__construct ( 'n7_propiedades_e', $this->dbAdapter, $databaseSchema, $selectResultPrototype );
	}
	
	// CREAMOS LOS METODOS DEL MODELO PARA EL CRUD
	public function getPropiedades() {
		// Las consultas se pueden hacer de 4 formas:
		
		/*
		 * Utilizando una query en modo ejecución directamente desde el adaptador:
		 *
		 * $consulta=$this->dbAdapter->query("SELECT * FROM usuarios",Adapter::QUERY_MODE_EXECUTE);
		 * $datos=$consulta->toArray();
		 */
		
		/*
		 * Creando una sentencia en el adaptador y ejecutándola:
		 *
		 * $consulta=$this->dbAdapter->createStatement("SELECT * FROM usuarios");
		 * $datos= $consulta->execute();
		 */
		
		/*
		 * Usando el componente SQL le pasamos el adaptador
		 * y utilizamos los métodos que nos ofrece:
		 *
		 * $sql = new Sql($this->dbAdapter);
		 * $select = $sql->select();
		 * $select->from('usuarios');
		 *
		 * Aquí le indicamos que convierta las llamadas a los métodos
		 * en una sentencia sql y que la ejecute
		 * $statement = $sql->prepareStatementForSqlObject($select);
		 * $datos=$statement->execute();
		 */
		
		// Utilizando las sentencias básicas de table gateway:
		$select = $this->select ();
		$datos = $select->toArray ();
		
		return $datos;
	}
	public function getPropiedadesById($id) {
		$sql = new Sql ( $this->dbAdapter );
		$select = $sql->select ();
		$select->columns ( array (
				'id',
				'descripcion',
				'tipo_de_campo' 
		) )->from ( 'n7_propiedades_e' )->where ( array (
				'id' => $id 
		) );
		
		$selectString = $sql->getSqlStringForSqlObject ( $select );
		$execute = $this->dbAdapter->query ( $selectString, Adapter::QUERY_MODE_EXECUTE );
		$result = $execute->toArray ();
		return $result [0];
	}
	public function addPropiedad($descripcion, $tipoDeCampo) {
		$consulta = $this->dbAdapter->query ( "SELECT count(descripcion) as count FROM n7_propiedades_e WHERE descripcion='$descripcion'", Adapter::QUERY_MODE_EXECUTE );
		$datos = $consulta->toArray ();
		if ($datos [0] ["count"] == 0) {
			$insert = $this->insert ( array (
					"descripcion" => $descripcion,
					"tipo_de_campo" => $tipoDeCampo 
			) );
		} else {
			$insert = false;
		}
		return $insert;
	}
	public function deletePropiedad($id) {
		$delete = $this->delete ( array (
				"id" => $id 
		) );
		return $delete;
	}
	public function updatePropiedad($id, $descripcion, $tipoDeCampo) {
		$update = $this->update ( array (
				"descripcion" => $descripcion,
				"tipo_de_campo" => $tipoDeCampo 
		), array (
				"id" => $id 
		) );
		return $update;
	}
}
?>