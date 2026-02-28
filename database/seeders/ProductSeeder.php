<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        // Get categories
        $smartphones = Category::where('slug', 'smartphones-y-tablets')->first();
        $laptops = Category::where('slug', 'computadoras-y-laptops')->first();
        $ropaHombre = Category::where('slug', 'ropa-hombre')->first();
        $serviciosProfesionales = Category::where('slug', 'servicios-profesionales')->first();
        $cursosOnline = Category::where('slug', 'cursos-online')->first();
        $software = Category::where('slug', 'software-y-aplicaciones')->first();

        // Get brands
        $samsung = Brand::where('name', 'Samsung')->first();
        $apple = Brand::where('name', 'Apple')->first();
        $lenovo = Brand::where('name', 'Lenovo')->first();
        $nike = Brand::where('name', 'Nike')->first();

        // ==================== PRODUCTOS FÍSICOS ====================
        
        // Smartphone
        if ($smartphones && $samsung) {
            Product::create([
                'category_id' => $smartphones->id,
                'product_type' => 'physical',
                'sku' => 'SAM-A54-256',
                'name' => 'Samsung Galaxy A54 5G',
                'slug' => 'samsung-galaxy-a54-5g',
                'short_description' => 'Smartphone 5G con pantalla Super AMOLED',
                'description' => 'Samsung Galaxy A54 5G con pantalla Super AMOLED de 6.4", cámara triple de 50MP, batería de 5000mAh y carga rápida de 25W.',
                'price' => 8999.00,
                'compare_at_price' => 9999.00,
                'on_sale' => true,
                'sale_price' => 7999.00,
                'stock' => 45,
                'brand_id' => $samsung->id,
                'variant_attributes' => [
                    'modelo' => 'Galaxy A54 5G',
                    'capacidad' => '256GB',
                    'ram' => '8GB',
                    'pantalla' => '6.4 pulgadas Super AMOLED',
                    'color' => 'Awesome Violet',
                    'sistema_operativo' => 'Android 13',
                    'bateria' => '5000mAh',
                    'camara' => '50MP + 12MP + 5MP',
                ],
                'is_active' => true,
                'is_featured' => true,
                'is_new' => true,
            ]);
        }

        // Laptop
        if ($laptops && $lenovo) {
            Product::create([
                'category_id' => $laptops->id,
                'product_type' => 'physical',
                'sku' => 'LEN-TP-X1',
                'name' => 'Lenovo ThinkPad X1 Carbon Gen 11',
                'slug' => 'lenovo-thinkpad-x1-carbon-gen-11',
                'short_description' => 'Laptop empresarial ultraligera',
                'description' => 'Lenovo ThinkPad X1 Carbon Gen 11 con procesador Intel Core i7, 16GB RAM, SSD de 512GB, pantalla 14" WUXGA.',
                'price' => 32999.00,
                'stock' => 12,
                'brand_id' => $lenovo->id,
                'variant_attributes' => [
                    'modelo' => 'ThinkPad X1 Carbon Gen 11',
                    'procesador' => 'Intel Core i7-1355U',
                    'ram' => '16GB LPDDR5',
                    'almacenamiento' => '512GB SSD NVMe',
                    'pantalla' => '14" WUXGA (1920x1200)',
                    'sistema_operativo' => 'Windows 11 Pro',
                    'color' => 'Negro',
                ],
                'is_active' => true,
                'is_featured' => true,
            ]);
        }

        // Ropa
        if ($ropaHombre && $nike) {
            Product::create([
                'category_id' => $ropaHombre->id,
                'product_type' => 'physical',
                'sku' => 'NIKE-DRI-FIT-M',
                'name' => 'Nike Dri-FIT Camiseta Deportiva',
                'slug' => 'nike-dri-fit-camiseta-deportiva',
                'short_description' => 'Camiseta deportiva con tecnología Dri-FIT',
                'description' => 'Camiseta deportiva Nike con tecnología Dri-FIT que absorbe el sudor, diseño ergonómico y costuras planas para mayor comodidad.',
                'price' => 599.00,
                'stock' => 150,
                'brand_id' => $nike->id,
                'variant_attributes' => [
                    'talla' => 'M',
                    'color' => 'Negro',
                    'material' => '100% Poliéster Dri-FIT',
                    'tipo_prenda' => 'Camiseta',
                    'estilo' => 'Deportivo',
                    'ajuste' => 'Regular',
                ],
                'is_active' => true,
            ]);
        }

        // ==================== SERVICIOS ====================
        
        if ($serviciosProfesionales) {
            Product::create([
                'category_id' => $serviciosProfesionales->id,
                'product_type' => 'service',
                'sku' => 'CONS-WEB-DEV',
                'name' => 'Consultoría de Desarrollo Web',
                'slug' => 'consultoria-desarrollo-web',
                'short_description' => 'Asesoría profesional para proyectos web',
                'description' => 'Servicio de consultoría especializada en desarrollo web, arquitectura de software, optimización de rendimiento y mejores prácticas.',
                'price' => 1500.00,
                'stock' => 999, // Servicios ilimitados
                'variant_attributes' => [
                    'tipo_servicio' => 'Consultoría',
                    'duracion' => '2 horas',
                    'modalidad' => 'Remoto',
                    'nivel' => 'Experto',
                ],
                'is_active' => true,
                'is_featured' => true,
            ]);
        }

        // ==================== PRODUCTOS DIGITALES ====================
        
        if ($cursosOnline) {
            Product::create([
                'category_id' => $cursosOnline->id,
                'product_type' => 'digital',
                'sku' => 'CURSO-LARAVEL-ADV',
                'name' => 'Curso Avanzado de Laravel 11',
                'slug' => 'curso-avanzado-laravel-11',
                'short_description' => 'Domina Laravel 11 desde cero hasta nivel avanzado',
                'description' => 'Curso completo de Laravel 11 con más de 40 horas de contenido, proyectos prácticos, certificado de finalización y acceso de por vida.',
                'price' => 1299.00,
                'compare_at_price' => 1999.00,
                'on_sale' => true,
                'sale_price' => 999.00,
                'stock' => 999, // Digital ilimitado
                'variant_attributes' => [
                    'tema' => 'Desarrollo Web con Laravel 11',
                    'nivel' => 'Intermedio',
                    'duracion_horas' => 42,
                    'idioma' => 'Español',
                    'certificacion' => 'Sí',
                    'plataforma' => 'Udemy',
                ],
                'is_active' => true,
                'is_featured' => true,
                'is_new' => true,
            ]);
        }

        if ($software) {
            Product::create([
                'category_id' => $software->id,
                'product_type' => 'digital',
                'sku' => 'SW-PHPSTORM-2024',
                'name' => 'PHPStorm 2024 - Licencia Anual',
                'slug' => 'phpstorm-2024-licencia-anual',
                'short_description' => 'IDE profesional para desarrollo PHP',
                'description' => 'Licencia anual de PHPStorm 2024, el IDE más completo para desarrollo PHP con soporte para Laravel, Symfony, WordPress y más.',
                'price' => 2499.00,
                'stock' => 999,
                'variant_attributes' => [
                    'plataforma' => 'Multiplataforma',
                    'tipo_licencia' => 'Suscripción Anual',
                    'version' => '2024.1',
                    'requisitos_sistema' => '8GB RAM, 2GB espacio en disco',
                    'idioma' => 'Inglés',
                ],
                'is_active' => true,
                'is_featured' => true,
            ]);
        }

        $this->command->info('✅ Created 6 sample products (2 physical, 1 service, 2 digital)');
    }
}
