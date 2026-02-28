<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // Main Categories
        $herramientasElectricas = Category::create([
            'name' => 'Herramientas Eléctricas',
            'slug' => 'herramientas-electricas',
            'description' => 'Herramientas eléctricas de alta potencia para profesionales',
            'is_active' => true,
            'is_featured' => true,
            'order' => 1,
        ]);

        $herramientasManuales = Category::create([
            'name' => 'Herramientas Manuales',
            'slug' => 'herramientas-manuales',
            'description' => 'Herramientas manuales de calidad profesional',
            'is_active' => true,
            'is_featured' => true,
            'order' => 2,
        ]);

        $construccion = Category::create([
            'name' => 'Construcción',
            'slug' => 'construccion',
            'description' => 'Materiales y herramientas para construcción',
            'is_active' => true,
            'is_featured' => true,
            'order' => 3,
        ]);

        $electricidad = Category::create([
            'name' => 'Electricidad',
            'slug' => 'electricidad',
            'description' => 'Equipos y materiales eléctricos',
            'is_active' => true,
            'is_featured' => true,
            'order' => 4,
        ]);

        $seguridad = Category::create([
            'name' => 'Seguridad Industrial',
            'slug' => 'seguridad-industrial',
            'description' => 'Equipos de protección personal y seguridad',
            'is_active' => true,
            'is_featured' => false,
            'order' => 5,
        ]);

        // Subcategories for Herramientas Eléctricas
        Category::create([
            'parent_id' => $herramientasElectricas->id,
            'name' => 'Taladros',
            'slug' => 'taladros',
            'description' => 'Taladros percutores y atornilladores',
            'is_active' => true,
            'order' => 1,
        ]);

        Category::create([
            'parent_id' => $herramientasElectricas->id,
            'name' => 'Sierras',
            'slug' => 'sierras',
            'description' => 'Sierras circulares, caladoras y más',
            'is_active' => true,
            'order' => 2,
        ]);

        Category::create([
            'parent_id' => $herramientasElectricas->id,
            'name' => 'Lijadoras',
            'slug' => 'lijadoras',
            'description' => 'Lijadoras orbitales y de banda',
            'is_active' => true,
            'order' => 3,
        ]);

        // Subcategories for Herramientas Manuales
        Category::create([
            'parent_id' => $herramientasManuales->id,
            'name' => 'Llaves',
            'slug' => 'llaves',
            'description' => 'Llaves combinadas, allen y más',
            'is_active' => true,
            'order' => 1,
        ]);

        Category::create([
            'parent_id' => $herramientasManuales->id,
            'name' => 'Destornilladores',
            'slug' => 'destornilladores',
            'description' => 'Destornilladores de precisión y uso general',
            'is_active' => true,
            'order' => 2,
        ]);

        Category::create([
            'parent_id' => $herramientasManuales->id,
            'name' => 'Martillos',
            'slug' => 'martillos',
            'description' => 'Martillos de carpintero, goma y más',
            'is_active' => true,
            'order' => 3,
        ]);
    }
}
