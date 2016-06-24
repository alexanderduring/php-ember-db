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
  - Because of the unstructured nature of documents some of them could have an entry "foo" and some may not.
    In order to check this, you would need to do several calls to array_key_exists to walk to the structure
    of the document. Having an document object providing helper methods to easily achieve this task is an 
    advantage.

```php
class document
{
    private $data;



    public __construct($jsonData = null)
    {
        $this->data = is_null($jsonData) ? array() : json_decode($jsonData);
    }



    public function has($path)
    {
        // Check if array key decribed by $path exists.
    }



    public function get($path)
    {
        // Return array value indexed by array key decribed by $path.
    }



    public function toJson()
    {
	return json_encode($this->data);
    }
}
```

