<?php

namespace App\Imports;

use App\Models\MaterialExcel;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;
class MaterialImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
       $task =  new MaterialExcel([
            'material_code'     => $row['material_code'],
            'product_name'    => $row['product_name'],
            'assign_company_id'    => 1,
            'user_id'    => Auth::user()->id,
            'package'     => $row['package'],
            'market'    => $row['market'],
            'location'     => $row['location'],
            'product_code'    => $row['product_code'],
            'project_name'     => $row['project_name'],
            'project_date'    => $row['project_date'], 
        ]);
        
        return $task;
        
    }
}
