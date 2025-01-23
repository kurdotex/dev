<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use App\Models\StripeEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * @group Stripe Webhook
 *
 * API to handle events sent by Stripe Webhooks.
 */
class StripeWebhookController extends Controller
{
    use ApiResponder;

    /**
     * Handle events sent by Stripe.
     *
     * This endpoint receives events from Stripe Webhooks and processes the following events:
     * - `invoice.payment_succeeded`: Registers the event in the database with details such as `event_id`, `amount_paid`, and `event_date`.
     *
     * @bodyParam payload string required The JSON content of the event sent by Stripe. Example: {"id":"evt_1Jd2e0E4K29VxRj","type":"invoice.payment_succeeded","data":{"object":{"amount_paid":5000}}}
     * @bodyParam Stripe-Signature string required The `Stripe-Signature` header sent by Stripe to verify the authenticity of the event. Example: t=1656033445,v1=...,v0=...
     *
     * @response 200 {
     *     "success": true,
     *     "message": "Event successfully registered!",
     *     "data": {
     *         "status": "success"
     *     }
     * }
     *
     * @response 400 {
     *     "success": false,
     *     "message": "Invalid payload",
     *     "data": {
     *         "status": "error"
     *     }
     * }
     *
     * @response 400 {
     *     "success": false,
     *     "message": "Invalid signature",
     *     "data": {
     *         "status": "error"
     *     }
     * }
     *
     * @response 200 {
     *     "success": false,
     *     "message": "Ignored",
     *     "data": {
     *         "status": "ignored"
     *     }
     * }
     */
    public function handle(Request $request): JsonResponse
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $endpointSecret = env('STRIPE_WEBHOOK_SECRET');

        try {
            $event = \Stripe\Webhook::constructEvent(
                $payload,
                $sigHeader,
                $endpointSecret
            );

            if ($event->type === 'invoice.payment_succeeded') {
                $invoice = $event->data->object;

                StripeEvent::create([
                    'event_id' => $event->id,
                    'amount_paid' => $invoice->amount_paid / 100,
                    'event_date' => date('Y-m-d H:i:s', $event->created),
                ]);

                return $this->success(
                    __('Event successfully registered!'),
                    [ 'status' => 'success' ]
                );

            }
        } catch (\UnexpectedValueException $e) {
            $this->logException('Exception: Invalid payload, handle - StripeWebhookController ' . $e->getMessage(), [], $e);
            return $this->error(
                __('Invalid payload'),
                ['status' => 'error']
            );
        } catch (\Stripe\Exception\SignatureVerificationException $e) {
            $this->logException('Exception: Invalid signature, handle - StripeWebhookController ' . $e->getMessage(), [], $e);
            return $this->error(
                __('Invalid signature'),
                ['status' => 'error']
            );
        }

        return $this->error(
            __('Ignored'),
            ['status' => 'ignored']
        );
    }

    /**
     * Log exceptions in the log file.
     *
     * @param string $message The exception message.
     * @param array $data Additional data related to the error.
     * @param \Exception $e The caught exception instance.
     * @return void
     */
    private function logException(string $message, array $data, \Exception $e): void
    {
        Log::warning($message, array_merge($data, ['exception' => $e->getMessage()]));
    }
}
