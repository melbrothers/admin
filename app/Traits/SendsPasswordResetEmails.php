<?php

namespace App\Traits;


use Illuminate\Http\Request;
use Illuminate\Mail\Message;
use Illuminate\Support\Facades\Password;

trait SendsPasswordResetEmails
{
    /**
     * Send a reset link to the given user.
     * @bodyParam email string required User'email
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function postEmail(Request $request)
    {
        return $this->sendResetLinkEmail($request);
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
        $broker = $this->getBroker();
        $response = Password::broker($broker)->sendResetLink($request->only('email'), function (Message $message) {
            $message->subject($this->getEmailSubject());
        });
        switch ($response) {
            case Password::RESET_LINK_SENT:
                return $this->sendResetLinkResponse($response);
            case Password::INVALID_USER:
            default:
                return $this->sendResetLinkFailedResponse($response);
        }
    }

    /**
     * Get the e-mail subject line to be used for the reset link email.
     *
     * @return string
     */
    protected function getEmailSubject()
    {
        return property_exists($this, 'subject') ? $this->subject : 'Your Password Reset Link';
    }

    /**
     * Get the response for after the reset link has been successfully sent.
     *
     * @param  string  $response
     * @return \Illuminate\Http\Response
     */
    protected function sendResetLinkResponse($response)
    {
        return response()->json(['success' => true]);
    }

    /**
     * Get the response for after the reset link could not be sent.
     *
     * @param  string  $response
     * @return \Illuminate\Http\Response
     */
    protected function sendResetLinkFailedResponse($response)
    {
        return response()->json(['success' => false]);
    }

    /**
     * Get the broker to be used during password reset.
     *
     * @return string|null
     */
    public function getBroker()
    {
        return property_exists($this, 'broker') ? $this->broker : null;
    }
}