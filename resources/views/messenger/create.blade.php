@extends('layouts.app')

@section('header')
<h2 class="text-xl font-semibold leading-tight text-gray-800">
    {{ __('Create new message') }}
</h2>
@endsection

@section('content')
<div class="mx-auto max-w-7xl sm:px-6 lg:px-8">
    <div class="overflow-hidden bg-white shadow-sm sm:rounded-lg">
        <div class="p-6 bg-white border-b border-gray-200">

            <form action="{{ route('messages.store') }}" method="post">
                {{ csrf_field() }}
                <div class="col-md-6">
                    <!-- Subject Form Input -->
                    <div>
                        <x-label for="subject" :value="__('Subject')" />
                        <x-input id="subject" class="block w-full mt-1" type="text" name="subject" :value="old('subject')" />
                    </div>

                    <!-- Recipients list -->
                    <div class="mt-4">
                        <x-label for="recipient" :value="__('Recipient')" />
                        <option value="">
                            <specify the recipient></select>
                        </option>
                        <select name="recipient" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            @foreach (\App\Models\User::where('role', '<>', auth()->user()->role)->get();
                                as $user)
                                <option value="{{ $user->id }}">{{ $user->firstname . ' ' . $user->lastname }}</option>
                                @endforeach
                        </select>




                    </div>

                    <!-- Message Form Input -->
                    <div class="mt-4">
                        <x-label for="message" :value="__('Message')" />
                        <textarea name="message" rows="10" class="block w-full mt-1 border-gray-300 rounded-md shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">{{ old('message') }}</textarea>
                    </div>

                    <!-- Submit Form Input -->
                    <div class="mt-4">
                        <x-button>Submit</x-button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
</div>
@endsection