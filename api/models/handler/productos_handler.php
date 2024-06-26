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
        $sql = 'SELECT id_producto , imagen, nombre_producto, descripcion, precio_producto, nombre_cat
                FROM tb_productos
                INNER JOIN tb_categorias USING(id_categoria)
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
        $sql = 'SELECT p.id_producto, p.imagen, p.nombre_producto, p.descripcion, 
        CASE 
            WHEN p.hasDiscount = 1 THEN ROUND(p.precio_producto - (p.precio_producto * o.descuento / 100), 2)
            ELSE p.precio_producto 
        END AS precio_producto,
        c.nombre_cat
        FROM tb_productos p
        INNER JOIN tb_categorias c ON p.id_categoria = c.id_categoria
        LEFT JOIN tb_ofertas o ON p.id_producto = o.id_producto AND p.hasDiscount = 1
        ORDER BY p.nombre_producto';
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

    public function readFilename()
    {
        $sql = 'SELECT imagen
                FROM tb_productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::getRow($sql, $params);
    }

    public function deleteRow()
    {
        $sql = 'DELETE FROM tb_productos
                WHERE id_producto = ?';
        $params = array($this->id);
        return Database::executeRow($sql, $params);
    }
}
