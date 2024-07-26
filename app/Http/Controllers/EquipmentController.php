<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Equipment;

class EquipmentController extends Controller
{
    public function getEquipment(Request $request)
    {
        $equipment = Equipment::where('equipment_number', $request->equipment_number)->first();
        return response()->json($equipment);
    }

    public function updateEquipment(Request $request)
    {
        $equipment = Equipment::updateOrCreate(
            ['equipment_number' => $request->equipment_number],
            ['name' => $request->name, 'description' => $request->description]
        );
        return response()->json(['status' => 'success']);
    }

    public function fetchAllEquipments()
    {
            $equipments = Equipment::all();
            return response()->json($equipments);
    }




    public function syncEquipments(Request $request)
    {
        foreach ($request->equipments as $equip) {
            Equipment::updateOrCreate(
                ['equipment_number' => $equip['equipment_number']],
                ['name' => $equip['name'], 'description' => $equip['description']]
            );
        }
        return response()->json(['status' => 'success']);
    }
}
