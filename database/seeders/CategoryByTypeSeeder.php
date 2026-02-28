<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategoryByTypeSeeder extends Seeder
{
    public function run(): void
    {
        // Limpiar categorías existentes
        \Illuminate\Support\Facades\Schema::disableForeignKeyConstraints();
        Category::truncate();
        \Illuminate\Support\Facades\Schema::enableForeignKeyConstraints();
        
        $categories = [
            // ==================== PRODUCTOS FÍSICOS ====================
            
            'Smartphones y Tablets' => [
                'product_type' => 'physical',
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
                'product_type' => 'physical',
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
                'product_type' => 'physical',
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

            'Ropa Hombre' => [
                'product_type' => 'physical',
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
                'product_type' => 'physical',
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
                'product_type' => 'physical',
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

            'Electrodomésticos' => [
                'product_type' => 'physical',
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
                'product_type' => 'physical',
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
                'product_type' => 'physical',
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

            'Equipamiento Deportivo' => [
                'product_type' => 'physical',
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

            'Cuidado de la Piel' => [
                'product_type' => 'physical',
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
                'product_type' => 'physical',
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

            'Juguetes' => [
                'product_type' => 'physical',
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
                'product_type' => 'physical',
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

            'Libros Físicos' => [
                'product_type' => 'physical',
                'description' => 'Libros impresos',
                'required_attributes' => [
                    ['key' => 'titulo', 'label' => 'Título', 'type' => 'text'],
                    ['key' => 'autor', 'label' => 'Autor', 'type' => 'text'],
                    ['key' => 'genero', 'label' => 'Género', 'type' => 'select', 'options' => ['Ficción', 'No Ficción', 'Biografía', 'Ciencia', 'Historia', 'Infantil', 'Autoayuda']],
                ],
                'optional_attributes' => [
                    ['key' => 'editorial', 'label' => 'Editorial', 'type' => 'text'],
                    ['key' => 'idioma', 'label' => 'Idioma', 'type' => 'select', 'options' => ['Español', 'Inglés', 'Francés', 'Otro']],
                    ['key' => 'paginas', 'label' => 'Número de Páginas', 'type' => 'number'],
                ],
            ],

            'Alimentos' => [
                'product_type' => 'physical',
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

            'Accesorios para Auto' => [
                'product_type' => 'physical',
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

            'Productos para Mascotas' => [
                'product_type' => 'physical',
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

            // ==================== SERVICIOS ====================
            
            'Servicios Profesionales' => [
                'product_type' => 'service',
                'description' => 'Servicios profesionales y consultoría',
                'required_attributes' => [
                    ['key' => 'tipo_servicio', 'label' => 'Tipo de Servicio', 'type' => 'select', 'options' => ['Consultoría', 'Asesoría', 'Desarrollo', 'Diseño', 'Marketing', 'Legal', 'Contable']],
                    ['key' => 'duracion', 'label' => 'Duración', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'modalidad', 'label' => 'Modalidad', 'type' => 'select', 'options' => ['Presencial', 'Remoto', 'Híbrido']],
                    ['key' => 'nivel', 'label' => 'Nivel', 'type' => 'select', 'options' => ['Básico', 'Intermedio', 'Avanzado', 'Experto']],
                ],
            ],
            
            'Servicios de Mantenimiento' => [
                'product_type' => 'service',
                'description' => 'Mantenimiento y reparación',
                'required_attributes' => [
                    ['key' => 'tipo_mantenimiento', 'label' => 'Tipo', 'type' => 'select', 'options' => ['Hogar', 'Auto', 'Electrónica', 'Jardinería', 'Limpieza']],
                    ['key' => 'frecuencia', 'label' => 'Frecuencia', 'type' => 'select', 'options' => ['Única vez', 'Semanal', 'Quincenal', 'Mensual']],
                ],
                'optional_attributes' => [
                    ['key' => 'area_cobertura', 'label' => 'Área de Cobertura', 'type' => 'text'],
                    ['key' => 'incluye_materiales', 'label' => 'Incluye Materiales', 'type' => 'select', 'options' => ['Sí', 'No']],
                ],
            ],
            
            'Servicios de Salud y Bienestar' => [
                'product_type' => 'service',
                'description' => 'Servicios de salud, fitness y bienestar',
                'required_attributes' => [
                    ['key' => 'tipo_servicio', 'label' => 'Tipo de Servicio', 'type' => 'select', 'options' => ['Consulta Médica', 'Terapia', 'Entrenamiento Personal', 'Nutrición', 'Masajes', 'Yoga']],
                    ['key' => 'duracion_sesion', 'label' => 'Duración por Sesión', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'modalidad', 'label' => 'Modalidad', 'type' => 'select', 'options' => ['Presencial', 'Online', 'A domicilio']],
                    ['key' => 'certificaciones', 'label' => 'Certificaciones', 'type' => 'text'],
                ],
            ],
            
            'Servicios Educativos' => [
                'product_type' => 'service',
                'description' => 'Clases, tutorías y capacitación',
                'required_attributes' => [
                    ['key' => 'materia', 'label' => 'Materia/Tema', 'type' => 'text'],
                    ['key' => 'nivel', 'label' => 'Nivel', 'type' => 'select', 'options' => ['Primaria', 'Secundaria', 'Preparatoria', 'Universidad', 'Profesional']],
                ],
                'optional_attributes' => [
                    ['key' => 'modalidad', 'label' => 'Modalidad', 'type' => 'select', 'options' => ['Presencial', 'Online', 'Híbrido']],
                    ['key' => 'duracion', 'label' => 'Duración', 'type' => 'text'],
                    ['key' => 'certificacion', 'label' => 'Otorga Certificación', 'type' => 'select', 'options' => ['Sí', 'No']],
                ],
            ],
            
            'Servicios de Eventos' => [
                'product_type' => 'service',
                'description' => 'Organización y servicios para eventos',
                'required_attributes' => [
                    ['key' => 'tipo_evento', 'label' => 'Tipo de Evento', 'type' => 'select', 'options' => ['Boda', 'Cumpleaños', 'Corporativo', 'Social', 'Deportivo']],
                    ['key' => 'servicio', 'label' => 'Servicio', 'type' => 'select', 'options' => ['Catering', 'Decoración', 'Fotografía', 'Música', 'Coordinación Completa']],
                ],
                'optional_attributes' => [
                    ['key' => 'capacidad', 'label' => 'Capacidad de Personas', 'type' => 'text'],
                    ['key' => 'incluye_lugar', 'label' => 'Incluye Lugar', 'type' => 'select', 'options' => ['Sí', 'No']],
                ],
            ],

            // ==================== PRODUCTOS DIGITALES ====================
            
            'Software y Aplicaciones' => [
                'product_type' => 'digital',
                'description' => 'Software, aplicaciones y herramientas digitales',
                'required_attributes' => [
                    ['key' => 'plataforma', 'label' => 'Plataforma', 'type' => 'select', 'options' => ['Windows', 'Mac', 'Linux', 'iOS', 'Android', 'Web', 'Multiplataforma']],
                    ['key' => 'tipo_licencia', 'label' => 'Tipo de Licencia', 'type' => 'select', 'options' => ['Única', 'Suscripción Mensual', 'Suscripción Anual', 'Freemium']],
                ],
                'optional_attributes' => [
                    ['key' => 'version', 'label' => 'Versión', 'type' => 'text'],
                    ['key' => 'requisitos_sistema', 'label' => 'Requisitos del Sistema', 'type' => 'text'],
                    ['key' => 'idioma', 'label' => 'Idioma', 'type' => 'text'],
                ],
            ],
            
            'Cursos Online' => [
                'product_type' => 'digital',
                'description' => 'Cursos y capacitación en línea',
                'required_attributes' => [
                    ['key' => 'tema', 'label' => 'Tema del Curso', 'type' => 'text'],
                    ['key' => 'nivel', 'label' => 'Nivel', 'type' => 'select', 'options' => ['Principiante', 'Intermedio', 'Avanzado', 'Todos los niveles']],
                    ['key' => 'duracion_horas', 'label' => 'Duración (horas)', 'type' => 'number'],
                ],
                'optional_attributes' => [
                    ['key' => 'idioma', 'label' => 'Idioma', 'type' => 'select', 'options' => ['Español', 'Inglés', 'Portugués', 'Francés']],
                    ['key' => 'certificacion', 'label' => 'Otorga Certificado', 'type' => 'select', 'options' => ['Sí', 'No']],
                    ['key' => 'plataforma', 'label' => 'Plataforma', 'type' => 'text'],
                ],
            ],
            
            'Ebooks y Publicaciones Digitales' => [
                'product_type' => 'digital',
                'description' => 'Libros electrónicos y publicaciones digitales',
                'required_attributes' => [
                    ['key' => 'titulo', 'label' => 'Título', 'type' => 'text'],
                    ['key' => 'autor', 'label' => 'Autor', 'type' => 'text'],
                    ['key' => 'formato', 'label' => 'Formato', 'type' => 'select', 'options' => ['PDF', 'EPUB', 'MOBI', 'AZW']],
                ],
                'optional_attributes' => [
                    ['key' => 'paginas', 'label' => 'Número de Páginas', 'type' => 'number'],
                    ['key' => 'idioma', 'label' => 'Idioma', 'type' => 'select', 'options' => ['Español', 'Inglés', 'Otro']],
                    ['key' => 'genero', 'label' => 'Género', 'type' => 'text'],
                ],
            ],
            
            'Música y Audio Digital' => [
                'product_type' => 'digital',
                'description' => 'Música, podcasts y contenido de audio',
                'required_attributes' => [
                    ['key' => 'tipo', 'label' => 'Tipo', 'type' => 'select', 'options' => ['Canción', 'Álbum', 'Podcast', 'Audiolibro', 'Efecto de Sonido']],
                    ['key' => 'formato', 'label' => 'Formato', 'type' => 'select', 'options' => ['MP3', 'FLAC', 'WAV', 'AAC', 'OGG']],
                ],
                'optional_attributes' => [
                    ['key' => 'duracion', 'label' => 'Duración', 'type' => 'text'],
                    ['key' => 'artista', 'label' => 'Artista', 'type' => 'text'],
                    ['key' => 'genero', 'label' => 'Género', 'type' => 'text'],
                ],
            ],
            
            'Videos y Películas Digitales' => [
                'product_type' => 'digital',
                'description' => 'Videos, películas y contenido audiovisual',
                'required_attributes' => [
                    ['key' => 'tipo', 'label' => 'Tipo', 'type' => 'select', 'options' => ['Película', 'Serie', 'Documental', 'Tutorial', 'Curso en Video']],
                    ['key' => 'formato', 'label' => 'Formato', 'type' => 'select', 'options' => ['MP4', 'AVI', 'MKV', 'MOV', 'Streaming']],
                ],
                'optional_attributes' => [
                    ['key' => 'resolucion', 'label' => 'Resolución', 'type' => 'select', 'options' => ['720p', '1080p', '4K', '8K']],
                    ['key' => 'duracion', 'label' => 'Duración', 'type' => 'text'],
                    ['key' => 'idioma', 'label' => 'Idioma', 'type' => 'text'],
                    ['key' => 'subtitulos', 'label' => 'Subtítulos', 'type' => 'text'],
                ],
            ],
            
            'Plantillas y Recursos Digitales' => [
                'product_type' => 'digital',
                'description' => 'Plantillas, mockups y recursos para diseño',
                'required_attributes' => [
                    ['key' => 'tipo', 'label' => 'Tipo', 'type' => 'select', 'options' => ['Plantilla Web', 'Mockup', 'Icon Pack', 'Fuente', 'Preset', 'Brush Pack']],
                    ['key' => 'formato', 'label' => 'Formato', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'software_compatible', 'label' => 'Software Compatible', 'type' => 'text'],
                    ['key' => 'licencia', 'label' => 'Tipo de Licencia', 'type' => 'select', 'options' => ['Personal', 'Comercial', 'Extendida']],
                ],
            ],
        ];

        foreach ($categories as $categoryName => $data) {
            $category = Category::create([
                'name' => $categoryName,
                'slug' => \Illuminate\Support\Str::slug($categoryName),
                'product_type' => $data['product_type'],
                'description' => $data['description'],
                'is_active' => true,
                'attribute_schema' => [
                    'required_attributes' => $data['required_attributes'],
                    'optional_attributes' => $data['optional_attributes'],
                ],
            ]);
            
            $this->command->info("✓ Created {$data['product_type']} category: {$categoryName}");
        }
        
        $physicalCount = Category::where('product_type', 'physical')->count();
        $serviceCount = Category::where('product_type', 'service')->count();
        $digitalCount = Category::where('product_type', 'digital')->count();
        
        $this->command->info("\n✅ Successfully created " . count($categories) . " categories!");
        $this->command->info("   📦 Physical: {$physicalCount}");
        $this->command->info("   🛠️  Services: {$serviceCount}");
        $this->command->info("   💻 Digital: {$digitalCount}");
    }
}
