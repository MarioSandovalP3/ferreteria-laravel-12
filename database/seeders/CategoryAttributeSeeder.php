<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryAttributeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Ropa' => [
                'required_attributes' => [
                    ['key' => 'talla', 'label' => 'Talla', 'type' => 'select', 'options' => ['XS', 'S', 'M', 'L', 'XL', 'XXL', 'XXXL']],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                    ['key' => 'genero', 'label' => 'Género', 'type' => 'select', 'options' => ['Hombre', 'Mujer', 'Unisex', 'Niño', 'Niña']],
                    ['key' => 'material', 'label' => 'Material', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'estilo', 'label' => 'Estilo', 'type' => 'text'],
                    ['key' => 'tipo_ajuste', 'label' => 'Tipo de Ajuste', 'type' => 'select', 'options' => ['Ajustado', 'Regular', 'Holgado']],
                    ['key' => 'largo_manga', 'label' => 'Largo de Manga', 'type' => 'select', 'options' => ['Sin manga', 'Corta', '3/4', 'Larga']],
                ],
            ],
            'Calzado' => [
                'required_attributes' => [
                    ['key' => 'talla', 'label' => 'Talla', 'type' => 'select', 'options' => array_map('strval', range(35, 48))],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                    ['key' => 'material_exterior', 'label' => 'Material Exterior', 'type' => 'select', 'options' => ['Cuero', 'Sintético', 'Tela', 'Gamuza']],
                    ['key' => 'material_suela', 'label' => 'Material Suela', 'type' => 'select', 'options' => ['Goma', 'EVA', 'Caucho', 'Sintético']],
                ],
                'optional_attributes' => [
                    ['key' => 'tipo_calzado', 'label' => 'Tipo de Calzado', 'type' => 'select', 'options' => ['Zapatilla', 'Sandalia', 'Bota', 'Zapato formal', 'Deportivo']],
                    ['key' => 'tipo_cierre', 'label' => 'Tipo de Cierre', 'type' => 'select', 'options' => ['Cordones', 'Velcro', 'Sin cierre', 'Hebilla', 'Cremallera']],
                ],
            ],
            'Electrónica' => [
                'required_attributes' => [
                    ['key' => 'marca', 'label' => 'Marca', 'type' => 'text'],
                    ['key' => 'modelo', 'label' => 'Modelo', 'type' => 'text'],
                    ['key' => 'capacidad', 'label' => 'Capacidad', 'type' => 'text'],
                    ['key' => 'ram', 'label' => 'RAM', 'type' => 'text'],
                    ['key' => 'pantalla', 'label' => 'Pantalla', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'conectividad', 'label' => 'Conectividad', 'type' => 'text'],
                    ['key' => 'sistema_operativo', 'label' => 'Sistema Operativo', 'type' => 'text'],
                    ['key' => 'bateria', 'label' => 'Batería', 'type' => 'text'],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                ],
            ],
            'Hogar' => [
                'required_attributes' => [
                    ['key' => 'material', 'label' => 'Material', 'type' => 'select', 'options' => ['Acero inoxidable', 'Plástico', 'Vidrio', 'Cerámica', 'Madera', 'Aluminio']],
                    ['key' => 'dimensiones', 'label' => 'Dimensiones', 'type' => 'text'],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'capacidad', 'label' => 'Capacidad', 'type' => 'text'],
                    ['key' => 'voltaje', 'label' => 'Voltaje', 'type' => 'select', 'options' => ['110V', '220V', 'Dual']],
                    ['key' => 'peso', 'label' => 'Peso', 'type' => 'text'],
                ],
            ],
            'Juguetes' => [
                'required_attributes' => [
                    ['key' => 'edad_recomendada', 'label' => 'Edad Recomendada', 'type' => 'select', 'options' => ['0-2 años', '3-5 años', '6-8 años', '9-12 años', '13+ años']],
                    ['key' => 'material', 'label' => 'Material', 'type' => 'select', 'options' => ['Plástico', 'Madera', 'Tela', 'Metal', 'Mixto']],
                    ['key' => 'tipo_juguete', 'label' => 'Tipo de Juguete', 'type' => 'select', 'options' => ['Construcción', 'Educativo', 'Peluche', 'Acción', 'Muñeca', 'Vehículo']],
                ],
                'optional_attributes' => [
                    ['key' => 'baterias', 'label' => 'Requiere Baterías', 'type' => 'select', 'options' => ['Sí', 'No', 'Incluidas']],
                    ['key' => 'piezas', 'label' => 'Número de Piezas', 'type' => 'number'],
                    ['key' => 'color', 'label' => 'Color', 'type' => 'text'],
                ],
            ],
            'Belleza' => [
                'required_attributes' => [
                    ['key' => 'tipo_producto', 'label' => 'Tipo de Producto', 'type' => 'select', 'options' => ['Crema', 'Loción', 'Sérum', 'Mascarilla', 'Limpiador', 'Tónico', 'Maquillaje']],
                    ['key' => 'contenido', 'label' => 'Contenido', 'type' => 'text'],
                ],
                'optional_attributes' => [
                    ['key' => 'tipo_piel', 'label' => 'Tipo de Piel', 'type' => 'select', 'options' => ['Seca', 'Grasa', 'Mixta', 'Normal', 'Sensible', 'Todo tipo']],
                    ['key' => 'aroma', 'label' => 'Aroma', 'type' => 'text'],
                    ['key' => 'spf', 'label' => 'Factor de Protección (SPF)', 'type' => 'select', 'options' => ['15', '30', '50', '50+', 'Sin SPF']],
                ],
            ],
        ];

        foreach ($categories as $categoryName => $schema) {
            $category = \App\Models\Category::where('name', $categoryName)->first();
            
            if (!$category) {
                // Create category if it doesn't exist
                $category = \App\Models\Category::create([
                    'name' => $categoryName,
                    'slug' => \Illuminate\Support\Str::slug($categoryName),
                    'description' => "Categoría de {$categoryName}",
                    'is_active' => true,
                    'attribute_schema' => $schema,
                ]);
                
                $this->command->info("✓ Created category with attributes: {$categoryName}");
            } else {
                // Update existing category
                $category->update([
                    'attribute_schema' => $schema,
                ]);
                
                $this->command->info("✓ Updated attribute schema for category: {$categoryName}");
            }
        }
        
        $this->command->info("\n✅ Category attribute schemas configured successfully!");
    }
}
