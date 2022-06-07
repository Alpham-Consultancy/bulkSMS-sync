<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\Importable;

class CustomersImport implements ToModel, WithHeadingRow



{

    use Importable;

    /**
    * @param array $row
    
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */


 
    
    public function model(array $row)
    {

        return new User([
            //
            'name'     => $row['name'],
            'phone'    => $row['phone'], 
            // 'user_id'  => $id,
        ]);
    }
}
