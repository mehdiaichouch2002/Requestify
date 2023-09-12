 <form method="post" action="{{route('user-management.store')}}" enctype="multipart/form-data">

        @csrf
        <div class="flex justify-between items-center">
            <x-title>{{__('Add User')}}</x-title>
          <div class="mt-5">
              <x-secondary-link href="{{route('user-management.index')}}" class="mx-2">{{__('Back')}}</x-secondary-link>
              <x-secondary-button  type="submit">{{__(('SAVE'))}}</x-secondary-button>
                 </div>
          </div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="firstname"
                       class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                       placeholder=" " value="{{ old('firstname') }}" required/>
                <label for="firstname"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First
                    name</label>
                <x-input-error :messages="$errors->get('firstname')" class="mt-2"/>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="lastname"
                       class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                       placeholder=" " value="{{ old('lastname') }}" required/>
                <label for="lastname"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                    name</label>
                <x-input-error :messages="$errors->get('lastname')" class="mt-2"/>
            </div>
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <input type="email" name="email" id="email"
                       class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                       placeholder=" " value="{{ old('email') }}" required/>
                <label for="email"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email
                    address</label>
                <x-input-error :messages="$errors->get('email')" class="mt-2"/>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <label for="role" class="block  text-sm font-medium text-gray-700 dark:text-gray-400">Role</label>
                <select name="role"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                        required>
                    <option value="collaborator" {{ old('role') == 'collaborator' ? 'selected' : '' }}>Collaborator</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
            </div>
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <input type="password" name="password" id="password"
                       class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                       placeholder=" " required/>
                <label for="password"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Password</label>
                <div class="absolute inset-y-0 right-0 pr-3 ">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 cursor-pointer toggle-password"
                         viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 12a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd"
                              d="M10 3C5.03 3 1 7.03 1 12a9 9 0 0018 0c0-4.97-4.03-9-9-9zm0 16c4.97 0 9-4.03 9-9a9 9 0 00-18 0c0 4.97 4.03 9 9 9zm-1-7a1 1 0 112 0v1a1 1 0 11-2 0v-1z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
                <x-input-error :messages="$errors->get('password')" class="mt-2"/>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="password" name="password_confirmation" id="password_confirmation"
                       class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                       placeholder=" " required/>
                <label for="password_confirmation"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Confirm
                    password</label>
                <div class="absolute inset-y-0 right-0 pr-3 grid align-items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-gray-400 cursor-pointer toggle-password"
                         viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 12a2 2 0 100-4 2 2 0 000 4z" clip-rule="evenodd"/>
                        <path fill-rule="evenodd"
                              d="M10 3C5.03 3 1 7.03 1 12a9 9 0 0018 0c0-4.97-4.03-9-9-9zm0 16c4.97 0 9-4.03 9-9a9 9 0 00-18 0c0 4.97 4.03 9 9 9zm-1-7a1 1 0 112 0v1a1 1 0 11-2 0v-1z"
                              clip-rule="evenodd"/>
                    </svg>
                </div>
            </div>
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <input type="tel" name="phone" pattern="^\+212\s[67]\d{8}$"
                       class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                       value="{{ old('phone') }}" placeholder=" "/>
                <label for="phone"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Phone
                    number (+212 6XXXXXXXX)</label>
                <x-input-error :messages="$errors->get('phone')" class="mt-2"/>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <input type="text" name="job_title"
                       class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                       placeholder=" " value="{{ old('job_title') }}"/>
                <label for="job_title"
                       class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Job
                    title</label>
                <x-input-error :messages="$errors->get('job_title')" class="mt-2"/>
            </div>
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <label for="sexe" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Sexe</label>
                <select name="sexe"
                        class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer">
                    <option value="male" {{ old('sexe') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('sexe') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
            </div>
            <div class="relative z-0 w-full mb-6 group">
                <label for="dob" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Date of Birth</label>
                <input type="date" name="dob"
                       class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-black dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"
                       value="{{ old('dob') }}"/>
                <x-input-error :messages="$errors->get('dob')" class="mt-2"/>
            </div>
        </div>
        <div class="grid md:grid-cols-2 md:gap-6">
            <div class="relative z-0 w-full mb-6 group">
                <label for="avatar" class="block text-sm font-medium text-gray-700 dark:text-gray-400">Profile Image</label>
                <input type="file" accept="image/*" name="avatar"
                       class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-dark dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer"/>
                <x-input-error :messages="$errors->get('avatar')" class="mt-2"/>
            </div>
        </div>
        <script>
            // Get the password input fields
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');
            // Get the show password icons
            const showPasswordIcons = document.querySelectorAll('.toggle-password');
            // Add event listeners to the show password icons
            showPasswordIcons.forEach(icon => {
                icon.addEventListener('click', () => {
                    // Toggle the type attribute of the password input fields
                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        confirmPasswordInput.type = 'text';
                        icon.classList.add('text-my-light-blue');
                    } else {
                        passwordInput.type = 'password';
                        confirmPasswordInput.type = 'password';
                        icon.classList.remove('text-my-light-blue');
                    }
                });
            });
        </script>
    </form>
