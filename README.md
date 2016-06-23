# php-ember-db

This should be a light, embeddable implementation of a document based database 
for php projects. It should support the basic CRUD operation like

  - Create
  - Read
  - Update
  - Delete

and work on documents and collections.

## Implemetation Brainstorming

There will probably be a "Manager" class as the unique access point to the database.
A decision has to be made, if this class should return a document as an array or 
as an object.

### Arrays

#### Advantages

  - An array has no methods, so there is no possibility to add business logic into the row object.
    There is a stronger need to implement such classes in the domain model layer.

### Objects

#### Advantages

  - The implementation of accessor methods provides hooks that could execute things on every set/get event.

