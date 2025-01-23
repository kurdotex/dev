# User Management

APIs for managing users.

## List all users


Get a list of all users in the system.

> Example request:

```bash
curl -X GET \
    -G "http://localhost/api/list/users" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json"
```

```javascript
const url = new URL(
    "http://localhost/api/list/users"
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
    "status": true,
    "message": "List All Users",
    "data": [
        {
            "id": 1,
            "name": "John Doe",
            "email": "johndoe@example.com",
            "phone_number": "123456789"
        }
    ]
}
```
<div id="execution-results-GETapi-list-users" hidden>
    <blockquote>Received response<span id="execution-response-status-GETapi-list-users"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-GETapi-list-users"></code></pre>
</div>
<div id="execution-error-GETapi-list-users" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-GETapi-list-users"></code></pre>
</div>
<form id="form-GETapi-list-users" data-method="GET" data-path="api/list/users" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('GETapi-list-users', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-GETapi-list-users" onclick="tryItOut('GETapi-list-users');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-GETapi-list-users" onclick="cancelTryOut('GETapi-list-users');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-GETapi-list-users" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-green">GET</small>
 <b><code>api/list/users</code></b>
</p>
</form>


## Create a new user


Create a new user in the system.

> Example request:

```bash
curl -X POST \
    "http://localhost/api/user/store" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"John Smith","email":"johnsmith@example.com","password":"password123","phone_number":"123456789"}'

```

```javascript
const url = new URL(
    "http://localhost/api/user/store"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "John Smith",
    "email": "johnsmith@example.com",
    "password": "password123",
    "phone_number": "123456789"
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
    "status": true,
    "message": "User created successfully!",
    "data": {
        "id": 1,
        "name": "John Smith",
        "email": "johnsmith@example.com",
        "phone_number": "123456789"
    }
}
```
<div id="execution-results-POSTapi-user-store" hidden>
    <blockquote>Received response<span id="execution-response-status-POSTapi-user-store"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-POSTapi-user-store"></code></pre>
</div>
<div id="execution-error-POSTapi-user-store" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-POSTapi-user-store"></code></pre>
</div>
<form id="form-POSTapi-user-store" data-method="POST" data-path="api/user/store" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('POSTapi-user-store', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-POSTapi-user-store" onclick="tryItOut('POSTapi-user-store');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-POSTapi-user-store" onclick="cancelTryOut('POSTapi-user-store');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-POSTapi-user-store" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-black">POST</small>
 <b><code>api/user/store</code></b>
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="POSTapi-user-store" data-component="body" required  hidden>
<br>
The name of the user.
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="POSTapi-user-store" data-component="body" required  hidden>
<br>
The email of the user.
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="password" name="password" data-endpoint="POSTapi-user-store" data-component="body" required  hidden>
<br>
The password of the user.
</p>
<p>
<b><code>phone_number</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="phone_number" data-endpoint="POSTapi-user-store" data-component="body" required  hidden>
<br>
The phone number of the user.
</p>

</form>


## Update a user


Update the details of a user.

> Example request:

```bash
curl -X PUT \
    "http://localhost/api/user/update/1" \
    -H "Content-Type: application/json" \
    -H "Accept: application/json" \
    -d '{"name":"Jane Doe","email":"janedoe@example.com","password":"new_password123","phone_number":"987654321"}'

```

```javascript
const url = new URL(
    "http://localhost/api/user/update/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "Jane Doe",
    "email": "janedoe@example.com",
    "password": "new_password123",
    "phone_number": "987654321"
}

fetch(url, {
    method: "PUT",
    headers,
    body: JSON.stringify(body),
}).then(response => response.json());
```


> Example response (200):

```json
{
    "status": true,
    "message": "User updated successfully!",
    "data": {
        "id": 1,
        "name": "Jane Doe",
        "email": "janedoe@example.com"
    }
}
```
<div id="execution-results-PUTapi-user-update--id-" hidden>
    <blockquote>Received response<span id="execution-response-status-PUTapi-user-update--id-"></span>:</blockquote>
    <pre class="json"><code id="execution-response-content-PUTapi-user-update--id-"></code></pre>
</div>
<div id="execution-error-PUTapi-user-update--id-" hidden>
    <blockquote>Request failed with error:</blockquote>
    <pre><code id="execution-error-message-PUTapi-user-update--id-"></code></pre>
</div>
<form id="form-PUTapi-user-update--id-" data-method="PUT" data-path="api/user/update/{id}" data-authed="0" data-hasfiles="0" data-headers='{"Content-Type":"application\/json","Accept":"application\/json"}' onsubmit="event.preventDefault(); executeTryOut('PUTapi-user-update--id-', this);">
<h3>
    Request&nbsp;&nbsp;&nbsp;
        <button type="button" style="background-color: #8fbcd4; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-tryout-PUTapi-user-update--id-" onclick="tryItOut('PUTapi-user-update--id-');">Try it out ⚡</button>
    <button type="button" style="background-color: #c97a7e; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-canceltryout-PUTapi-user-update--id-" onclick="cancelTryOut('PUTapi-user-update--id-');" hidden>Cancel</button>&nbsp;&nbsp;
    <button type="submit" style="background-color: #6ac174; padding: 5px 10px; border-radius: 5px; border-width: thin;" id="btn-executetryout-PUTapi-user-update--id-" hidden>Send Request 💥</button>
    </h3>
<p>
<small class="badge badge-darkblue">PUT</small>
 <b><code>api/user/update/{id}</code></b>
</p>
<h4 class="fancy-heading-panel"><b>URL Parameters</b></h4>
<p>
<b><code>id</code></b>&nbsp;&nbsp;<small>integer</small>  &nbsp;
<input type="number" name="id" data-endpoint="PUTapi-user-update--id-" data-component="url" required  hidden>
<br>
The ID of the user.
</p>
<h4 class="fancy-heading-panel"><b>Body Parameters</b></h4>
<p>
<b><code>name</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="name" data-endpoint="PUTapi-user-update--id-" data-component="body" required  hidden>
<br>
The new name of the user.
</p>
<p>
<b><code>email</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="email" data-endpoint="PUTapi-user-update--id-" data-component="body" required  hidden>
<br>
The new email of the user.
</p>
<p>
<b><code>password</code></b>&nbsp;&nbsp;<small>string</small>     <i>optional</i> &nbsp;
<input type="password" name="password" data-endpoint="PUTapi-user-update--id-" data-component="body"  hidden>
<br>
The new password of the user (optional).
</p>
<p>
<b><code>phone_number</code></b>&nbsp;&nbsp;<small>string</small>  &nbsp;
<input type="text" name="phone_number" data-endpoint="PUTapi-user-update--id-" data-component="body" required  hidden>
<br>
The new phone number of the user.
</p>

</form>



