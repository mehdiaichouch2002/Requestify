<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

/**
 * Accept / reject, shared by the five request types.
 */
trait DecidesRequests
{
    public const ACCEPTED = 1;
    public const REJECTED = 2;

    /**
     * @param  class-string<Mailable>  $mailable  constructed as new $mailable($request, $status)
     */
    protected function decide(Model $request, int $status, string $mailable, string $indexRoute, string $label): RedirectResponse
    {
        // A decision is final: the collaborator has already been emailed about it
        if ((int) $request->status !== 0) {
            return back()->withErrors(['status' => __('This request was already :decision.', [
                'decision' => (int) $request->status === self::ACCEPTED ? __('accepted') : __('rejected'),
            ])]);
        }

        $request->status = $status;
        $request->save();

        // The decision is saved even if the mail server is down; the failure is logged
        if ($request->user?->email) {
            rescue(fn () => Mail::to($request->user->email)->send(new $mailable($request, $status)));
        }

        $verb = $status === self::ACCEPTED ? __('accepted') : __('rejected');

        return redirect()->route($indexRoute)->with('success', trim("$label $verb."));
    }
}
