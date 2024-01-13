<div class="max-w-5xl mx-auto sm:px-6 lg:px-8 bg-gray-200 dark:bg-gray-700 rounded-lg">
    <div class="flex flex-col">
        <!-- Row Student Name & Father Name -->
        <div class="flex flex-row">
            <div class="flex flex-row flex-grow w-1/2 mb-2 mt-4 border-r items">
                <div class="w-2/5 text-center mt-2">
                    <label for="student_name" class="block dark:text-white text-lg font-bold">Student
                        Name</label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="text" name="student_name" id="student_name"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required
                        readonly value="{{ $pending[0]->name }}">
                </div>
            </div>
            <div class="flex flex-row flex-grow w-1/2 mb-2 mt-4">
                <div class="w-2/5 text-center mt-2">
                    <label for="father_name" class="block dark:text-white text-lg font-bold">Father Name</label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="text" name="father_name" id="father_name"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required
                        readonly value="{{ $pending[0]->father_name }}">
                        @error('father_name')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                </div>
            </div>
        </div>
        <!-- Row Student Name & Father Name Ends -->

        <!-- Row Student Email & Mother Name -->
        <div class="flex flex-row">
            <div class="flex flex-row flex-grow w-1/2 mb-2 mt-2 border-r items">
                <div class="w-2/5 text-center mt-2">
                    <label for="email" class="block dark:text-white text-lg font-bold">Student Email</label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="text" name="email" id="email"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required
                        readonly value="{{ $pending[0]->email }}">
                </div>
            </div>
            <div class="flex flex-row flex-grow w-1/2 mb-2 mt-2">
                <div class="w-2/5 text-center mt-2">
                    <label for="mother_name" class="block dark:text-white text-lg font-bold">Mother Name</label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="text" name="mother_name" id="mother_name"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required
                        readonly value="{{ $pending[0]->mother_name }}">
                        @error('mother_name')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                </div>
            </div>
        </div>
        <!-- Row Student Email & Mother Name Ends -->

        <!-- Row Student Phone & Parent Phone -->
        <div class="flex flex-row">
            <div class="flex flex-row flex-grow w-1/2 mb-2 mt-2 border-r items">
                <div class="w-2/5 text-center mt-2">
                    <label for="phone_number" class="block dark:text-white text-lg font-bold">Phone
                        Number</label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="text" name="phone_number" id="phone_number"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required
                        readonly value="{{ $pending[0]->phone_number }}">
                </div>
            </div>
            <div class="flex flex-row flex-grow w-1/2 mb-2 mt-2">
                <div class="w-2/5 text-center mt-2">
                    <label for="parent_phone" class="block dark:text-white text-lg font-bold">Parent
                        Phone</label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="text" name="parent_phone" id="parent_phone"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required
                        readonly value="{{ $pending[0]->parent_phone }}">
                        @error('parent_phone')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                </div>
            </div>
        </div>
        <!-- Row Student Phone & Parent Phone Ends-->


        <!-- Row Student Address & Parent Email -->
        <div class="flex flex-row">
            <div class="flex flex-row flex-grow w-1/2 mb-2 mt-2 border-r items">
                <div class="w-2/5 text-center mt-2">
                    <label for="address" class="block dark:text-white text-lg font-bold">Address</label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="text" name="address" id="address"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required
                        readonly value="{{ $pending[0]->address }}">
                </div>
            </div>
            <div class="flex flex-row flex-grow w-1/2 mb-2 mt-2">
                <div class="w-2/5 text-center mt-2">
                    <label for="parent_email" class="block dark:text-white text-lg font-bold">Parent
                        Email</label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="email" name="parent_email" id="parent_email"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required
                        readonly value="{{ $pending[0]->parent_email }}">
                        @error('parent_email')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                </div>
            </div>
        </div>
        <!-- Row Student Address & Parent Email Ends -->

        <!-- Row Student DoB & Parent Occupation -->
        <div class="flex flex-row">
            <div class="flex flex-row flex-grow w-1/2 mb-2 mt-2 border-r items">
                <div class="w-2/5 text-center mt-2">
                    <label for="date_of_birth" class="block dark:text-white text-lg font-bold">Date of
                        Birth 
                        <p class="text-gray-500 dark:text-gray-200 text-sm">MM/DD/YY</p>
                    </label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="date" name="date_of_birth" id="date_of_birth"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required readonly value="{{ $pending[0]->date_of_birth }}">
                        @error('date_of_birth')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                </div>
            </div>
            <div class="flex flex-row flex-grow w-1/2 mb-2 mt-2">
                <div class="w-2/5 text-center mt-2">
                    <label for="parent_occupation" class="block dark:text-white text-lg font-bold">Parent
                        Occupation</label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="text" name="parent_occupation" id="parent_occupation"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required
                        readonly value="{{ $pending[0]->parent_occupation }}">
                        @error('parent_occupation')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                </div>
            </div>
        </div>
        <!-- Row Student DoB & Parent Occupation Ends -->

        <!-- gender Only -->
        <div class="flex flex-row">
            <div class="flex flex-row w-1/2 mb-2 mt-2 border-r items">
                <div class="w-2/5 text-center mt-2">
                    <label for="gender" class="block dark:text-white text-lg font-bold">gender</label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="text" name="gender" id="gender"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required
                        readonly value="{{ $pending[0]->gender }}">
                    @error('gender')
                            <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
                <!--
                <div class="flex flex-row flex-grow 1/2 mb-2 mt-2">
                    add flex-grow in second div flex 'flex-row' flex-grow w-1/2 etc...
                </div>
                -->
            </div>
        </div>
        <!-- gender Ends -->

        <!-- Race -->
        <div class="flex flex-row">
            <div class="flex flex-row w-1/2 mb-2 mt-2 border-r items">
                <div class="w-2/5 text-center mt-2">
                    <label for="race" class="block dark:text-white text-lg font-bold">Race</label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="text" name="race" id="race"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required
                        readonly value="{{ $pending[0]->race }}">
                        @error('race')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                </div>
            </div>
        </div>
        <!-- Race Ends -->

        <!-- Nationality -->
        <div class="flex flex-row">
            <div class="flex flex-row w-1/2 mb-2 mt-2 border-r items">
                <div class="w-2/5 text-center mt-2">
                    <label for="nationality"
                        class="block dark:text-white text-lg font-bold">Nationality</label>
                </div>
                <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
                <div class="w-3/5 text-center">
                    <input type="text" name="nationality" id="nationality"
                        class="w-4/5 border rounded-sm focus:outline-none focus:border-blue-500" required
                        readonly value="{{ $pending[0]->nationality }}">
                        @error('nationality')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                </div>
            </div>
        </div>
        <!-- Nationality Ends -->
    
    </div>
</div>

<!-- Receipt -->
<div class="text-center">
    <h1 class="text-black dark:text-white mb-4 text-2xl">Receipt</h1>
</div>
<div class="max-w-5xl mx-auto sm:px-6 lg:px-8 bg-gray-200 dark:bg-gray-700 rounded-lg">
    <div class="flex flex-row flex-grow justify-center">
        <img src="{{ url('/storage/' . $pending[0]->receipt) }}" class="mt-4 mb-4 w-auto" alt="receipt vouncher">
        <!-- Since working with sail, needed to run sail artisan storage:link, then implement as above -->
    </div>
    <div class="flex flex-row">
        <div class="flex flex-row flex-grow mb-2 mt-2 items">
            <div class="w-1/2 text-center mt-2">
                <label for="submit_date"
                    class="block dark:text-white text-lg font-bold">Submitted At</label>
            </div>
            <span class="text-lg text-gray-700 dark:text-gray-300 mt-1">:</span>
            <div class="w-1/2 text-center">
                <input type="text" name="submit_date" id="submit_date"
                        class="w-1/2 border rounded-sm focus:outline-none focus:border-blue-500" required 
                        readonly value="{{ $pending[0]->submit_date }}">
            </div>
        </div>
    </div>
</div>
<!-- Receipt End -->