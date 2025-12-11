<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Traits\ApiResponder;
use App\Models\StripeEvent;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;


class StripeWebhookController extends Controller
{
    use ApiResponder;

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

    private function logException(string $message, array $data, \Exception $e): void
    {
        Log::warning($message, array_merge($data, ['exception' => $e->getMessage()]));
    }
}
