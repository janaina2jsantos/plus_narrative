<div class="bg-white/10 col-span-9 rounded-lg p-6">
    @can('administer users')
        <h1 class="font-bold py-4 uppercase">{{ $title }}</h1>
    @endcan
    <div class="mt-8 pl-2">
        @if (session()->has('success'))
            <x-alert size="2/3" color="green" textColor="green" bdColor="green" title="Success!" mgBottom="8" message="{{ session('success') }}" btn-title="Close" />
        @endif

        @if (session()->has('error'))
            <x-alert size="2/3" color="red" textColor="red" bdColor="red" title="Error!" mgBottom="8" message="{{ session('error') }}" btn-title="Close" />
        @endif

        @if($errors->any())
            <div class="bg-red-50  text-red-700 px-8 py-4 mb-10 rounded">
                <ul class="list-disc">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form wire:submit.prevent="submit" class="w-full max-w-lg"> 
            <div class="grid grid-cols-2 gap-4 mb-8">
                <div>
                    <label class="font-bold text-white mb-4">First Name</label>
                    <input type="text" wire:model="firstName" class="w-full flex-1 py-2 bg-transparent border-t-0 border-x-0 border-b-2 border-gray-400 focus:border-blue-900 text-gray-200 placeholder-gray-400 outline-none" placeholder="First Name" 
                    @cannot('administer users')
                        disabled
                    @endcan />
                </div>
                <div>
                    <label class="font-bold text-white mb-4">Last Name</label>
                    <input type="text" wire:model="lastName" class="w-full flex-1 py-2 bg-transparent border-t-0 border-x-0 border-b-2 border-gray-400 focus:border-blue-900 text-gray-200 placeholder-gray-400 outline-none" placeholder="Last Name" 
                    @cannot('administer users')
                        disabled
                    @endcan />
                </div>
            </div>

            <div class="grid grid-cols-1 gap-4 mb-8">
                <label class="font-bold text-white mb-[-15px]">Email Address</label>
                <input type="text" wire:model="email" class="flex-1 py-2 bg-transparent border-t-0 border-x-0 border-b-2 border-gray-400 focus:border-blue-900 text-gray-200 placeholder-gray-400 outline-none" placeholder="Email" 
                @cannot('administer users')
                    disabled
                @endcan />
            </div>
            
            <div class="grid grid-cols-1 gap-4 mb-8">
                <label class="font-bold text-white mb-[-20px]">Role</label>
                <select wire:model.lazy="roleId" class="flex-1 py-2 bg-transparent border-t-0 border-x-0 border-b-2 border-gray-400 focus:border-blue-900 text-gray-200 placeholder-gray-400 outline-none"
                @cannot('administer users')
                    disabled
                @endcan>
                    <option value="null" disabled="">Please select</option>
                    @isset($roles)
                        @if($roles->count() > 0)
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}" @if($roleId === $role->id)selected=""@endif>{{ ucwords($role->name) }}</option>
                            @endforeach
                        @else
                            <option value="" disabled>No roles found</option>
                        @endif
                    @endisset
                </select>
            </div>

            @can('administer users')
                <div class="grid grid-cols-2 gap-4 mb-8">
                    <div>
                        <label class="font-bold text-white mb-2">Password</label>
                        <input type="password" wire:model="password" class="w-full flex-1 py-2 bg-transparent border-t-0 border-x-0 border-b-2 border-gray-400 focus:border-blue-900 text-gray-200 placeholder-gray-400 outline-none" placeholder="Password" autocomplete="none"
                        @cannot('administer users')
                            disabled
                        @endcan />
                    </div>
                    <div>
                        <label class="font-bold text-white mb-2">Confirm Password</label>
                        <input type="password" wire:model="passwordConfirm" class="w-full flex-1 py-2 bg-transparent border-t-0 border-x-0 border-b-2 border-gray-400 focus:border-blue-900 text-gray-200 placeholder-gray-400 outline-none" placeholder="Confirm Password" autocomplete="none" 
                        @cannot('administer users')
                            disabled
                        @endcan />
                    </div>
                </div>
            @endcan

            <div class="text-right">
                <a href="{{ route('dashboard') }}" class="py-[14px] px-8 bg-gray-700 hover:bg-gray-800 text-white font-bold"><i class="fa-solid fa-arrow-left"></i>&nbsp;Back</a>
                @can('administer users')
                    @isset($userId)
                        <button type="submit" class="py-[12.5px] px-8 bg-blue-500 hover:bg-blue-900 text-white font-bold" wire:click.prevent="update"><span>Apply Changes</span></button>
                    @else
                        <button type="submit" class="py-[12.5px] px-8 bg-blue-500 hover:bg-blue-900 text-white font-bold" wire:click.prevent="store"><span>Save</span></button>
                    @endisset
                @endcan
            </div>
        </form>
    </div>
</div>

