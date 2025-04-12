<?php

namespace App\Exports;

use App\Models\frontend\EcosansarUsers;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class SABUsersExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
       // Return all users and all columns
       return EcosansarUsers::all();
    }
    public function headings(): array
    {
        return [
            'ID',
            'Unique ID',
            'Name',
            'Mobile',
            'OTP',
            'OTP Expire',
            'Address',
            'Pincode',
            'Type of residence',
            'Email',
            'Password',
            'Contact Person',
            'User type',
            'Is verify',
            'Is checked',
            'Is reigster',
            'Is delete',
            'Created At',
            'Updated At'
        ];
    }
}
