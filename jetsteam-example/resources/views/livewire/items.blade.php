<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
            {{$query}}
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
                            <td class="border p-2">edit | delete</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-8">
        {{$items->links()}}
    </div>
</div>

