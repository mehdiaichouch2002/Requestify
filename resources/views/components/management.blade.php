@props(['document_pendings'])
<div class="grid mt-10">
        <h1 class="text-md font-bold text-my-blue mb-2">{{__('Document Requests')}}</h1>
        <table class="text-my-blue">
            <tbody>
            @foreach($document_pendings as $doc)
                <tr class="border-t border-b border-my-light-blue">
                    <td class="py-1">{{__('Request By : ').$doc->user->firstname}} {{$doc->user->lastname}}</td>
                    <td class="py-1">{{__('Type : ').$doc->type}}</td>
                    <td class="flex justify-end py-1">
                        <x-secondary-link href="{{ route('document-management.show', $doc->id) }}" class="mx-2">{{__('View')}}</x-secondary-link>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
