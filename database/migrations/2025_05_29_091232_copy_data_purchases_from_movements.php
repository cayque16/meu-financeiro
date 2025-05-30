<?php

use Core\Domain\Enum\MovementType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $purchases = DB::table("purchases")->get();

        foreach ($purchases as $purchase) {
            $brokerage = DB::table("brokerages")->where("id", $purchase->id_brokerages)->first();
            $currency = DB::table("currencies")->where("iso_code", "BRL")->first();

            $now = now();
            $uuidMovement = Str::uuid();
            DB::table("movements")->insert([
                'id' => $uuidMovement,
                'date' => $purchase->data,
                'brokerage_id' => $brokerage->uuid,
                'currency_id' => $currency->id,
                'type' => MovementType::PURCHASE->value,
                'created_at' => $purchase->created_at,
                'updated_at' => $purchase->updated_at,
                'deleted_at' => $purchase->e_excluido ? $now : null,
            ]);
            
            $itemsPurchase = DB::table('asset_purchase')->where('purchase_id', $purchase->id)->get();
            foreach ($itemsPurchase as $item) {
                $asset = DB::table('assets')->where('id', $item->asset_id)->first();

                DB::table('asset_movements')->insert([
                    'movement_id' => $uuidMovement,
                    'asset_id' => $asset->uuid,
                    'amount' => $item->quantidade,
                    'unit_value' => $item->valor_unitario * 100,
                    'value_fees' => $item->taxas *100,
                    'created_at' => $item->created_at,
                    'updated_at' => $item->updated_at,
                    'deleted_at' => $item->e_excluido ? $now : null,
                ]);
            }
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::table("movements")->truncate();
        DB::table("asset_movements")->truncate();
    }
};
