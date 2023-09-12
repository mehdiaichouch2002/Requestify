<x-app-layout>
    <div class="flex flex-row h-screen">
        <x-side />
        <div class="flex flex-col w-full relative">
            <x-nav />
            <div class="shadow-lg  flex-grow bg-white p-10 ml-[40px] mt-[50px] overflow-y-auto">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-my-blue">{{ __('PENDING REQUESTS') }}</h1>
                </div>
                @if (count($documentPendings) == 0 &&
                        count($evaluationPendings) == 0 &&
                        count($materialPendings) == 0 &&
                        count($vacationPendings) == 0 &&
                        count($homeworkPendings) == 0)
                    <div class="flex text-xl mt-[80px] justify-center">
                        <p class="text-my-blue">{{ __('No pending requests are available.') }}</p>
                    </div>
                @endif
                @if (count($documentPendings) > 0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{ __('Document Requests') }}</h1>
                        <table class="text-my-blue">
                            <tbody>
                                @foreach ($documentPendings as $doc)
                                    <tr class="border-t border-b border-my-light-blue">
                                        <td class="py-1">{{ __('Request By : ') . $doc->user->firstname }}
                                            {{ $doc->user->lastname }}</td>
                                        <td class="py-1">{{ __('Type : ') . $doc->type }}</td>
                                        <td class="flex justify-end py-1">
                                            <x-secondary-link href="{{ route('document-management.show', $doc->id) }}"
                                                class="mx-2">{{ __('View') }}</x-secondary-link>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if (count($materialPendings) > 0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{ __('Material Requests') }}</h1>
                        <table class="text-my-blue">
                            <tbody>
                                @foreach ($materialPendings as $mat)
                                    <tr class="border-t border-b border-my-light-blue">
                                        <td class="py-1">{{ __('Request By : ') . $mat->user->firstname }}
                                            {{ $mat->user->lastname }}</td>
                                        <td class="flex justify-end py-1">
                                            <x-secondary-link href="{{ route('material-management.show', $mat->id) }}"
                                                class="mx-2">{{ __('View') }}</x-secondary-link>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if (count($vacationPendings) > 0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{ __('Vacation Requests') }}</h1>
                        <table class="text-my-blue">
                            <tbody>
                                @foreach ($vacationPendings as $vacation)
                                    <tr class="border-t border-b border-my-light-blue">
                                        <td class="py-1">{{ __('Request By : ') . $vacation->user->firstname }}
                                            {{ $vacation->user->lastname }}</td>
                                        <td class="py-1">{{ __('Title : ') . $vacation->title }}</td>
                                        <td class="flex justify-end py-1">
                                            <x-secondary-link
                                                href="{{ route('vacation-management.show', $vacation->id) }}"
                                                class="mx-2">{{ __('View') }}</x-secondary-link>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if (count($homeworkPendings) > 0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{ __('Homework Requests') }}</h1>
                        <table class="text-my-blue">
                            <tbody>
                                @foreach ($homeworkPendings as $homework)
                                    <tr class="border-t border-b border-my-light-blue">
                                        <td class="py-1">{{ __('Request By : ') . $homework->user->firstname }}
                                            {{ $homework->user->lastname }}</td>
                                        <td class="py-1">
                                            {{ __('Description : ') . substr($homework->description, 0, 20) }}...</td>
                                        <td class="flex justify-end py-1">
                                            <x-secondary-link
                                                href="{{ route('homework-management.show', $homework->id) }}"
                                                class="mx-2">{{ __('View') }}</x-secondary-link>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if (count($evaluationPendings) > 0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{ __('Evaluation Requests') }}</h1>
                        <table class="text-my-blue">
                            <tbody>
                                @foreach ($evaluationPendings as $evaluation)
                                    <tr class="border-t border-b border-my-light-blue">
                                        <td class="py-1">{{ __('Request By : ') . $evaluation->user->firstname }}
                                            {{ $evaluation->user->lastname }}</td>
                                        <td class="py-1">
                                            {{ __('Description : ') . substr($evaluation->description, 0, 20) }}...</td>
                                        <td class="flex justify-end py-1">
                                            <x-secondary-link
                                                href="{{ route('evaluation-management.show', $evaluation->id) }}"
                                                class="mx-2">{{ __('View') }}</x-secondary-link>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
