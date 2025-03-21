<?php

namespace App\Filament\Resources\OrderResource\Pages;

use App\Filament\Resources\OrderResource;
use App\Models\OrderProcess;
use App\Models\OrderTemplate;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateOrder extends CreateRecord
{
    protected static string $resource = OrderResource::class;

    public function create(bool $another = false): void
    {
        parent::create($another);

        $template = OrderTemplate::find($this->data['order_template_id']);

        if(isset($template->processes)){
            foreach ($template->processes as $process){
                $step = new OrderProcess();
                $step->step = $process->step;
                $step->status = 'в очікуванні';
                $step->order_id = $this->record->id;
                if(empty($this->record->rate_per)){
                    $step->rate_per = 100;
                }else{
                    $step->rate_per = $this->record->rate_per;
                }
                $step->save();
            }
        }


       // dd($another,$this->record->id,$template->processes);
        // Додатковий код після створення замовлення
    }
}
