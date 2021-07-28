# shoppinpal
Shoppipal interview test
 
[ ![Build Status](https://travis-ci.com/ivolator/shoppinpal.svg?branch=master) ]

1. Create a book :
URI /books
- Method:  POST
- Headers:  Content-Type: application/json
- Payload: {"title":"Book Title","author":"Author Name","isbn":"ISBN-123355","releaseDate":"2000-01-01"}
- Response: HTTP 201 and a resource with the ID, plus errors if any 
  -- ["httpStatus": 201, {"title":"Book Title","author":"Author Name","isbn":"ISBN-123355","releaseDate":"2000-01-01"},"errors": []]

2. Read a book :
- URI /books/{id}
- Method:  GET
- Headers:  Content-Type: application/json
- Response: HTTP 200 and a resource with the ID, plus errors if any 
- ["httpStatus": 200, {"title":"Book Title","author":"Author Name","isbn":"ISBN-123355","releaseDate":"2000-01-01"},"errors": []]

3. Delete a book :
- URI /books/{id}
- Method:  DELETE
- Headers:  Content-Type: application/json; HTTP-X-HTTP-METHOD-OVERRIDE: DELETE
- Response: HTTP 204  plus errors if any 
-  ["httpStatus": 200, data: true,"errors": []]
