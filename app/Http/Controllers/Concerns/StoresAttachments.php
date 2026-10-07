<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;

trait StoresAttachments
{
    /** Allowed attachment types, for the `mimes` validation rule. */
    protected const ATTACHMENT_MIMES = 'pdf,doc,docx,rtf,jpeg,png,jpg';

    /**
     * Store an upload under storage/app/public/documents and return its file name.
     * The name keeps the original (shortened) for readability, adds a random part so
     * two uploads in the same second never overwrite each other, and takes the
     * extension from the file's content rather than from the name the browser sent.
     */
    protected function storeAttachment(UploadedFile $file): string
    {
        $base = Str::limit(Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)), 20, '') ?: 'file';
        $filename = $base . '_' . time() . '_' . Str::lower(Str::random(6)) . '.' . ($file->extension() ?: 'bin');

        $file->storeAs('public/documents', $filename);

        return $filename;
    }
}
