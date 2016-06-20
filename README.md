# PDO Thin Wrapper

A tiny PHP database wrapper using PDO.
Method calls can be chained together for quick and easy queries.

##Simple example

The following example demonstrates how to connect to a database called ```database``` and get the rows in a table named ```users```:

```php
require_once("Database.php");

$db = new Database("database");

$db->table("users")->get(
    function ($row) {
        echo $row['name'] . "<br>";
    }
);
```

##Chainable Table Methods
The following methods are chainable and will help you query tables.
> Keep in mind the ```get``` method will also reset all options by calling ```defaults```.

###List of chainable functions for tables:

| Method | Description |
| --- | --- |
| ```function defaults ()``` | Resets all the settings to default. |
| ```function select ($value)``` | Appends a value to the ```SELECT``` property of the query. |
| ```function where ($value)``` | Appends a value to the ```WHERE``` property of the query. |
| ```function group ($value)``` | Appends a value to the ```GROUP BY``` property of the query. |
| ```function get ($callback($row))``` | Calls the query and lets you specify a callback function to handle the returned row values. |