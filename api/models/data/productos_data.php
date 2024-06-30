<?php
// Se incluye la clase para validar los datos de entrada.
require_once('../../helpers/validator.php');
// Se incluye la clase padre.
require_once('../../models/handler/productos_handler.php');

/*
 *  Clase para manejar el encapsulamiento de los datos de la tabla PRODUCTOS.
 */
class ProductoData extends ProductoHandler
{
    /*
     *  Atributos adicionales.
     */
    private $data_error = null;

    /*
     *  Métodos para validar y establecer los datos.
     */
    public function setId($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del producto es incorrecto';
            return false;
        }
    }

    public function setNombre($value, $min = 2, $max = 100)
    {
        if (Validator::validateAlphanumeric($value) && Validator::validateLength($value, $min, $max)) {
            $this->nombre = $value;
            return true;
        } else {
            $this->data_error = 'El nombre debe ser alfanumérico y tener una longitud entre ' . $min . ' y ' . $max;
            return false;
        }
    }

    public function setPrecio($value)
    {
        if (Validator::validateMoney($value)) {
            $this->precio = $value;
            return true;
        } else {
            $this->data_error = 'El precio no es válido';
            return false;
        }
    }

    public function setDescripcion($value, $min = 2, $max = 255)
    {
        if (Validator::validateString($value) && Validator::validateLength($value, $min, $max)) {
            $this->descripcion = $value;
            return true;
        } else {
            $this->data_error = 'La descripción contiene caracteres no válidos o no cumple con la longitud permitida';
            return false;
        }
    }

    public function setCantidad($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->cantidad = $value;
            return true;
        } else {
            $this->data_error = 'La cantidad no es válida';
            return false;
        }
    }

    public function setImagen($file)
    {
        if (Validator::validateImageFile($file, 1000)) {
            $this->imagen = Validator::getFilename();
            return true;
        } else {
            $this->data_error = Validator::getFileError();
            return false;
        }
    }

    public function setIdCategoria($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_categoria = $value;
            return true;
        } else {
            $this->data_error = 'El identificador de la categoría es incorrecto';
            return false;
        }
    }

    public function setIdAdmin($value)
    {
        if (Validator::validateNaturalNumber($value)) {
            $this->id_admin = $value;
            return true;
        } else {
            $this->data_error = 'El identificador del administrador es incorrecto';
            return false;
        }
    }

    public function setIdOferta($value)
    {
        if ($value === null || Validator::validateNaturalNumber($value)) {
            $this->id_oferta = $value;
            return true;
        } else {
            $this->data_error = 'El identificador de la oferta es incorrecto';
            return false;
        }
    }

    /*
     *  Métodos para obtener los atributos adicionales.
     */
    public function getDataError()
    {
        return $this->data_error;
    }
}
?>
