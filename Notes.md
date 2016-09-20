# Notes

## Building an operator hierarchy

### First steps

Every query starts with a key:
```
{"foo":*}
```

There are three possible completions. The first one is a scalar value:
```
{"foo":13}
{"foo":"bar"}
```

The second one is an object:
```
{"foo":{"baz":*}}
```

The third one is an operator:
```
{"foo":{"$gt":*}}
```

### Things are getting more complex

Scalar values:
```
{"foo":13, "bar":"baz"}
```

Objects can contain operators:
```
{"foo":{"baz":{"$gt":13}}}
```

Operators can contain objects and/or operators:
```
{"foo":{"$ne":{"bar":12,"baz":14}}}
{"foo":{"$elementMatch":{"$gt":12}}}
```

```
{"foo":[12,23,34,45],"bar":"test"}
{"foo":{"$elementMatch":{"$gt":12}}}
{"bar":"test"}

{"subject":"Essen","text":"Was wollen wir essen? ILD, Sonja"}
{"subject":"Essen","text":"{"$enthält":"Sonja"}"}
```
Es gibt operatoren, die nur mit Zahlen oder strings arbeiten können 
und solche die auch auf operatoren arbeiten können.

#### Operatoren 1. Klasse
  * $gt
  * $lt
  * $eq
  * $ne
  
#### Operatoren 2. Klasse
  * $elementMatch
  
