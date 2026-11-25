
***

* Full name: `\FastForward\Enum\StateMachine\HasTransitions`

## Methods

### transitionMap

```php
protected static transitionMap(): array<string,list<self>>
```

* This method is **static**.* This method is **abstract**.
***
### initialStateCases

```php
protected static initialStateCases(): list<self>
```

* This method is **static**.
***
### allowedTransitions

```php
public allowedTransitions(): list<self>
```

***
### canTransitionTo

```php
public canTransitionTo(self $target): bool
```

**Parameters:**

| Parameter | Type     | Description |
|-----------|----------|-------------|
| `$target` | **self** |             |

***
### assertCanTransitionTo

```php
public assertCanTransitionTo(self $target): void
```

**Parameters:**

| Parameter | Type     | Description |
|-----------|----------|-------------|
| `$target` | **self** |             |

***
### isTerminal

```php
public isTerminal(): bool
```

***
### isInitial

```php
public isInitial(): bool
```

***
### initialStates

```php
public static initialStates(): list<self>
```

* This method is **static**.
***
### terminalStates

```php
public static terminalStates(): list<self>
```

* This method is **static**.
***
