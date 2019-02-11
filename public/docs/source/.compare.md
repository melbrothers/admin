---
title: API Reference

language_tabs:
- bash
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#Auth
<!-- START_669c21a0ec50102c5d7a38fdaec7d34e -->
## /register
> Example request:

```bash
curl -X POST "http://localhost/register"     -d "email"="1Q8y9uafIxn5ndni" \
    -d "password"="96ac6nnWzKOz3iyW" \
    -d "name"="uPzQoEFXr0nvg5pC" \
    -d "password_confirmation"="xcrlzrj0mvJ5DH7f" 
```

```javascript
const url = new URL("http://localhost/register");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

let body = JSON.stringify({
    "email": "1Q8y9uafIxn5ndni",
    "password": "96ac6nnWzKOz3iyW",
    "name": "uPzQoEFXr0nvg5pC",
    "password_confirmation": "xcrlzrj0mvJ5DH7f",
})

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /register`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | User'email
    password | string |  required  | User's password
    name | string |  required  | User's name
    password_confirmation | string |  required  | User's password confirmation

<!-- END_669c21a0ec50102c5d7a38fdaec7d34e -->

<!-- START_dd217657c6d30db33bd0158a8815a014 -->
## Handle an authentication attempt.

> Example request:

```bash
curl -X POST "http://localhost/login"     -d "email"="sfWjda4GXZdgrj5D" \
    -d "password"="Xiop1rQ6LmrMyyU6" 
```

```javascript
const url = new URL("http://localhost/login");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

let body = JSON.stringify({
    "email": "sfWjda4GXZdgrj5D",
    "password": "Xiop1rQ6LmrMyyU6",
})

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /login`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | User'email
    password | string |  required  | User's password

<!-- END_dd217657c6d30db33bd0158a8815a014 -->

<!-- START_7583c69bbb12e80377706f0a40ae5225 -->
## /logout
> Example request:

```bash
curl -X POST "http://localhost/logout" 
```

```javascript
const url = new URL("http://localhost/logout");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /logout`


<!-- END_7583c69bbb12e80377706f0a40ae5225 -->

#Bid Management
<!-- START_c9debc988dd31b3905843600563c16c2 -->
## /v1/tasks/{task}/bids
> Example request:

```bash
curl -X GET -G "http://localhost/v1/tasks/{task}/bids" 
```

```javascript
const url = new URL("http://localhost/v1/tasks/{task}/bids");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /v1/tasks/{task}/bids`


<!-- END_c9debc988dd31b3905843600563c16c2 -->

<!-- START_5f07a26305c756c5b14db1a8e07f09af -->
## Create a bid

> Example request:

```bash
curl -X POST "http://localhost/v1/tasks/{task}/bids"     -d "price"="l2Gvcc8Op4ivSXzs" \
    -d "comment"="dtIPACfs9YJ7NtNn" 
```

```javascript
const url = new URL("http://localhost/v1/tasks/{task}/bids");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

let body = JSON.stringify({
    "price": "l2Gvcc8Op4ivSXzs",
    "comment": "dtIPACfs9YJ7NtNn",
})

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /v1/tasks/{task}/bids`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    price | string |  required  | 
    comment | string |  required  | 

<!-- END_5f07a26305c756c5b14db1a8e07f09af -->

#Comment Management
<!-- START_169d1d7d6d10383ca4ce741697de40df -->
## /v1/tasks/{task}/comments
> Example request:

```bash
curl -X POST "http://localhost/v1/tasks/{task}/comments" 
```

```javascript
const url = new URL("http://localhost/v1/tasks/{task}/comments");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /v1/tasks/{task}/comments`


<!-- END_169d1d7d6d10383ca4ce741697de40df -->

<!-- START_f5bb93fdf183dcc81746313807d4ad6c -->
## /v1/tasks/{task}/comments
> Example request:

```bash
curl -X GET -G "http://localhost/v1/tasks/{task}/comments" 
```

```javascript
const url = new URL("http://localhost/v1/tasks/{task}/comments");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /v1/tasks/{task}/comments`


<!-- END_f5bb93fdf183dcc81746313807d4ad6c -->

#Forgot Password

Send password reset email
<!-- START_59d65f2e6393ef7326e8a5e6ef4b53a0 -->
## Send a reset link to the given user.

> Example request:

```bash
curl -X POST "http://localhost/password/email"     -d "email"="PLgC3iT47ajQJNMX" 
```

```javascript
const url = new URL("http://localhost/password/email");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

let body = JSON.stringify({
    "email": "PLgC3iT47ajQJNMX",
})

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /password/email`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    email | string |  required  | User'email

<!-- END_59d65f2e6393ef7326e8a5e6ef4b53a0 -->

#Reset Password

Rest user password
<!-- START_369c8bbb0872d3af653c4bce0f8bbec1 -->
## Reset the given user&#039;s password.

> Example request:

```bash
curl -X POST "http://localhost/password/reset"     -d "token"="SboCyBpzcUMhYHzu" \
    -d "email"="HwCzgtU49YkKHgp9" \
    -d "password"="gy6ikvj5YcDWtDW9" \
    -d "confirm_password"="u1ROvlsuvpszQVm0" 
```

```javascript
const url = new URL("http://localhost/password/reset");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

let body = JSON.stringify({
    "token": "SboCyBpzcUMhYHzu",
    "email": "HwCzgtU49YkKHgp9",
    "password": "gy6ikvj5YcDWtDW9",
    "confirm_password": "u1ROvlsuvpszQVm0",
})

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /password/reset`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    token | string |  required  | Token for resetting email
    email | string |  required  | User's email
    password | string |  required  | User's password
    confirm_password | string |  required  | User's confirm password

<!-- END_369c8bbb0872d3af653c4bce0f8bbec1 -->

#Socaial Login

Social login
<!-- START_578e010f0a2b2221c9ba8c7ff1afa913 -->
## Redirect the user to the Facebook authentication page.

> Example request:

```bash
curl -X GET -G "http://localhost/social/{provider}/login" 
```

```javascript
const url = new URL("http://localhost/social/{provider}/login");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /social/{provider}/login`


<!-- END_578e010f0a2b2221c9ba8c7ff1afa913 -->

<!-- START_0df1bb36d3530214cf60963771e59578 -->
## Obtain the user information from Facebook.

> Example request:

```bash
curl -X POST "http://localhost/social/{provider}/login" 
```

```javascript
const url = new URL("http://localhost/social/{provider}/login");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /social/{provider}/login`


<!-- END_0df1bb36d3530214cf60963771e59578 -->

#Task Management
<!-- START_3ab6942cc3a9b8dce5c23c39fc2a992d -->
## /v1/tasks
> Example request:

```bash
curl -X GET -G "http://localhost/v1/tasks" 
```

```javascript
const url = new URL("http://localhost/v1/tasks");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /v1/tasks`


<!-- END_3ab6942cc3a9b8dce5c23c39fc2a992d -->

<!-- START_fe4222cd28667f88c5922c4c96f04d1e -->
## /v1/tasks
> Example request:

```bash
curl -X POST "http://localhost/v1/tasks"     -d "title"="wUlHAFEy4cngr0Dz" \
    -d "description"="H91gVExogBF7gfkq" \
    -d "budget"="31660953.12" \
    -d "location"="IOhr31GEjqZ5Eck8" 
```

```javascript
const url = new URL("http://localhost/v1/tasks");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

let body = JSON.stringify({
    "title": "wUlHAFEy4cngr0Dz",
    "description": "H91gVExogBF7gfkq",
    "budget": "31660953.12",
    "location": "IOhr31GEjqZ5Eck8",
})

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /v1/tasks`

#### Body Parameters

Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    title | string |  required  | 
    description | string |  required  | 
    budget | float |  required  | 
    location | string |  required  | 

<!-- END_fe4222cd28667f88c5922c4c96f04d1e -->

<!-- START_2859ae0ca1bf87df5a630f0061e31757 -->
## /v1/tasks/{task}
> Example request:

```bash
curl -X GET -G "http://localhost/v1/tasks/{task}" 
```

```javascript
const url = new URL("http://localhost/v1/tasks/{task}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /v1/tasks/{task}`


<!-- END_2859ae0ca1bf87df5a630f0061e31757 -->

<!-- START_c0a9c49978d56da68d032d9597a16ed5 -->
## /v1/tasks/{task}
> Example request:

```bash
curl -X PUT "http://localhost/v1/tasks/{task}" 
```

```javascript
const url = new URL("http://localhost/v1/tasks/{task}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT /v1/tasks/{task}`


<!-- END_c0a9c49978d56da68d032d9597a16ed5 -->

<!-- START_2b0664a651e6897e0f5cafa385f650ad -->
## /v1/tasks/{task}
> Example request:

```bash
curl -X DELETE "http://localhost/v1/tasks/{task}" 
```

```javascript
const url = new URL("http://localhost/v1/tasks/{task}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE /v1/tasks/{task}`


<!-- END_2b0664a651e6897e0f5cafa385f650ad -->

#User Management

APIs for managing users
<!-- START_775284d24b66d62a651ff1f3c306a6fb -->
## /v1/users/me
> Example request:

```bash
curl -X GET -G "http://localhost/v1/users/me" 
```

```javascript
const url = new URL("http://localhost/v1/users/me");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /v1/users/me`


<!-- END_775284d24b66d62a651ff1f3c306a6fb -->

<!-- START_dc9b2f9df65fe283fbe195454ac54f52 -->
## /v1/users/{user}
> Example request:

```bash
curl -X GET -G "http://localhost/v1/users/{user}" 
```

```javascript
const url = new URL("http://localhost/v1/users/{user}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response (200):

```json
{
    "id": 4,
    "name": "Jessica Jones",
    "roles": [
        "admin"
    ]
}
```
> Example response (404):

```json
{}
```

### HTTP Request
`GET /v1/users/{user}`


<!-- END_dc9b2f9df65fe283fbe195454ac54f52 -->

<!-- START_c28be97b2a917a3a31a014e5a6988d25 -->
## /v1/users/{user}
> Example request:

```bash
curl -X PUT "http://localhost/v1/users/{user}" 
```

```javascript
const url = new URL("http://localhost/v1/users/{user}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT /v1/users/{user}`


<!-- END_c28be97b2a917a3a31a014e5a6988d25 -->

#Verify Email

Verify user's email
<!-- START_a7c5f10924c9b7d0b4f6e555b2a2e7ea -->
## Mark the authenticated user&#039;s email address as verified.

> Example request:

```bash
curl -X GET -G "http://localhost/email/verify/{id}" 
```

```javascript
const url = new URL("http://localhost/email/verify/{id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /email/verify/{id}`


<!-- END_a7c5f10924c9b7d0b4f6e555b2a2e7ea -->

<!-- START_662360c4f014a2da93de7efc2d65e089 -->
## Resend the email verification notification.

> Example request:

```bash
curl -X GET -G "http://localhost/email/resend" 
```

```javascript
const url = new URL("http://localhost/email/resend");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /email/resend`


<!-- END_662360c4f014a2da93de7efc2d65e089 -->

#general
<!-- START_a5427c1fc7fc3a257d0407ed03efdfc1 -->
## Update the avatar for the user.

> Example request:

```bash
curl -X POST "http://localhost/v1/users/avatar" 
```

```javascript
const url = new URL("http://localhost/v1/users/avatar");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /v1/users/avatar`


<!-- END_a5427c1fc7fc3a257d0407ed03efdfc1 -->

<!-- START_51077a87603b4dfb287fbcd4c2f3062d -->
## /v1/tasks/{task}/attachments
> Example request:

```bash
curl -X POST "http://localhost/v1/tasks/{task}/attachments" 
```

```javascript
const url = new URL("http://localhost/v1/tasks/{task}/attachments");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /v1/tasks/{task}/attachments`


<!-- END_51077a87603b4dfb287fbcd4c2f3062d -->

<!-- START_4b59c60e61306494cbecc7dfa1dfe197 -->
## /v1/comments/{comment}/replies
> Example request:

```bash
curl -X POST "http://localhost/v1/comments/{comment}/replies" 
```

```javascript
const url = new URL("http://localhost/v1/comments/{comment}/replies");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /v1/comments/{comment}/replies`


<!-- END_4b59c60e61306494cbecc7dfa1dfe197 -->

<!-- START_f3433bd8e370e16831f3b1c66408b957 -->
## /v1/comments/{comment}/attachments
> Example request:

```bash
curl -X POST "http://localhost/v1/comments/{comment}/attachments" 
```

```javascript
const url = new URL("http://localhost/v1/comments/{comment}/attachments");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /v1/comments/{comment}/attachments`


<!-- END_f3433bd8e370e16831f3b1c66408b957 -->

<!-- START_d5fdeb43392b7e30b2c6e8008a74c970 -->
## /v1/translation/{locale}
> Example request:

```bash
curl -X GET -G "http://localhost/v1/translation/{locale}" 
```

```javascript
const url = new URL("http://localhost/v1/translation/{locale}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /v1/translation/{locale}`


<!-- END_d5fdeb43392b7e30b2c6e8008a74c970 -->

<!-- START_9a4925a3d6314fb381b0093b9d14a6ef -->
## Authorize a client to access the user&#039;s account.

> Example request:

```bash
curl -X POST "http://localhost/oauth/token" 
```

```javascript
const url = new URL("http://localhost/oauth/token");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /oauth/token`


<!-- END_9a4925a3d6314fb381b0093b9d14a6ef -->

<!-- START_d54562e90bf04151dc7d95837e558b77 -->
## Get all of the authorized tokens for the authenticated user.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/tokens" 
```

```javascript
const url = new URL("http://localhost/oauth/tokens");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /oauth/tokens`


<!-- END_d54562e90bf04151dc7d95837e558b77 -->

<!-- START_abfd09e36c4951d11ca1c7d8d30d5c4d -->
## Delete the given token.

> Example request:

```bash
curl -X DELETE "http://localhost/oauth/tokens/{token_id}" 
```

```javascript
const url = new URL("http://localhost/oauth/tokens/{token_id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE /oauth/tokens/{token_id}`


<!-- END_abfd09e36c4951d11ca1c7d8d30d5c4d -->

<!-- START_22ac64c785e062e9fb762f3d39a3618a -->
## Get a fresh transient token cookie for the authenticated user.

> Example request:

```bash
curl -X POST "http://localhost/oauth/token/refresh" 
```

```javascript
const url = new URL("http://localhost/oauth/token/refresh");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /oauth/token/refresh`


<!-- END_22ac64c785e062e9fb762f3d39a3618a -->

<!-- START_e68f5945e5b3115f409c97d70ce109c1 -->
## Get all of the clients for the authenticated user.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/clients" 
```

```javascript
const url = new URL("http://localhost/oauth/clients");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /oauth/clients`


<!-- END_e68f5945e5b3115f409c97d70ce109c1 -->

<!-- START_cc62a849d5b8a0f6c7fe5bf8f37dca37 -->
## Store a new client.

> Example request:

```bash
curl -X POST "http://localhost/oauth/clients" 
```

```javascript
const url = new URL("http://localhost/oauth/clients");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /oauth/clients`


<!-- END_cc62a849d5b8a0f6c7fe5bf8f37dca37 -->

<!-- START_68765e4a9497ffd5ca366e85432e1b8d -->
## Update the given client.

> Example request:

```bash
curl -X PUT "http://localhost/oauth/clients/{client_id}" 
```

```javascript
const url = new URL("http://localhost/oauth/clients/{client_id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "PUT",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`PUT /oauth/clients/{client_id}`


<!-- END_68765e4a9497ffd5ca366e85432e1b8d -->

<!-- START_d37a14b237044eea20249e407316f2b5 -->
## Delete the given client.

> Example request:

```bash
curl -X DELETE "http://localhost/oauth/clients/{client_id}" 
```

```javascript
const url = new URL("http://localhost/oauth/clients/{client_id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE /oauth/clients/{client_id}`


<!-- END_d37a14b237044eea20249e407316f2b5 -->

<!-- START_3999012556e9b9cfd7380bbd3e5f4b3f -->
## Get all of the available scopes for the application.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/scopes" 
```

```javascript
const url = new URL("http://localhost/oauth/scopes");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /oauth/scopes`


<!-- END_3999012556e9b9cfd7380bbd3e5f4b3f -->

<!-- START_f424300762915d20d5a642e271ac4364 -->
## Get all of the personal access tokens for the authenticated user.

> Example request:

```bash
curl -X GET -G "http://localhost/oauth/personal-access-tokens" 
```

```javascript
const url = new URL("http://localhost/oauth/personal-access-tokens");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /oauth/personal-access-tokens`


<!-- END_f424300762915d20d5a642e271ac4364 -->

<!-- START_fd958d9a4d7d5e2efa1a8de529cdccf4 -->
## Create a new personal access token for the user.

> Example request:

```bash
curl -X POST "http://localhost/oauth/personal-access-tokens" 
```

```javascript
const url = new URL("http://localhost/oauth/personal-access-tokens");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "POST",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`POST /oauth/personal-access-tokens`


<!-- END_fd958d9a4d7d5e2efa1a8de529cdccf4 -->

<!-- START_5df9f91254ca5b0217f0cd72e341e39b -->
## Delete the given token.

> Example request:

```bash
curl -X DELETE "http://localhost/oauth/personal-access-tokens/{token_id}" 
```

```javascript
const url = new URL("http://localhost/oauth/personal-access-tokens/{token_id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE /oauth/personal-access-tokens/{token_id}`


<!-- END_5df9f91254ca5b0217f0cd72e341e39b -->

<!-- START_83b0086b0f9f44b38479df3a923e8b05 -->
## /_debugbar/open
> Example request:

```bash
curl -X GET -G "http://localhost/_debugbar/open" 
```

```javascript
const url = new URL("http://localhost/_debugbar/open");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /_debugbar/open`


<!-- END_83b0086b0f9f44b38479df3a923e8b05 -->

<!-- START_a1e39cbcf92a6735e597cf9339c27541 -->
## Return Clockwork output

> Example request:

```bash
curl -X GET -G "http://localhost/_debugbar/clockwork/{id}" 
```

```javascript
const url = new URL("http://localhost/_debugbar/clockwork/{id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /_debugbar/clockwork/{id}`


<!-- END_a1e39cbcf92a6735e597cf9339c27541 -->

<!-- START_a215b77c8a2a5189d0055ecf253f309c -->
## /_debugbar/telescope/{id}
> Example request:

```bash
curl -X GET -G "http://localhost/_debugbar/telescope/{id}" 
```

```javascript
const url = new URL("http://localhost/_debugbar/telescope/{id}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /_debugbar/telescope/{id}`


<!-- END_a215b77c8a2a5189d0055ecf253f309c -->

<!-- START_5692a47cf2d54a1a555b3fcd4a742493 -->
## Return the stylesheets for the Debugbar

> Example request:

```bash
curl -X GET -G "http://localhost/_debugbar/assets/stylesheets" 
```

```javascript
const url = new URL("http://localhost/_debugbar/assets/stylesheets");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /_debugbar/assets/stylesheets`


<!-- END_5692a47cf2d54a1a555b3fcd4a742493 -->

<!-- START_d76be3d8ca981e9b3e88f3d2cbf56af6 -->
## Return the javascript for the Debugbar

> Example request:

```bash
curl -X GET -G "http://localhost/_debugbar/assets/javascript" 
```

```javascript
const url = new URL("http://localhost/_debugbar/assets/javascript");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "GET",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```

> Example response:

```json
null
```

### HTTP Request
`GET /_debugbar/assets/javascript`


<!-- END_d76be3d8ca981e9b3e88f3d2cbf56af6 -->

<!-- START_ccd37d61c97ab0cebe8e2cdb7600a014 -->
## Forget a cache key

> Example request:

```bash
curl -X DELETE "http://localhost/_debugbar/cache/{key}/{tags?}" 
```

```javascript
const url = new URL("http://localhost/_debugbar/cache/{key}/{tags?}");

let headers = {
    "Accept": "application/json",
    "Content-Type": "application/json",
}

fetch(url, {
    method: "DELETE",
    headers: headers,
})
    .then(response => response.json())
    .then(json => console.log(json));
```


### HTTP Request
`DELETE /_debugbar/cache/{key}/{tags?}`


<!-- END_ccd37d61c97ab0cebe8e2cdb7600a014 -->


