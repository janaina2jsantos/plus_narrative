<div id="last-users">
    <div class="flex justify-between items-center px-2 py-4">
        @can('administer users')
            <h1 class="font-bold py-4 uppercase">{{ $title }}</h1>
            <a href="{{ $buttonRoute }}" class="bg-blue-500 hover:bg-blue-900 text-white font-bold text-center px-4 py-2">{{ $buttonTitle }}</a>
        @endcan
    </div>
    <!-- filter -->
    <div class="w-full max-w-lg mb-8">
        <input type="text" wire:model="filter" class="w-2/3 flex-1 py-2 bg-[#0a0a0a] border-b-2 border-[#0a0a0a] focus:border-blue-900 text-gray-200 placeholder-gray-400 outline-none" placeholder="Search for users" wire:keyup="$emit('searchUsers')" />
        <button class="bg-[#0a0a0a] px-4 py-[10px]" wire:click="$emit('searchUsers')"><i class="fa fa-search"></i></button>
    </div>

    <div class="overflow-x-scroll">
        <table class="w-full whitespace-nowrap">
            <thead class="bg-black/60">
                <th class="text-left py-3 px-2 rounded-l-lg">Name</th>
                <th class="text-left py-3 px-2">Email Address</th>
                <th class="text-left py-3 px-2">Group</th>
                <th class="text-left py-3 px-2">Member Since</th>
                <th class="text-left py-3 px-2 rounded-r-lg">Actions</th>
            </thead>
            @if($users && $users->count())
                @foreach($users as $user)
                    <tr class="border-b border-gray-700">
                        <td class="py-3 px-2 font-bold">
                            <div class="inline-flex space-x-3 items-center">
                                <span><img class="rounded-full w-8 h-8" src="{{ asset('assets/img/avatar.png') }}" alt=""></span>
                                <span>{{ $user->first_name }} {{ $user->last_name }}</span>
                            </div>
                        </td>
                        <td class="py-3 px-2">{{ $user->email }}</td>
                        <td class="py-3 px-2">{{ ucwords($user->getRoleNames()->first()) }}</td>
                        <td class="py-3 px-2">{{ \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $user->created_at)->format('d M Y') }}</td>
                        <td class="py-3 px-2">
                            <div class="inline-flex items-center space-x-3">
                                @can('administer users')
                                    <a href="{{ route('users.edit', ['id' => $user->id]) }}" title="Edit" class="hover:text-white">
                                        <i class="fa-regular fa-pen-to-square"></i>
                                    </a>
                                @else
                                    <a href="{{ route('users.edit', ['id' => $user->id]) }}" title="See Details" class="hover:text-white">
                                        <i class="fa-regular fa-eye"></i>
                                    </a>
                                @endcan
                                <a href="#" title="Delete User" class="hover:text-white" wire:click="deleteConfirm('{{ $user->id }}')">
                                  <i class="fa-regular fa-trash-can"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr class="border-b border-gray-700">
                    <td class="py-3 px-2 font-bold">
                        <div class="inline-flex space-x-3 items-center">
                            <span>No records found.</span>
                        </div>
                    </td>
                </tr>
            @endif
        </table>
    </div>
    @if($users && $users->count())
        <div class="px-2 py-8" id="pagination">
            {{ $users->links() }}
        </div>
    @endif
</div>
