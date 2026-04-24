Enum Catalogs
=============

The package ships with ready-to-use enums for recurring concerns. These are not
meant to replace every enum in an application. They exist for cases where the
semantics are already broad, stable, and reusable across projects.

Examples by namespace
---------------------

- ``Calendar``: ``Month``, ``Quarter``, ``Semester``, ``Weekday``
- ``Sort``: ``SortDirection``, ``NullsPosition``, ``CaseSensitivity``, ``ComparisonResult``
- ``Logger``: ``LogLevel``
- ``Runtime``: ``Environment``
- ``DateTime``: ``IntervalUnit``
- ``Comparison``: ``ComparisonOperator``
- ``Outcome``: ``Result``
- ``Http``: ``Scheme``
- ``Process``: ``SignalBehavior``

What users usually want to know first
-------------------------------------

Most first-time users ask two questions when they reach the packaged enums:

1. "When should I use one of these instead of defining my own enum?"
2. "What useful behavior do I get besides the cases themselves?"

The short answer is:

- use a packaged enum when the name and semantics already match your problem
- expect each packaged enum to expose a few focused methods, not just raw cases

Examples with practical behavior
--------------------------------

``Runtime\\Environment``
^^^^^^^^^^^^^^^^^^^^^^^^

Use this when your code needs to distinguish between development, testing,
staging, and production.

Useful methods:

- ``isProduction()``
- ``isPreProduction()``
- ``isDebugFriendly()``
- inherited helper-style behavior such as ``names()``, ``values()``, and ``fromName()``

``Calendar\\Month`` and ``Calendar\\Quarter``
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Use these when you want typed calendar logic instead of repeating integer math.

Useful methods:

- ``Month::quarter()``
- ``Month::isQuarterEnd()``
- ``Month::ordered()``
- ``Quarter::months()``
- ``Quarter::startMonth()``
- ``Quarter::endMonth()``
- ``Quarter::includes()``
- ``Quarter::fromMonth()``

``DateTime\\IntervalUnit``
^^^^^^^^^^^^^^^^^^^^^^^^^^

Use this when you need named interval units for cache policies, schedules,
retry logic, or reporting windows.

Useful methods:

- ``shortLabel()``
- ``seconds()``
- ``isCalendarAware()``

``Logger\\LogLevel`` and ``Common\\Severity``
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Use these when you need reusable severity ordering in logs, alerts, or
operational rules.

Useful methods:

- ``weight()``
- ``isAtLeast()``
- ``ordered()``

``Sort\\SortDirection`` and friends
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Use these when sorting behavior would otherwise rely on magic values or loose
booleans.

Useful methods:

- ``SortDirection::reverse()``
- ``SortDirection::applyToComparisonResult()``
- ``NullsPosition::compareNullability()``
- ``CaseSensitivity::normalize()``
- ``CaseSensitivity::equals()``
- ``ComparisonResult::fromComparisonResult()``
- ``ComparisonResult::toComparisonResult()``

``Comparison\\ComparisonOperator``
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Use this when building filters, query abstractions, or rule systems that need
typed operators.

Useful methods:

- ``symbol()``
- ``isSetOperator()``
- ``compare()``
- ``negate()``

``Outcome\\Result``
^^^^^^^^^^^^^^^^^^^

Use this when your code needs a compact success/partial/failure outcome type.

Useful methods:

- ``isSuccessful()``
- ``isCompleteSuccess()``
- ``isFailure()``

How to evaluate a packaged enum
-------------------------------

A packaged enum is usually a good fit when:

- the case names already match the language you would naturally use
- the behavior would look strange if you had to rename every case
- the enum would make sense in more than one package or application

A packaged enum is usually a poor fit when:

- your business vocabulary differs from the generic names
- labels need to be heavily customized
- the lifecycle or transitions are domain-specific

New-user guidance
-----------------

Use the packaged enums when the semantics are already general and stable.

Prefer defining your own enum when:

- the cases are domain-specific
- the labels are business-language driven
- the lifecycle or behavior only makes sense inside one package

Examples of strong fits
-----------------------

- ``Runtime\\Environment`` for deployment/runtime distinctions
- ``Calendar\\Month`` and ``Calendar\\Quarter`` for date-related calculations
- ``Sort\\SortDirection`` and ``Sort\\NullsPosition`` for ordering behavior
- ``Logger\\LogLevel`` for reusable severity-style decisions
