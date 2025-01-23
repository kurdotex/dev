# Stripe Webhook

API to handle events sent by Stripe Webhooks.

## Handle events sent by Stripe.


This endpoint receives events from Stripe Webhooks and processes the following events:
- `invoice.payment_succeeded`: Registers the event in the database with details such as `event_id`, `amount_paid`, and `event_date`.

> Example request:

```bash
curl -X POST \
    "http://localhost/api/webhook/stripe" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"payload":"{\"id\":\"evt_1Jd2e0E4K29VxRj\",\"type\":\"invoice.payment_succeeded\",\"data\":{\"object\":{\"amount_paid\":5000}}}","Stripe-Signature":"t=1656033445,v1=...,v0=..."}'

```

```javascript
const url = new URL(
    "http://localhost/api/webhook/stripe"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "payload": "{\"id\":\"evt_1Jd2e0E4K29VxRj\",\"type\":\"invoice.payment_succeeded\",\"data\":{\"object\":{\"amount_paid\":5000}}}",
    "Stripe-Signature": "t=1656033445,v1=...,v0=..."
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


> Example response (200):

```json
{
    "success": true,
    "message": "Event successfully registered!",
    "data": {
        "status": "success"
    }
}
```
> Example response (400):

```json
{
    "success": false,
    "message": "Invalid payload",
    "data": {
        "status": "error"
    }
}
```
> Example response (400):

```json
{
    "success": false,
    "message": "Invalid signature",
    "data": {
        "status": "error"
    }
}
```
> Example response (200):

```json
{
    "success": false,
    "message": "Ignored",
    "data": {
        "status": "ignored"
    }
}
```
<div id="execution-results-POSTapi-webhook-stripe" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-webhook-stripe"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-webhook-stripe"></code></pre>
</div>
<div id="execution-error-POSTapi-webhook-stripe" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-webhook-stripe"></code></pre>
</div>
<form id="form-POSTapi-webhook-stripe" data-method="POST" data-path="api/webhook/stripe" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-webhook-stripe', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-webhook-stripe" onclick="tryItOut('POSTapi-webhook-stripe');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-webhook-stripe" onclick="cancelTryOut('POSTapi-webhook-stripe');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-webhook-stripe" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/webhook/stripe</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>payload</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="payload" data-endpoint="POSTapi-webhook-stripe" data-component="body" required  hidden>
<br>
The JSON content of the event sent by Stripe.
</p>
<p>
<b><code>Stripe-Signature</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="Stripe-Signature" data-endpoint="POSTapi-webhook-stripe" data-component="body" required  hidden>
<br>
The `Stripe-Signature` header sent by Stripe to verify the authenticity of the event.
</p>

</form>



