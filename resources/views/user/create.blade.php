<x-app-layout>

    <section class="bg-white dark:bg-gray-900 rounded-lg">
        <div class="py-8 px-4 mx-auto max-w-2xl lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
                {{ isset($user) ? 'Update user' : 'Add user' }}
            </h2>
            <form action="{{ isset($user) ? route('user.update', $user) : route('user.store') }}" method="POST">
                @csrf
                @if(isset($user)) @method('PUT') @endif
                
                <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
                    <div class="w-full">
                        <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">User Name</label>
                        <input type="text" name="name" id="name" placeholder="Type user name" value="{{ old('name', $user->name ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                        @error('name') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="w-full">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                        <input type="email" name="email" id="email" placeholder="name@email.com" value="{{ old('email', $user->email ?? '') }}" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                        @error('email') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="w-full">
                        <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role</label>
                        <select name="role" id="role" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="" disabled selected>select a role</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role }}" {{ old('role', $user->role ?? '') == $role ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                        @error('role') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="w-full">
                        <label for="state" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">State</label>
                        <select name="state" id="state" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                            <option value="" disabled selected>select a state</option>
                            @foreach ($states as $state)
                                <option value="{{ $role }}" {{ old('state', $user->state ?? '') == $state ? 'selected' : '' }}>{{ ucfirst($state) }}</option>
                            @endforeach
                        </select>
                        @error('state') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="w-full">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Password</label>
                        <input type="text" name="password" id="password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                        @error('password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="w-full">
                        <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Confirm Password</label>
                        <input type="text" name="confirm_password" id="confirm_password" placeholder="••••••••" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-green-600 focus:border-green-600 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-green-500 dark:focus:border-green-500">
                        @error('confirm_password') <p class="text-red-500 text-sm">{{ $message }}</p> @enderror
                    </div>
                </div>
                <button type="submit" class="inline-flex items-center px-5 py-2.5 mt-4 sm:mt-6 text-sm font-medium text-center text-white bg-green-600 rounded-lg focus:ring-4 focus:ring-green-200 dark:focus:ring-green-900 hover:bg-green-800">
                    {{ isset($user) ? 'Update' : 'Add' }}
                </button>
            </form>
        </div>
    </section>

</x-app-layout>