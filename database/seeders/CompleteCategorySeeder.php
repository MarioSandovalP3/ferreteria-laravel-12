<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompleteCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Limpiar categorías existentes
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        \App\Models\Category::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        
        $categories = [
            // TECNOLOGÍA Y ELECTRÓNICA
            'Smartphones y Tablets' => [
                'description' => 'Teléfonos inteligentes, tablets y accesorios',
                'required_attributes' => [
                    ['key' => 'modelo', 'label' => 'Modelo', 'type' => 'text'],
                    ['key' => 'capacidad', 'label' => 'Almacenamiento', 'type' => 'text'],
                    ['key' => 'ram', 'label' => 'RAM', 'type' => 'text'],
                    ['key' => 'pantalla', 'label' => 'Tamaño Pantalla', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                    ['key' => 'sistema_operativo', 'label' => 'Sistema Operativo', 'type' => 'text'],
                    ['key' => 'bateria', 'label' => 'Batería', 'type' => 'text'],
                    ['key' => 'camara', 'label' => 'Cámara', 'type' => 'text'],
                ],
            ],
            
            'Computadoras y Laptops' => [
                'description' => 'Computadoras de escritorio, laptops y accesorios',
                'required_attributes' => [
                    ['key' => 'modelo', 'label' => 'Modelo', 'type' => 'text'],
                    ['key' => 'procesador', 'label' => 'Procesador', 'type' => 'text'],
                    ['key' => 'ram', 'label' => 'RAM', 'type' => 'text'],
                    ['key' => 'almacenamiento', 'label' => 'Almacenamiento', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'pantalla', 'label' => 'Pantalla', 'type' => 'text'],
                    ['key' => 'tarjeta_grafica', 'label' => 'Tarjeta Gráfica', 'type' => 'text'],
                    ['key' => 'sistema_operativo', 'label' => 'Sistema Operativo', 'type' => 'text'],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                ],
            ],
            
            'Audio y Video' => [
                'description' => 'Audífonos, parlantes, cámaras y equipos de audio/video',
                'required_attributes' => [
                    ['key' => 'modelo', 'label' => 'Modelo', 'type' => 'text'],
                    ['key' => 'tipo', 'label' => 'Tipo', 'type' => 'select', 'options' => ['Audífonos', 'Parlante', 'Cámara', 'Micrófono', 'Barra de sonido']],
                ],
                'optional_attributes' => [
                    ['key' => 'conectividad', 'label' => 'Conectividad', 'type' => 'text'],
                    ['key' => 'bateria', 'label' => 'Batería', 'type' => 'text'],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                    ['key' => 'cancelacion_ruido', 'label' => 'Cancelación de Ruido', 'type' => 'select', 'options' => ['Sí', 'No']],
                ],
            ],

            // MODA Y ROPA
            'Ropa Hombre' => [
                'description' => 'Ropa y vestimenta para hombre',
                'required_attributes' => [
                    ['key' => 'talla', 'label' => 'Talla', 'type' => 'select', 'options' => ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL']],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                    ['key' => 'material', 'label' => 'Material', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'tipo_prenda', 'label' => 'Tipo de Prenda', 'type' => 'select', 'options' => ['Camisa', 'Pantalón', 'Camiseta', 'Sudadera', 'Chaqueta', 'Short']],
                    ['key' => 'estilo', 'label' => 'Estilo', 'type' => 'text'],
                    ['key' => 'ajuste', 'label' => 'Ajuste', 'type' => 'select', 'options' => ['Slim Fit', 'Regular', 'Holgado']],
                ],
            ],
            
            'Ropa Mujer' => [
                'description' => 'Ropa y vestimenta para mujer',
                'required_attributes' => [
                    ['key' => 'talla', 'label' => 'Talla', 'type' => 'select', 'options' => ['XS', 'S', 'M', 'L', 'XL', 'XXL']],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                    ['key' => 'material', 'label' => 'Material', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'tipo_prenda', 'label' => 'Tipo de Prenda', 'type' => 'select', 'options' => ['Blusa', 'Vestido', 'Pantalón', 'Falda', 'Chaqueta', 'Top']],
                    ['key' => 'estilo', 'label' => 'Estilo', 'type' => 'text'],
                    ['key' => 'largo', 'label' => 'Largo', 'type' => 'select', 'options' => ['Corto', 'Medio', 'Largo']],
                ],
            ],
            
            'Calzado' => [
                'description' => 'Zapatos, zapatillas y sandalias',
                'required_attributes' => [
                    ['key' => 'talla', 'label' => 'Talla', 'type' => 'select', 'options' => array_map('strval', range(35, 48))],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                    ['key' => 'material', 'label' => 'Material', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'genero', 'label' => 'Género', 'type' => 'select', 'options' => ['Hombre', 'Mujer', 'Unisex', 'Niño', 'Niña']],
                    ['key' => 'tipo', 'label' => 'Tipo', 'type' => 'select', 'options' => ['Deportivo', 'Casual', 'Formal', 'Sandalia', 'Bota']],
                    ['key' => 'cierre', 'label' => 'Tipo de Cierre', 'type' => 'select', 'options' => ['Cordones', 'Velcro', 'Sin cierre', 'Hebilla']],
                ],
            ],

            // HOGAR Y COCINA
            'Electrodomésticos' => [
                'description' => 'Electrodomésticos para el hogar',
                'required_attributes' => [
                    ['key' => 'modelo', 'label' => 'Modelo', 'type' => 'text'],
                    ['key' => 'tipo', 'label' => 'Tipo', 'type' => 'select', 'options' => ['Refrigerador', 'Lavadora', 'Microondas', 'Licuadora', 'Cafetera', 'Aspiradora']],
                ],
                'optional_attributes' => [
                    ['key' => 'capacidad', 'label' => 'Capacidad', 'type' => 'text'],
                    ['key' => 'potencia', 'label' => 'Potencia', 'type' => 'text'],
                    ['key' => 'voltaje', 'label' => 'Voltaje', 'type' => 'select', 'options' => ['110V', '220V', 'Dual']],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                ],
            ],
            
            'Muebles' => [
                'description' => 'Muebles para hogar y oficina',
                'required_attributes' => [
                    ['key' => 'material', 'label' => 'Material', 'type' => 'select', 'options' => ['Madera', 'Metal', 'Plástico', 'Vidrio', 'Tela', 'Mixto']],
                    ['key' => 'dimensiones', 'label' => 'Dimensiones', 'type' => 'text'],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'tipo', 'label' => 'Tipo', 'type' => 'select', 'options' => ['Silla', 'Mesa', 'Sofá', 'Cama', 'Escritorio', 'Estante']],
                    ['key' => 'peso_maximo', 'label' => 'Peso Máximo', 'type' => 'text'],
                    ['key' => 'estilo', 'label' => 'Estilo', 'type' => 'text'],
                ],
            ],
            
            'Decoración' => [
                'description' => 'Artículos decorativos para el hogar',
                'required_attributes' => [
                    ['key' => 'material', 'label' => 'Material', 'type' => 'text'],
                    ['key' => 'dimensiones', 'label' => 'Dimensiones', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                    ['key' => 'tipo', 'label' => 'Tipo', 'type' => 'select', 'options' => ['Cuadro', 'Lámpara', 'Espejo', 'Florero', 'Cojín', 'Cortina']],
                    ['key' => 'estilo', 'label' => 'Estilo', 'type' => 'text'],
                ],
            ],

            // DEPORTES Y FITNESS
            'Equipamiento Deportivo' => [
                'description' => 'Equipos y accesorios deportivos',
                'required_attributes' => [
                    ['key' => 'deporte', 'label' => 'Deporte', 'type' => 'select', 'options' => ['Fútbol', 'Basketball', 'Tenis', 'Ciclismo', 'Natación', 'Gym', 'Running']],
                    ['key' => 'tipo', 'label' => 'Tipo de Producto', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'talla', 'label' => 'Talla', 'type' => 'text'],
                    ['key' => 'material', 'label' => 'Material', 'type' => 'text'],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                    ['key' => 'peso', 'label' => 'Peso', 'type' => 'text'],
                ],
            ],

            // BELLEZA Y CUIDADO PERSONAL
            'Cuidado de la Piel' => [
                'description' => 'Productos para el cuidado de la piel',
                'required_attributes' => [
                    ['key' => 'tipo', 'label' => 'Tipo de Producto', 'type' => 'select', 'options' => ['Crema', 'Sérum', 'Limpiador', 'Tónico', 'Mascarilla', 'Protector Solar']],
                    ['key' => 'contenido', 'label' => 'Contenido', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'tipo_piel', 'label' => 'Tipo de Piel', 'type' => 'select', 'options' => ['Seca', 'Grasa', 'Mixta', 'Normal', 'Sensible', 'Todo tipo']],
                    ['key' => 'spf', 'label' => 'SPF', 'type' => 'select', 'options' => ['15', '30', '50', '50+', 'Sin SPF']],
                    ['key' => 'ingredientes_principales', 'label' => 'Ingredientes Principales', 'type' => 'text'],
                ],
            ],
            
            'Maquillaje' => [
                'description' => 'Productos de maquillaje y cosméticos',
                'required_attributes' => [
                    ['key' => 'tipo', 'label' => 'Tipo de Producto', 'type' => 'select', 'options' => ['Base', 'Labial', 'Máscara', 'Sombra', 'Rubor', 'Delineador']],
                ],
                'optional_attributes' => [
                    ['key' => 'tono', 'label' => 'Tono/Color', 'type' => 'text'],
                    ['key' => 'acabado', 'label' => 'Acabado', 'type' => 'select', 'options' => ['Mate', 'Brillante', 'Satinado', 'Natural']],
                    ['key' => 'contenido', 'label' => 'Contenido', 'type' => 'text'],
                ],
            ],

            // JUGUETES Y BEBÉS
            'Juguetes' => [
                'description' => 'Juguetes y juegos para niños',
                'required_attributes' => [
                    ['key' => 'edad_recomendada', 'label' => 'Edad Recomendada', 'type' => 'select', 'options' => ['0-2 años', '3-5 años', '6-8 años', '9-12 años', '13+ años']],
                    ['key' => 'tipo', 'label' => 'Tipo de Juguete', 'type' => 'select', 'options' => ['Construcción', 'Educativo', 'Peluche', 'Acción', 'Muñeca', 'Vehículo', 'Juego de Mesa']],
                ],
                'optional_attributes' => [
                    ['key' => 'material', 'label' => 'Material', 'type' => 'select', 'options' => ['Plástico', 'Madera', 'Tela', 'Metal', 'Mixto']],
                    ['key' => 'baterias', 'label' => 'Requiere Baterías', 'type' => 'select', 'options' => ['Sí', 'No', 'Incluidas']],
                    ['key' => 'piezas', 'label' => 'Número de Piezas', 'type' => 'number'],
                ],
            ],
            
            'Productos para Bebé' => [
                'description' => 'Productos para el cuidado del bebé',
                'required_attributes' => [
                    ['key' => 'tipo', 'label' => 'Tipo de Producto', 'type' => 'select', 'options' => ['Pañal', 'Biberón', 'Chupón', 'Ropa', 'Cuna', 'Carriola', 'Silla de auto']],
                    ['key' => 'edad', 'label' => 'Edad/Etapa', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'talla', 'label' => 'Talla', 'type' => 'text'],
                    ['key' => 'material', 'label' => 'Material', 'type' => 'text'],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                ],
            ],

            // LIBROS Y MEDIOS
            'Libros' => [
                'description' => 'Libros físicos y digitales',
                'required_attributes' => [
                    ['key' => 'titulo', 'label' => 'Título', 'type' => 'text'],
                    ['key' => 'autor', 'label' => 'Autor', 'type' => 'text'],
                    ['key' => 'genero', 'label' => 'Género', 'type' => 'select', 'options' => ['Ficción', 'No Ficción', 'Biografía', 'Ciencia', 'Historia', 'Infantil', 'Autoayuda']],
                ],
                'optional_attributes' => [
                    ['key' => 'editorial', 'label' => 'Editorial', 'type' => 'text'],
                    ['key' => 'idioma', 'label' => 'Idioma', 'type' => 'select', 'options' => ['Español', 'Inglés', 'Francés', 'Otro']],
                    ['key' => 'paginas', 'label' => 'Número de Páginas', 'type' => 'number'],
                    ['key' => 'formato', 'label' => 'Formato', 'type' => 'select', 'options' => ['Físico', 'Digital', 'Audiolibro']],
                ],
            ],

            // ALIMENTOS Y BEBIDAS
            'Alimentos' => [
                'description' => 'Alimentos y productos comestibles',
                'required_attributes' => [
                    ['key' => 'tipo', 'label' => 'Tipo de Alimento', 'type' => 'select', 'options' => ['Snack', 'Bebida', 'Conserva', 'Cereal', 'Condimento', 'Dulce', 'Orgánico']],
                    ['key' => 'contenido', 'label' => 'Contenido Neto', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'sabor', 'label' => 'Sabor', 'type' => 'text'],
                    ['key' => 'fecha_caducidad', 'label' => 'Fecha de Caducidad', 'type' => 'text'],
                    ['key' => 'informacion_nutricional', 'label' => 'Información Nutricional', 'type' => 'text'],
                ],
            ],

            // AUTOMOTRIZ
            'Accesorios para Auto' => [
                'description' => 'Accesorios y repuestos automotrices',
                'required_attributes' => [
                    ['key' => 'tipo', 'label' => 'Tipo de Producto', 'type' => 'select', 'options' => ['Llanta', 'Batería', 'Aceite', 'Filtro', 'Accesorio Interior', 'Herramienta']],
                    ['key' => 'compatibilidad', 'label' => 'Compatibilidad', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'modelo_vehiculo', 'label' => 'Modelo de Vehículo', 'type' => 'text'],
                    ['key' => 'material', 'label' => 'Material', 'type' => 'text'],
                ],
            ],

            // MASCOTAS
            'Productos para Mascotas' => [
                'description' => 'Alimentos y accesorios para mascotas',
                'required_attributes' => [
                    ['key' => 'tipo_mascota', 'label' => 'Tipo de Mascota', 'type' => 'select', 'options' => ['Perro', 'Gato', 'Ave', 'Pez', 'Roedor', 'Reptil']],
                    ['key' => 'tipo_producto', 'label' => 'Tipo de Producto', 'type' => 'select', 'options' => ['Alimento', 'Juguete', 'Accesorio', 'Cama', 'Collar', 'Higiene']],
                ],
                'optional_attributes' => [
                    ['key' => 'talla', 'label' => 'Talla', 'type' => 'select', 'options' => ['Pequeño', 'Mediano', 'Grande']],
                    ['key' => 'sabor', 'label' => 'Sabor', 'type' => 'text'],
                    ['key' => 'contenido', 'label' => 'Contenido', 'type' => 'text'],
                ],
            ],
        ];

        foreach ($categories as $categoryName => $data) {
            $category = \App\Models\Category::create([
                'name' => $categoryName,
                'slug' => \Illuminate\Support\Str::slug($categoryName),
                'description' => $data['description'],
                'is_active' => true,
                'attribute_schema' => [
                    'required_attributes' => $data['required_attributes'],
                    'optional_attributes' => $data['optional_attributes'],
                ],
            ]);
            
            $this->command->info("✓ Created category: {$categoryName}");
        }
        
        $this->command->info("\n✅ Successfully created " . count($categories) . " categories!");
    }
}
