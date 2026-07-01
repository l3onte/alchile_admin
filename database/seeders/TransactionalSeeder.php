<?php

namespace Database\Seeders;

use App\Models\Branch;
use App\Models\BranchProduct;
use App\Models\CashRegister;
use App\Models\CashShift;
use App\Models\CashTransaction;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\OrderItemModifier;
use App\Models\PaymentMethod;
use App\Models\ProductMovement;
use App\Models\Supply;
use App\Models\SupplyMovement;
use App\Models\SupplyPurchaseHistory;
use App\Models\User;
use App\Models\Waste;
use Illuminate\Database\Seeder;

class TransactionalSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $registers = CashRegister::all();
        $paymentMethods = PaymentMethod::all();
        $supplies = Supply::all();
        $branches = Branch::all();

        for ($i = 0; $i < 5; $i++) {
            $register = $registers->random();
            $user = $users->random();

            $shift = CashShift::factory()->create([
                'cash_register_id' => $register->id,
                'user_id' => $user->id,
            ]);

            CashTransaction::factory()->count(2)->create([
                'cash_shift_id' => $shift->id,
            ]);

            $orders = Order::factory()->count(6)->create([
                'cash_shift_id' => $shift->id,
                'payment_method_id' => $paymentMethods->random()->id,
            ]);

            foreach ($orders as $order) {
                $branchProducts = BranchProduct::where('branch_id', $register->branch_id)->get();
                if ($branchProducts->isEmpty()) continue;

                $sampledProducts = $branchProducts->random(rand(1, 3));
                $totalOrden = 0;

                foreach ($sampledProducts as $bp) {
                    $qty = rand(1, 2);
                    $subtotal = $qty * $bp->price;
                    $totalOrden += $subtotal;

                    $detail = OrderDetail::create([
                        'order_id' => $order->id,
                        'product_id' => $bp->product_id,
                        'quantity' => $qty,
                        'unit_price' => $bp->price,
                        'subtotal' => $subtotal,
                    ]);

                    if (fake()->boolean(30)) {
                        OrderItemModifier::factory()->create([
                            'order_detail_id' => $detail->id,
                            'supply_id' => $supplies->random()->id,
                        ]);
                    }

                    ProductMovement::factory()->create([
                        'user_id' => $user->id,
                        'branch_id' => $register->branch_id,
                        'product_id' => $bp->product_id,
                        'order_id' => $order->id,
                        'quantity' => $qty,
                    ]);
                }

                $order->update([
                    'total_amount' => $totalOrden,
                    'payment_amount' => $totalOrden + 100.00,
                    'change_amount' => 100.00,
                ]);
            }
        }

        foreach ($branches as $b) {
            Waste::factory()->count(3)->create([
                'branch_id' => $b->id,
                'user_id' => $users->random()->id,
                'supply_id' => $supplies->random()->id,
            ]);

            SupplyMovement::factory()->count(3)->create([
                'branch_id' => $b->id,
                'user_id' => $users->random()->id,
                'supply_id' => $supplies->random()->id,
            ]);

            $randomSupply = $supplies->random();
            SupplyPurchaseHistory::factory()->count(2)->create([
                'branch_id' => $b->id,
                'supply_id' => $randomSupply->id,
                'supplier_id' => $randomSupply->supplier_id,
            ]);
        }
    }
}