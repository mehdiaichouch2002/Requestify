<x-app-layout>
    <div class="flex flex-row h-screen">
        <x-side2/>
        <div class="flex min-w-0 flex-1 flex-col">
            <x-nav/>
            <div class="rq-panel">
                <div class="flex justify-between items-center">
                    <h1 class="text-3xl font-bold text-my-blue">{{__('Pending requests')}}</h1>
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
                        <h1 class="text-md font-bold text-my-blue mb-2">{{__('Document requests')}}</h1>
                        <table class="text-my-blue">
                            <tbody>
                            @foreach($documentPendings as $doc)
                                <tr class="border-t border-b border-my-light-blue">
                                    <td class="py-1">{{__('Title: ').$doc->title}}</td>
                                    <td class="py-1">{{__('Type: ').$doc->type}}</td>
                                    <td class="flex justify-end py-1">
                                        <x-status :value="$doc->status" />         </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if(count($materialPendings)>0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{__('Equipment requests')}}</h1>
                        <table class="text-my-blue">
                            <tbody>
                            @foreach($materialPendings as $mat)
                                <tr class="border-t border-b border-my-light-blue">
                                    <td class="py-1">{{__('Title: ').$mat->title}}</td>
                                    <td class="flex justify-end py-1">
                                        <x-status :value="$mat->status" />  </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif

                @if(count($vacationPendings)>0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{__('Leave requests')}}</h1>
                        <table class="text-my-blue">
                            <tbody>
                            @foreach($vacationPendings as $vacation)
                                <tr class="border-t border-b border-my-light-blue">
                                    <td class="py-1">{{__('Title: ').$vacation->title}}</td>
                                    <td class="flex justify-end py-1">
                                        <x-status :value="$vacation->status" />      </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if(count($homeworkPendings)>0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{__('Remote work requests')}}</h1>
                        <table class="text-my-blue">
                            <tbody>
                            @foreach($homeworkPendings as $homework)
                                <tr class="border-t border-b border-my-light-blue">
                                    <td class="py-1">{{__('').substr($homework->description,0,20)}}...</td>
                                    <td class="flex justify-end py-1">
                                        <x-status :value="$homework->status" />
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
                @if(count($evaluationPendings)>0)
                    <div class="grid mt-10">
                        <h1 class="text-md font-bold text-my-blue mb-2">{{__('Evaluation requests')}}</h1>
                        <table class="text-my-blue">
                            <tbody>
                            @foreach($evaluationPendings as $evaluation)
                                <tr class="border-t border-b border-my-light-blue">
                                    <td class="py-1">{{__('').substr($evaluation->description,0,20) }}...</td>
                                    <td class="flex justify-end py-1">
                                        <x-status :value="$evaluation->status" />
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
