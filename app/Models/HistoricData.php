<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HistoricData extends Model
{
    use HasFactory;

    protected $table = "historic_data";

    protected $fillable = ['user_id','year','generation_incl_aux','total_generation_excl','power_purchased','external_pgcl','generation_purchase','energy_injected_outside_state',
    'energy_purchased_outside_state','energy_sales_in_state','swap_return','energy_injected_within_state','energy_purchased_within_state',
    'energy_available_within_state','energy_sales_export','energy_adjusted','energy_sales_incl_sale','energy_loss','percentage_loss',
    'max_demand','status_id'];

}
