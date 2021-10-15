<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\Item;
use Livewire\WithPagination;

class Items extends Component
{
    use WithPagination;

    public $active;
    public $search;
    public $sortBy = 'id';
    public $sortAsc = true;
    public $item;

    public $confirmingItemDeletion = false;
    public $confirmingItemAdd = false;

    protected $queryString = [
        'active' => ['except' => false],
        'search' => ['except' => ''],
        'sortBy' => ['except' => 'id'],
        'sortAsc' => ['except' => true],
    ];

    protected $rules=[
        'item.name' => 'required|string|min:4',
        'item.price' => 'required|numeric|between:1,100',
        'item.status' => 'boolean'
    ];

    public function render()
    {
        $items = Item::where('user_id', auth()->user()->id)
        ->when($this->search, function($query){
            return $query
                ->where('name', 'like', '%'. $this->search.'%')
                ->orWhere('price', 'like', '%'.$this->search. '%');
        })
        ->when($this->active, function($query){
            return $query->Active();
        })
        ->orderBy($this->sortBy, $this->sortAsc ? 'ASC': 'DESC');

        $query = $items->toSql();
        $items = $items->paginate(10);

        return view('livewire.items', [
            'items' => $items,
            'query' => $query,
        ]);
    }

    public function updatingActive()
    {
        $this->resetPage();
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function sortBy($field)
    {
        if ($field == $this->sortBy) {
            $this->sortAsc = !$this->sortAsc;
        }
        $this->sortBy = $field;
    }

    public function confirmItemDeletion($id)
    {
        $this->confirmingItemDeletion = $id;
    }

    public function deleteItem(Item $item)
    {   
        $item->delete();
        $this->confirmingItemDeletion = false;
        session()->flash('message', 'Item deleted successfully.');
    }

    public function confirmItemAdd()
    {
        $this->reset(['item']);
        $this->confirmingItemAdd = true;
    }

    public function confirmItemEdit(Item $item)
    {   
        $this->item = $item;
        $this->confirmingItemAdd = true;
    }

    public function addItem()
    {
        $this->validate();

        if (isset($this->item->id)) {
            $this->item->save();
            session()->flash('message', 'Item saved successfully.');
        } else {

            auth()->user()->items()->create([
                'name'=> $this->item['name'],
                'price'=> $this->item['price'],
                'status'=> $this->item['status'] ?? 0,
            ]);
            session()->flash('message', 'Item added successfully.');
        }

        $this->confirmingItemAdd = false;
    }
}
