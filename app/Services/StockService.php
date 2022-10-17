<?php
namespace App\Services;
use App\Models\Item;

class StockService {

    public function getStockInHandData(){

        $items = Item::where('sold_out', '=', '0')->get();
        $count = 0;
        //for gold
        $total_gold_plus_gem_weight_kyat = 0;
        $total_gold_plus_gem_weight_pal = 0;
        $total_gold_plus_gem_weight_yway = 0;

        //for gem
        $total_gem_weight_kyat = 0;
        $total_gem_weight_pal = 0;
        $total_gem_weight_yway = 0;

        if(!$items->isEmpty()){
            foreach ($items as $item){
                $count ++;
                $total_gold_plus_gem_weight_kyat += (int) $item->gold_plus_gem_weight->kyat;
                $total_gold_plus_gem_weight_pal += (int) $item->gold_plus_gem_weight->pal;
                $total_gold_plus_gem_weight_yway += $item->gold_plus_gem_weight->yway;

                $total_gem_weight_kyat += (int) $item->gem_weight->kyat;
                $total_gem_weight_pal += (int) $item->gem_weight->pal;
                $total_gem_weight_yway += $item->gem_weight->yway;
            }

            if($total_gold_plus_gem_weight_yway > 7.9){
                $total_gold_plus_gem_weight_pal += (int) ($total_gold_plus_gem_weight_yway / 8);
                $total_gold_plus_gem_weight_yway = round(fmod($total_gold_plus_gem_weight_yway, 8), 2);
            }
            if($total_gold_plus_gem_weight_pal > 15){
                $total_gold_plus_gem_weight_kyat += (int) ($total_gold_plus_gem_weight_pal / 16);
                $total_gold_plus_gem_weight_pal = round(fmod($total_gold_plus_gem_weight_pal, 16), 2);
            }
            if($total_gem_weight_yway > 7.9){
                $total_gem_weight_pal +=(int) ($total_gem_weight_yway / 8);
                $total_gem_weight_yway = round(fmod($total_gem_weight_yway, 8), 2);
            }
            if($total_gem_weight_pal > 15){
                $total_gem_weight_kyat += (int) ($total_gem_weight_pal / 16);
                $total_gem_weight_pal = round(fmod($total_gem_weight_pal, 16), 2);
            }
        }
        $total_gold_plus_gem_weight = [
            "kyat" => $total_gold_plus_gem_weight_kyat,
            "pal" => $total_gold_plus_gem_weight_pal,
            "yway" => $total_gold_plus_gem_weight_yway,
        ];
        $total_gem_weight = [
            "kyat" => $total_gem_weight_kyat,
            "pal" => $total_gem_weight_pal,
            "yway" => $total_gem_weight_yway,
        ];

        return [
            'item_count' => $count,
            'total_gold_plus_gem_weight' => $total_gold_plus_gem_weight,
            'total_gem_weight' => $total_gem_weight,
        ];

    }

}
