<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $metodos = [
            ['name' => 'Efectivo', 'description' => 'Pago con dinero físico.'],
            ['name' => 'Tarjeta C/D', 'description' => 'Terminal Punto de Venta (POS).'],
            ['name' => 'Transferencia', 'description' => 'Transferencias bancarias directas.'],
        ];

        foreach ($metodos as $metodo) {
            PaymentMethod::create($metodo);
        }
    }
}
