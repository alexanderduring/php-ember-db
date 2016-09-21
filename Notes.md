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

### Theory
There are operators (1st class operators), that take only numbers or strings as first operand 
and there are those operators (2nd class operators) which can work on numbers or strings and on other operators.

#### 1st Class Operators
  * $gt
  * $lt
  * $eq
  * $ne
  
#### 2nd Class Operators
  * $elementMatch

1st class operators are simple, they always work have a scalar operand and compare it to a scalar value in the document. 2nd class operators are much more complex. Lets take the $elementMatch operator as an example. It can work with a scalar operand:
```
{"foo":[12,23,34,45]} is matched by
{"foo":{"$elementMatch":12}}
```

But it should also work with a sub-document:
```
{"foo":[{"bar":12},{"bar":23},{"bar":34},{"bar":45}]} is matched by
{"foo":{"$elementMatch":{"bar":12}}}
```

And it should work with an operator:
```
{"foo":[12,23,34,45]} is matched by
{"foo":{"$elementMatch":{"$gt":12}}}
```

How can we achieve a simple implementation for that kind of operator? Maybe we can transform every of these example cases to use an operator as the operand of $elementMatch. Then the $elementMatch implementation would be rather simple.

Lets see if this works. First the scalar value:
```
{"foo":[12,23,34,45]} is matched by
{"foo":{"$elementMatch":{"$eq":12}}}
```

Now the sub-document:
```
{"foo":[{"bar":12},{"bar":23},{"bar":34},{"bar":45}]} is matched by
{"foo":{"$elementMatch":{"bar":12}}}
```

