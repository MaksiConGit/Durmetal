<?php

namespace App\Livewire;

use App\Models\Material;
use Livewire\Component;

class Materiales extends Component
{
    public $materiales;
    public $selectedMaterial;
    public $selectedItem = null;

    public function mount()
    {
        $this->materiales = Material::all();

        if (session('material_id')) {
            $this->selectedMaterial = Material::find(session('material_id'));
        }
        else{
            $this->selectedMaterial = Material::first();
        }
    }

    public function selectItem($id)
    {
        $this->selectedItem = $id;
        $this->selectedMaterial = Material::find($this->selectedItem);
    }

    public function deleteItem($id)
    {
        if (!$id) return;

        $material = Material::find($id);
        if ($material) {
            $material->delete();
            $this->selectedItem = null;
            $this->materiales = Material::all();
        }
    }

    public function render()
    {
        return view('livewire.materiales');
    }
}
