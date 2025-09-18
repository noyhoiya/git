<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purpose extends Model
{
    use HasFactory;

    protected $primaryKey = 'purpose_code';
    public $incrementing = false;
    protected $keyType = 'string';
    
    protected $fillable = [
        'purpose_code',
        'purpose_name',
    ];

    public $timestamps = false;

    public function cashRequests()
    {
        return $this->hasMany(CashRequest::class, 'purpose_code');
    }

    public function vaultMovements()
    {
        return $this->hasMany(VaultMovement::class, 'purpose_code');
    }

    public static function getDefaultPurposes()
    {
        return [
            'TELLER_SERVICE' => 'ບໍລິການເງິນສົດລູກຄ້າ',
            'ADMIN_DAILY' => 'ຄ່າໃຊ້ຈ່າຍບໍລິຫານປະຈຳວັນ',
            'UTILITIES' => 'ສາທາລະນູປະໂພກ (ນ້ຳ, ໄຟຟ້າ, ອິນເຕີເນັດ)',
            'OFFICE_SUPPLIES' => 'ຊື້ອຸປະກອນຫ້ອງການ',
            'REPAIR' => 'ສ້ອມແປງອຸປະກອນຫ້ອງການ',
            'EOD_SURPLUS' => 'ເງິນເຫຼືອປີ້ງວັນ',
            'BANK_WITHDRAW' => 'ຖອນເງິນຈາກທະນາຄານ',
            'OTHER' => 'ອື່ນໆ'
        ];
    }
}