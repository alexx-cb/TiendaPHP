<?php

namespace Models;


class Producto
{
    protected static array $errors = [];


    public function __construct(
        private int|null $id,
        private int|null $categoria_id,
        private string $nombre,
        private string $descripcion,
        private int $precio,
        private int|null $stock,
        private int|null $oferta,
        private string $fecha,
        private string $imagen,
    ){
    }

    /**
     * FUNCIONES
    */

    public static function fromArray(array $data): Producto{
        return new Producto(
            $data['id'] ?? null,
            $data['categoria_id'] ??null,
            $data['nombre'] ?? '',
            $data['descripcion'] ?? '',
            $data['precio'],
            $data['stock']??null,
            $data['oferta']??null,
            $data['fecha'] ?? '',
            $data['imagen'] ?? ''
        );
    }

    public function toArray(): array{
        return [
            'id' => $this->id,
            'categoria_id' => $this->categoria_id,
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'precio' => $this->precio,
            'stock' => $this->stock,
            'oferta' => $this->oferta,
            'fecha' => $this->fecha,
            'imagen' => $this->imagen
        ];
    }

    public function sanitize(): void {
        // Limpiar y sanitizar cada propiedad según su tipo
        $this->id = isset($this->id) ? filter_var($this->id, FILTER_VALIDATE_INT) : null;
        $this->categoria_id = isset($this->categoria_id) ? filter_var($this->categoria_id, FILTER_VALIDATE_INT) : null;
        $this->nombre = filter_var(trim($this->nombre), FILTER_SANITIZE_STRING);
        $this->descripcion = filter_var(trim($this->descripcion), FILTER_SANITIZE_STRING);
        $this->precio = filter_var(trim($this->precio), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        $this->stock = isset($this->stock) ? filter_var($this->stock, FILTER_VALIDATE_INT) : null;
        $this->oferta = isset($this->oferta) ? filter_var($this->oferta, FILTER_VALIDATE_INT) : null;
        $this->fecha = filter_var(trim($this->fecha), FILTER_SANITIZE_STRING);
        $this->imagen = filter_var(trim($this->imagen), FILTER_SANITIZE_URL);
    }

    /**
     * Validar los datos del producto
     */
    public function validator(): array
    {
        self::$errors = [];
        $this->sanitize();

        if (empty($this->categoria_id|null)) {
            self::$errors['categoria_id'] = "La categoría es requerida";
        }
        if (empty($this->nombre)) {
            self::$errors['nombre'] = "El nombre es requerido";
        }
        if (empty($this->descripcion)) {
            self::$errors['descripcion'] = "La descripción es requerida";
        }
        if (empty($this->precio)) {
            self::$errors['precio'] = "El precio es requerido";
        }
        if($this->precio<=0){
            self::$errors['precio'] = "El precio no puede ser menor o igual a 0";
        }
        if (empty($this->stock)) {
            self::$errors['stock'] = "El stock es requerido";
        }
        if($this->stock<=0){
            self::$errors['stock'] = "El stock no puede ser menor o igual a 0";
        }
        if (empty($this->oferta)) {
            self::$errors['oferta'] = "La oferta es requerida";
        }
        if($this->oferta<0){
            self::$errors['oferta'] = "La oferta no puede ser menor a 0";
        }
        if (empty($this->fecha)) {
            self::$errors['fecha'] = "La fecha es requerida";
        }
        if (empty($this->imagen)) {
            self::$errors['imagen'] = "La imagen es requerida";
        }
        return self::$errors;
    }

    /**
     * GETTERS
     */

    public static function getErrors(): array
    {
        return self::$errors;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdCategoria(): int|null
    {
        return $this->categoria_id;
    }

    public function getNombre(): string
    {
        return $this->nombre;
    }

    public function getDescripcion(): string
    {
        return $this->descripcion;
    }


    public function getPrecio(): string
    {
        return $this->precio;
    }

    public function getStock(): int|null
    {
        return $this->stock;
    }

    public function getOferta(): int|null
    {
        return $this->oferta;
    }

    public function getFecha(): string
    {
        return $this->fecha;
    }

    public function getImagen(): string
    {
        return $this->imagen;
    }

    /**
     * SETTERS
     */

    public static function setErrors(array $errors): void
    {
        self::$errors = $errors;
    }

    public function setId(?int $id): void
    {
        $this->id = $id;
    }

    public function setCategoriaId(int $categoria_id): void
    {
        $this->categoria_id = $categoria_id;
    }

    public function setNombre(string $nombre): void
    {
        $this->nombre = $nombre;
    }

    public function setDescripcion(string $descripcion): void
    {
        $this->descripcion = $descripcion;
    }

    public function setPrecio(string $precio): void
    {
        $this->precio = $precio;
    }

    public function setStock(int $stock): void
    {
        $this->stock = $stock;
    }

    public function setOferta(int $oferta): void
    {
        $this->oferta = $oferta;
    }

    public function setFecha(string $fecha): void
    {
        $this->fecha = $fecha;
    }

    public function setImagen(string $imagen): void
    {
        $this->imagen = $imagen;
    }


}