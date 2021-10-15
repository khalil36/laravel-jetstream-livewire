<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            @if(session()->has('message'))
            <div class="flex items-center bg-blue-500 text-white text-sm font-bold px-4 py-3" style="background: blue;" role="alert">
              <svg class="fill-current w-4 h-4 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M12.432 0c1.34 0 2.01.912 2.01 1.957 0 1.305-1.164 2.512-2.679 2.512-1.269 0-2.009-.75-1.974-1.99C9.789 1.436 10.67 0 12.432 0zM8.309 20c-1.058 0-1.833-.652-1.093-3.524l1.214-5.092c.211-.814.246-1.141 0-1.141-.317 0-1.689.562-2.502 1.117l-.528-.88c2.572-2.186 5.531-3.467 6.801-3.467 1.057 0 1.233 1.273.705 3.23l-1.391 5.352c-.246.945-.141 1.271.106 1.271.317 0 1.357-.392 2.379-1.207l.6.814C12.098 19.02 9.365 20 8.309 20z"/></svg>
              <p>{{session()->get('message')}}</p>
            </div>
            @endif
            <div class="flex justify-between">
                <div>Items</div>
                <div>
                    <x-jet-button class="ml-2" wire:click="confirmItemAdd" wire:loading.attr="disabled">
                        {{ __('Add Item') }}
                    </x-jet-button>
                </div>
            </div>
            <div class="flex justify-between">
                <div>
                    <input type="search" wire:model="search" placeholder="search" class="border focus:ring-evoke focus:border-evoke block w-full rounded-none rounded-l-md pl-10 sm:text-sm border-gray-300">
                </div>
                <div class="mr-2">
                    <input type="checkbox" wire:model="active" class="mr-2 leading-right">Active Only?
                </div>
            </div>
            <table class="w-full table-auto">
                <thead>
                    <tr>
                        
                        <th class="p-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('id')">ID</button>
                                <x-sort-icons sortField='id' :sort-by="$sortBy" :sort-asc="$sortAsc" />
                            </div>
                        </th>
                        <th class="p-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('name')">Name</button>
                                <x-sort-icons sortField='name' :sort-by="$sortBy" :sort-asc="$sortAsc" />
                            </div>
                        </th>
                        <th class="p-2">
                            <div class="flex items-center">
                                <button wire:click="sortBy('price')">Price</button>
                                <x-sort-icons sortField='price' :sort-by="$sortBy" :sort-asc="$sortAsc" />
                            </div>
                        </th>
                        <th class="p-2">
                            Status
                        </th>
                        <th class="p-2">
                            Actions
                        </th>
                    </tr>
                
                </thead>
                <tbody>
                    @foreach($items as $item)
                        <tr>
                            <td class="border p-2">{{$item->id}}</td>
                            <td class="border p-2">{{$item->name}}</td>
                            <td class="border p-2">{{number_format($item->price, 2)}}</td>
                            <td class="border p-2">{{$item->status ? 'Acitve' : 'De-Active'}}</td>
                            <td class="border p-2">
                                <x-jet-button class="ml-2 bg-orange-500" wire:click="confirmItemEdit({{$item->id}})" wire:loading.attr="disabled">
                                    {{ __('Edit') }}
                                </x-jet-button> 
                                <x-jet-danger-button wire:click="confirmItemDeletion({{$item->id}})" wire:loading.attr="disabled">
                                    {{ __('Delete Item') }}
                                </x-jet-danger-button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-8">
        {{$items->links()}}
    </div>

    <!-- Delete Item Confirmation Modal -->
    <x-jet-confirmation-modal wire:model="confirmingItemDeletion">
        <x-slot name="title">
            {{ __('Delete Item') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you want to delete this item?') }}

        
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingItemDeletion', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="deleteItem({{$confirmingItemDeletion}})" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-confirmation-modal>

    <!-- Add Item Confirmation Modal -->
    <x-jet-dialog-modal wire:model="confirmingItemAdd">
        <x-slot name="title">
            {{ isset($this->item->id) ? __('Edit Item') : __('Add Item')}}
        </x-slot>

        <x-slot name="content">
            
            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="name" value="{{ __('Name') }}" />
                <x-jet-input id="name" type="text" class="mt-1 block w-full" wire:model.defer="item.name" autocomplete="name" />
                <x-jet-input-error for="item.name" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <x-jet-label for="price" value="{{ __('price') }}" />
                <x-jet-input id="price" type="text" class="mt-1 block w-full" wire:model.defer="item.price" autocomplete="price" />
                <x-jet-input-error for="item.price" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4 mt-4">
                <div class="flex">
                    <label><input type="checkbox" name="item.status" wire:model='item.status'>Active</label>
                </div>
            </div>

        
        </x-slot>

        <x-slot name="footer">
            <x-jet-secondary-button wire:click="$set('confirmingItemAdd', false)" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-jet-secondary-button>

            <x-jet-danger-button class="ml-2" wire:click="addItem" wire:loading.attr="disabled">
                {{ __('Save') }}
            </x-jet-danger-button>
        </x-slot>
    </x-jet-dialog-modal>

</div>

