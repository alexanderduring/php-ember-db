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
```

## Theory
There are operators (1st class operators), that take only numbers or strings as first operand 
and there are those operators (2nd class operators) which can work on numbers or strings and on other operators.

### 1st Class Operators
  * $gt
  * $lt
  * $eq
  * $ne
  
### 2nd Class Operators
  * $elementMatch
  
