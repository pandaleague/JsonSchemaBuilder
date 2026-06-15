# JsonSchemaBuilder

A small, fluent PHP library for assembling [JSON Schema](https://json-schema.org/) documents as PHP arrays — ready to encode to JSON.

## Requirements

- PHP 8.3+
- `illuminate/contracts` ^11 || ^12

## Installation

```bash
composer require pandaleague/jsonschemabuilder
```

## Quick example

```php
use PandaLeague\JsonSchemaBuilder\Factory;

$schema = Factory::obj()
    ->title('User')
    ->description('A registered user')
    ->property('id', Factory::num()->minimum(1))
    ->property('email', Factory::str()->format('email'))
    ->property('roles', Factory::arr()
        ->items(Factory::str()->enum(['admin', 'user']))
        ->uniqueItems(true)
    )
    ->required(['id', 'email'])
    ->additionalProperties(false);

echo json_encode($schema->toArray(), JSON_PRETTY_PRINT);
```

```json
{
    "type": "object",
    "title": "User",
    "description": "A registered user",
    "properties": {
        "id":    { "type": "number", "minimum": 1 },
        "email": { "type": "string", "format": "email" },
        "roles": {
            "type": "array",
            "items": {
                "type": "string",
                "enum": ["admin", "user"]
            },
            "uniqueItems": true
        }
    },
    "additionalProperties": false,
    "required": ["id", "email"]
}
```

## Types

Every builder is created through `Factory` and returns a fluent instance. All builders implement `Illuminate\Contracts\Support\Arrayable`, so `toArray()` produces the final schema.

| Factory | Class  | JSON Schema type |
|---------|--------|------------------|
| `Factory::str()`  | `aStr`  | `string`  |
| `Factory::num()`  | `aNum`  | `number`  |
| `Factory::bool()` | `aBool` | `boolean` |
| `Factory::arr()`  | `aArr`  | `array`   |
| `Factory::obj()`  | `aObj`  | `object`  |
| `Factory::null()` | `aNull` | `null`    |

### Shared keywords

Available on every builder (via the `BaseType` trait):

- `id(string)`, `schema(string)`, `title(string)`, `description(string)`
- `enum(array)` — values must match the underlying type
- `anyOf(Type[])`, `allOf(Type[])`, `oneOf(Type[])`, `not(Type)`
- `ref(string)` — emitted as `$ref`
- `readOnly(bool)`, `writeOnly(bool)`, `nullable(bool)`
- `link(string $rel, string $href, string $title = '', string $method = 'GET')` — `$rel` is restricted to IANA-style relations (`self`, `create`, `edit`, `delete`, `replace`, `first`, `last`, `next`, `prev`, `collection`, `latest-version`, `search`, `up`)

### Strings — `aStr`

```php
Factory::str()
    ->size(3, 32)            // minLength / maxLength
    ->pattern('^[a-z]+$')
    ->format('email')
    ->default('admin');
```

### Numbers — `aNum`

```php
Factory::num()
    ->minimum(0.5, exclusive: true)
    ->maximum(10.0)
    ->multipleOf(0.5)
    ->default(1.0);
```

### Arrays — `aArr`

```php
Factory::arr()
    ->items(Factory::str())          // single schema, or
    ->items([Factory::str(), Factory::num()], additionalItems: false) // tuple
    ->size(1, 5)                     // minItems / maxItems
    ->uniqueItems(true);
```

### Objects — `aObj`

```php
Factory::obj()
    ->property('name', Factory::str())
    ->property('age',  Factory::num())
    ->required(['name'])
    ->additionalProperties(false)        // bool or Type
    ->size(1, 10)                        // minProperties / maxProperties
    ->propertyDependency('name', ['age'])
    ->patternProperty('^x-', Factory::str())
    ->propertyNames(Factory::str()->pattern('^[a-z]+$'));
```

### Booleans / null

```php
Factory::bool()->default(true);
Factory::null();
```

## Combining schemas

```php
Factory::str()->anyOf([
    Factory::str()->format('email'),
    Factory::str()->pattern('^\+?[0-9]+$'),
]);
```

## Development

Install dev dependencies and run the test suite:

```bash
composer install
composer test
```

## License

MIT
