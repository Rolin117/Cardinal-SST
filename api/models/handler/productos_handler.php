<?php
// Se incluye la clase para trabajar con la base de datos.
require_once('../../helpers/database.php');

/*
 *  Clase para manejar el comportamiento de los datos de la tabla productos.
 */
class ProductoHandler
{
    /*
     *  Declaración de atributos para el manejo de datos.
     */
    protected $id = null;
    protected $nombre = null;
    protected $precio = null;
    protected $descripcion = null;
    protected $cantidad = null;
    protected $imagen = null;
    protected $id_categoria = null;
    protected $id_admin = null;
    protected $id_oferta = null;

    // Constante para establecer la ruta de las imágenes.
    const RUTA_IMAGEN = '../../images/productos/';

    /*
     *  Métodos para realizar las operaciones CRUD (create, read, update, and delete).
     */
    public function searchRows()
    {
        $value = '%' . Validator::getSearchValue() . '%';
        $sql = 'SELECT id_producto, nombre_producto, precio_producto, descripcion, cantidad_producto, imagen, id_categoria, id_admin, id_oferta
                FROM tb_productos
                WHERE nombre_producto LIKE ? OR descripcion LIKE ?
                ORDER BY nombre_producto';
        $params = array($value, $value);
        return Database::getRows($sql, $params);
    }
    
    public function createRow()
    {
        $sql = 'INSERT INTO tb_productos(nombre_producto, precio_producto, c_descripcion, cantidad_producto, imagen, id_categoria, id_admin, id_oferta)
                VALUES(?, ?, ?, ?, ?, ?, ?, ?)';
        $params = array($this->nombre, $this->precio, $this->descripcion, $this->cantidad, $this->imagen, $this->id_categoria, $this->id_admin, $this->id_oferta);
        return Database::executeRow($sql, $params);
    }

    public function readAll()
    {
        $sql = 'SELECT id_producto, nombre_producto, precio_producto, descripcion, cantidad_producto, imagen, id_categoria, id_admin, id_oferta
                FROM tb_productos
                ORDER BY nombre_producto';
        return Database::getRows($sql);
    }

    public function readOne()
    {
        $sql = 'SELECT id_producto, nombre_producto, precio_producto, descripcion, cantidad_producto, imagen, id_categoria, id_admin, id_oferta
                FROM tb_productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function updateRow()
    {
        $sql = 'UPDATE tb_productos
                SET nombre_producto = ?, precio_producto = ?, descripcion = ?, cantidad_producto = ?, imagen = ?, id_categoria = ?, id_admin = ?, id_oferta = ?
                WHERE id_producto = ?';
        $params = array($this->nombre, $this->precio, $this->descripcion, $this->cantidad, $this->imagen, $this->id_categoria, $this->id_admin, $this->id_oferta, $this->id);
        return Database::executeRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
