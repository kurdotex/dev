# Product Management


## List all products.


Retrieves a list of all available products.

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/list/products" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/list/products"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```


> Example response (200):

```json
{
    "status": "success",
    "message": "List All Products",
    "data": [
        {
            "id": 1,
            "name": "Sample Product",
            "description": "This is a sample product.",
            "price": 99.99,
            "stock": 100,
            "created_at": "2024-10-08T12:34:56.000000Z",
            "updated_at": "2024-10-08T12:34:56.000000Z"
        }
    ]
}
```
<div id="execution-results-GETapi-list-products" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-list-products"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-list-products"></code></pre>
</div>
<div id="execution-error-GETapi-list-products" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-list-products"></code></pre>
</div>
<form id="form-GETapi-list-products" data-method="GET" data-path="api/list/products" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-list-products', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-list-products" onclick="tryItOut('GETapi-list-products');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-list-products" onclick="cancelTryOut('GETapi-list-products');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-list-products" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/list/products</code></b>
</p>
</form>


## Store a new product.


Creates a new product with the provided data.

> Example request:

```bash
curl -X POST \
    "http://localhost/api/product/store" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"\"Sample Product\"","description":"\"This is a sample product.\"","price":99.99,"stock":100}'

```

```javascript
const url = new URL(
    "http://localhost/api/product/store"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "\"Sample Product\"",
    "description": "\"This is a sample product.\"",
    "price": 99.99,
    "stock": 100
}

fetch(url, {
    method: "POST",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


> Example response (201):

```json
{
    "status": "success",
    "message": "Product create successfully!",
    "data": {
        "id": 1,
        "name": "Sample Product",
        "description": "This is a sample product.",
        "price": 99.99,
        "stock": 100,
        "created_at": "2024-10-08T12:34:56.000000Z",
        "updated_at": "2024-10-08T12:34:56.000000Z"
    }
}
```
> Example response (422):

```json
{
    "status": "error",
    "message": "Validation error.",
    "errors": {
        "name": [
            "The name field is required."
        ]
    }
}
```
<div id="execution-results-POSTapi-product-store" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-product-store"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-product-store"></code></pre>
</div>
<div id="execution-error-POSTapi-product-store" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-product-store"></code></pre>
</div>
<form id="form-POSTapi-product-store" data-method="POST" data-path="api/product/store" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-product-store', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-product-store" onclick="tryItOut('POSTapi-product-store');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-product-store" onclick="cancelTryOut('POSTapi-product-store');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-product-store" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/product/store</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-product-store" data-component="body" required  hidden>
<br>
The name of the product.
</p>
<p>
<b><code>description</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="description" data-endpoint="POSTapi-product-store" data-component="body" required  hidden>
<br>
A brief description of the product.
</p>
<p>
<b><code>price</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<input type="number" name="price" data-endpoint="POSTapi-product-store" data-component="body" required  hidden>
<br>
The price of the product.
</p>
<p>
<b><code>stock</code></b>&nbsp;&nbsp;<small>number</small>  &nbsp;
<input type="number" name="stock" data-endpoint="POSTapi-product-store" data-component="body" required  hidden>
<br>
The stock of the product.
</p>

</form>


## Get product by ID.


Retrieve a specific product by its ID.

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/product/item/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/product/item/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};


fetch(url, {
    method: "GET",
    headers,
}).then(response => response.json());
```


> Example response (200):

```json
{
    "status": "success",
    "message": "Detail Product by Id",
    "data": {
        "id": 1,
        "name": "Sample Product",
        "description": "This is a sample product.",
        "price": 99.99,
        "stock": 100,
        "created_at": "2024-10-08T12:34:56.000000Z",
        "updated_at": "2024-10-08T12:34:56.000000Z"
    }
}
```
> Example response (404):

```json
{
    "status": "error",
    "message": "error.product_not_found",
    "data": null
}
```
<div id="execution-results-GETapi-product-item--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-product-item--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-product-item--id-"></code></pre>
</div>
<div id="execution-error-GETapi-product-item--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-product-item--id-"></code></pre>
</div>
<form id="form-GETapi-product-item--id-" data-method="GET" data-path="api/product/item/{id}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-product-item--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-product-item--id-" onclick="tryItOut('GETapi-product-item--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-product-item--id-" onclick="cancelTryOut('GETapi-product-item--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-product-item--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/product/item/{id}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="GETapi-product-item--id-" data-component="url" required  hidden>
<br>
The ID of the product.
</p>
</form>



