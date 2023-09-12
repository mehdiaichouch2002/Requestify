<?php

namespace App\Http\Controllers;

use App\Http\Requests\DocumentRequest;
use App\Mail\DocumentStatusNotification;
use App\Models\Document;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    private const LIMIT = 10;
    private const PUBLIC_PATH = 'public/documents';
    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public  function index(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $documents = Document::paginate(self::LIMIT);
        return view('admin.document_management.index',compact('documents'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|Factory|View|Application
     */
    public function show($id): Application|View|Factory|\Illuminate\Contracts\Foundation\Application
    {
        $document = Document::findOrFail($id);
        return view('admin.document_management.show', compact('document'));
    }

    /**
     * @param DocumentRequest $request
     * @return RedirectResponse
     */
    public function store(DocumentRequest $request): RedirectResponse
    {
        $attachedFiles = null;

        if ($request->hasFile('attached_files')) {
            $files = $request->file('attached_files');
            $attachedFiles = [];

            foreach ($files as $file) {
                $timestamp = time();
                $extension = $file->getClientOriginalExtension();
                $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                // Limit the filename length to 30 characters
                $maxLength = 30;
                $filename = substr($originalName, 0, $maxLength - strlen($timestamp) - strlen($extension) - 1);
                $filename = $filename . '_' . $timestamp . '.' . $extension;
                $file->storeAs(self::PUBLIC_PATH, $filename);
                $attachedFiles[] = $filename;
            }
        }

        $document = Document::create([
            'title' => $request->title,
            'description' => $request->description,
            'type' => $request->type,
            'user_id' => auth()->id(),
            'attached_files' => $attachedFiles ? json_encode($attachedFiles) : null,
        ]);


        return redirect()->route('dashboard')->with('success', 'Document request created successfully.');
    }


    /**
     * @param $id
     * @return RedirectResponse
     */
    public function accept($id): RedirectResponse
    {
        $document = Document::findOrFail($id);
        $document->status = 1;
        $document->save();

        // Send notification email
        Mail::to($document->user->email)->send(new DocumentStatusNotification($document, 1));

        return redirect()->route('document-management.index')->with('success', 'Document ' . $document->title . ' ' . ($document->status === 1 ? 'accepted' : 'rejected') . ' successfully');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function reject($id): RedirectResponse
    {
        $document = Document::findOrFail($id);
        $document->status = 2;
        $document->save();

        // Send notification email
        Mail::to($document->user->email)->send(new DocumentStatusNotification($document, 2));

        return redirect()->route('document-management.index')->with('success', 'Document ' . $document->title . ' ' . ($document->status === 1 ? 'accepted' : 'rejected') . ' successfully');
    }

    /**
     * @return View|Application|Factory|\Illuminate\Contracts\Foundation\Application
     */
    public function create(): View|Application|Factory|\Illuminate\Contracts\Foundation\Application
    {
        return view('collaborator.document_request.create');
    }

    public function destroy($id): RedirectResponse
    {
        $document = Document::findOrFail($id);
        if (isset($document->attached_files)){
            foreach (json_decode($document->attached_files) as $file){
                Storage::delete(self::PUBLIC_PATH.'/'.$file);
            }
        }
        $document->delete();
        return redirect()->route('document-management.index')->with('success',  $document->title . ' deleted successfully.');
    }
}
