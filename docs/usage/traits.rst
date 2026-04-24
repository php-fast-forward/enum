Traits
======

The reusable traits are the heart of the package for user-defined enums. They
let you opt into behavior without forcing every enum to carry the same API.

Common combinations
-------------------

Backed enums often combine:

- ``HasValues``
- ``HasNames``
- ``HasOptions``
- ``HasNameLookup``
- ``HasValueMap``

Unit enums often combine:

- ``HasNames``
- ``HasNameLookup``
- ``HasNameMap``

Behavior-oriented traits:

- ``Comparable`` for explicit comparisons and membership checks
- ``HasDescription`` for readable strings derived from case names
- ``HasLabel`` when a default label implementation is acceptable

Example
-------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Trait\Comparable;
   use FastForward\Enum\Trait\HasDescription;
   use FastForward\Enum\Trait\HasNameLookup;
   use FastForward\Enum\Trait\HasNames;

   enum Direction
   {
       use Comparable;
       use HasDescription;
       use HasNameLookup;
       use HasNames;

       case North;
       case South;
   }

   Direction::names();              // ['North', 'South']
   Direction::North->is(Direction::South); // false

Why traits are useful here
--------------------------

Traits are the most natural fit when the enum itself should advertise the
behavior. For example, if other developers are expected to call
``Status::values()`` directly, adding ``HasValues`` to the enum keeps that API
discoverable.

Trait selection guidance
------------------------

Use only the traits that reflect real public behavior:

- choose ``HasValues`` only for backed enums
- choose ``HasNameLookup`` when name-based input is a real scenario
- choose ``HasOptions`` when the enum regularly feeds forms or prompts
- choose ``Comparable`` when explicit comparison helpers improve readability

If the trait API would be used in only one place, ``EnumHelper`` is often the
better fit.

Trait Reference
---------------

.. list-table::
   :header-rows: 1

   * - Trait
     - Works with
     - Adds
     - Typical return
   * - ``HasNames``
     - ``UnitEnum``
     - ``names()``
     - ``list<string>``
   * - ``HasValues``
     - ``BackedEnum``
     - ``values()``
     - ``list<int|string>``
   * - ``HasOptions``
     - ``BackedEnum``
     - ``options()``
     - ``array<string, int|string>``
   * - ``HasNameLookup``
     - ``UnitEnum``
     - ``tryFromName()``, ``fromName()``, ``hasName()``
     - enum case, ``null``, or ``bool``
   * - ``HasNameMap``
     - ``UnitEnum``
     - ``nameMap()``
     - ``array<string, self>``
   * - ``HasValueMap``
     - ``BackedEnum``
     - ``valueMap()``
     - ``array<int|string, self>``
   * - ``Comparable``
     - ``UnitEnum``
     - ``is()``, ``isNot()``, ``in()``, ``notIn()``
     - ``bool``
   * - ``HasDescription``
     - ``UnitEnum``
     - ``description()``
     - readable text derived from the case name
   * - ``HasLabel``
     - ``UnitEnum``
     - ``label()``
     - ``self::class`` followed by the case name

The backed-only traits rely on ``$case->value``. PHP exposes that property only
on backed enums, so unit enums should use name-based traits instead.

Labels and Descriptions
-----------------------

``HasDescription`` converts the case name into a readable phrase, which is
useful for internal explanations and generated documentation.

``HasLabel`` intentionally returns a technical fallback label containing the
enum class and case name. That makes it safe for diagnostics because labels from
different enums remain distinguishable.

.. code-block:: php

   Status::Draft->label(); // 'App\Domain\Status Draft'

For user-facing UI, implement ``LabeledEnumInterface`` manually so each label
uses product language instead of class names.
