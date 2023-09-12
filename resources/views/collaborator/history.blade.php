<x-app-layout>
    <div class="flex flex-row h-screen">
        <x-side2/>
        <div class="flex flex-col w-full relative">
            <x-nav/>
            <div class="shadow-lg flex-grow bg-white p-10 ml-[40px] mt-[50px] overflow-y-auto">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-my-blue">{{__('PENDING REQUESTS')}}</h1>
                </div>
                @if(session()->has('success'))
                    <div>
                        <x-success-alert :value="session()->get('success')"/>
                    </div>
                @endif
                @if(count($documentPendings)==0 && count($materialPendings)==0 && count($vacationPendings)==0 &&
                            count($homeworkPendings)==0 && count($evaluationPendings)==0)
                    <div class="flex text-xl mt-[80px] justify-center">
                        <p class="text-my-blue">{{__('No pending requests are available.')}}</p>
                    </div>
                @endif
                @if(count($documentPendings)>0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{__('Document Requests')}}</h1>
                        <table class="text-my-blue">
                            <tbody>
                            @foreach($documentPendings as $doc)
                                <tr class="border-t border-b border-my-light-blue">
                                    <td class="py-1">{{__('Title : ').$doc->title}}</td>
                                    <td class="py-1">{{__('Type : ').$doc->type}}</td>
                                    <td class="flex justify-end py-1">
                                        @if ($doc->status == 0)
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-sm text-yellow-500 px-3.5 py-1.5 rounded-lg">   {{__('Pending')}}
                                </span>
                                        @elseif ($doc->status == 1)
                                            <span
                                                class="bg-my-light-green text-my-green text-sm text-my-green px-3.5 py-1.5 rounded-lg ">{{__('Accepted')}}
                                    </span>
                                        @elseif ($doc->status == 2)
                                            <span
                                                class="bg-my-light-red  text-my-red text-sm text-my-red px-3.5 py-1.5 rounded-lg">  {{__('Rejected')}}
                                </span>

                                        @endif         </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if(count($materialPendings)>0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{__('Material Requests')}}</h1>
                        <table class="text-my-blue">
                            <tbody>
                            @foreach($materialPendings as $mat)
                                <tr class="border-t border-b border-my-light-blue">
                                    <td class="py-1">{{__('Title : ').$mat->title}}</td>
                                    <td class="flex justify-end py-1">
                                        @if ($mat->status == 0)
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-sm text-yellow-500 px-3.5 py-1.5 rounded-lg">   {{__('Pending')}}
                                </span>
                                        @elseif ($mat->status == 1)
                                            <span
                                                class="bg-my-light-green text-my-green text-sm text-my-green px-3.5 py-1.5 rounded-lg ">{{__('Accepted')}}
                                    </span>
                                        @elseif ($mat->status == 2)
                                            <span
                                                class="bg-my-light-red  text-my-red text-sm text-my-red px-3.5 py-1.5 rounded-lg">  {{__('Rejected')}}
                                </span>

                                        @endif  </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if(count($vacationPendings)>0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{__('Vacation Requests')}}</h1>
                        <table class="text-my-blue">
                            <tbody>
                            @foreach($vacationPendings as $vacation)
                                <tr class="border-t border-b border-my-light-blue">
                                    <td class="py-1">{{__('Title : ').$vacation->title}}</td>
                                    <td class="flex justify-end py-1">
                                        @if ($vacation->status == 0)
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-sm text-yellow-500 px-3.5 py-1.5 rounded-lg">   {{__('Pending')}}
                                </span>
                                        @elseif ($vacation->status == 1)
                                            <span
                                                class="bg-my-light-green text-my-green text-sm text-my-green px-3.5 py-1.5 rounded-lg ">{{__('Accepted')}}
                                    </span>
                                        @elseif ($vacation->status == 2)
                                            <span
                                                class="bg-my-light-red  text-my-red text-sm text-my-red px-3.5 py-1.5 rounded-lg">  {{__('Rejected')}}
                                </span>

                                        @endif      </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if(count($homeworkPendings)>0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{__('Homework Requests')}}</h1>
                        <table class="text-my-blue">
                            <tbody>
                            @foreach($homeworkPendings as $homework)
                                <tr class="border-t border-b border-my-light-blue">
                                    <td class="py-1">{{__('Description : ').substr($homework->description,0,20)}}...</td>
                                    <td class="flex justify-end py-1">
                                        @if ($homework->status == 0)
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-sm text-yellow-500 px-3.5 py-1.5 rounded-lg">   {{__('Pending')}}
                                </span>
                                        @elseif ($homework->status == 1)
                                            <span
                                                class="bg-my-light-green text-my-green text-sm text-my-green px-3.5 py-1.5 rounded-lg ">{{__('Accepted')}}
                                    </span>
                                        @elseif ($homework->status == 2)
                                            <span
                                                class="bg-my-light-red  text-my-red text-sm text-my-red px-3.5 py-1.5 rounded-lg">  {{__('Rejected')}}
                                </span>

                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if(count($evaluationPendings)>0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{__('Evaluation Requests')}}</h1>
                        <table class="text-my-blue">
                            <tbody>
                            @foreach($evaluationPendings as $evaluation)
                                <tr class="border-t border-b border-my-light-blue">
                                    <td class="py-1">{{__('Description : ').substr($evaluation->description,0,20) }}...</td>
                                    <td class="flex justify-end py-1">
                                        @if ($evaluation->status == 0)
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-sm text-yellow-500 px-3.5 py-1.5 rounded-lg">   {{__('Pending')}}
                                </span>
                                        @elseif ($evaluation->status == 1)
                                            <span
                                                class="bg-my-light-green text-my-green text-sm text-my-green px-3.5 py-1.5 rounded-lg ">{{__('Accepted')}}
                                    </span>
                                        @elseif ($evaluation->status == 2)
                                            <span
                                                class="bg-my-light-red  text-my-red text-sm text-my-red px-3.5 py-1.5 rounded-lg">  {{__('Rejected')}}
                                </span>

                                        @endif
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
