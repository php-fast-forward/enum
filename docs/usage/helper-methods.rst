Helper Methods
==============

This page explains the helpers most new users look for first: what they return,
why they exist, and when to use the trait version instead of ``EnumHelper``.

Trait or ``EnumHelper``?
------------------------

The package intentionally exposes most collection-style helpers in two forms:

- as traits, for enums you own
- as ``EnumHelper`` methods, for external access

In other words, these pairs usually solve the same problem:

.. list-table::
   :header-rows: 1

   * - Problem
     - Trait form
     - Helper form
   * - Get case names
     - ``HasNames``
     - ``EnumHelper::names()``
   * - Get backed values
     - ``HasValues``
     - ``EnumHelper::values()``
   * - Lookup by case name
     - ``HasNameLookup``
     - ``EnumHelper::fromName()`` / ``EnumHelper::tryFromName()``
   * - Build maps
     - ``HasNameMap`` / ``HasValueMap``
     - ``EnumHelper::nameMap()`` / ``EnumHelper::valueMap()``
   * - Build option arrays
     - ``HasOptions``
     - ``EnumHelper::options()``

Collection helpers
------------------

``cases()``
^^^^^^^^^^^

Use ``EnumHelper::cases()`` when you want the native case list but prefer to
accept either ``Foo::class`` or a concrete case such as ``Foo::Bar``.

.. code-block:: php

   EnumHelper::cases(Status::class);
   EnumHelper::cases(Status::Draft);

``names()``
^^^^^^^^^^^

Use this when you need a simple list of case names without mapping over
``cases()`` manually.

.. code-block:: php

   Status::names();                 // ['Draft', 'Published']
   EnumHelper::names(Status::class);

``values()``
^^^^^^^^^^^^

Use this only with backed enums. It returns the scalar backing values in
declaration order.

.. code-block:: php

   Status::values();                // ['draft', 'published']
   EnumHelper::values(Status::class);

Maps and options
----------------

``nameMap()``
^^^^^^^^^^^^^

Returns ``case name => enum case``.

.. code-block:: php

   Status::nameMap()['Draft'];      // Status::Draft

This is useful for validation, routing user input by case name, and cheap
lookups without writing loops.

``valueMap()``
^^^^^^^^^^^^^^

Returns ``backed value => enum case``.

.. code-block:: php

   Status::valueMap()['draft'];     // Status::Draft

Use this when your system deals with external values such as API payloads,
database values, or configuration arrays.

``options()``
^^^^^^^^^^^^^

Returns ``case name => backed value``.

.. code-block:: php

   Status::options();               // ['Draft' => 'draft', 'Published' => 'published']

This is a good fit for:

- HTML selects
- CLI choice prompts
- schema or documentation generation
- admin UIs

Name lookups
------------

``tryFromName()``
^^^^^^^^^^^^^^^^^

Returns ``null`` when the name does not exist.

.. code-block:: php

   Status::tryFromName('Draft');    // Status::Draft
   Status::tryFromName('Unknown');  // null

``fromName()``
^^^^^^^^^^^^^^

Throws ``ValueError`` when the name is invalid, matching the style of PHP's
native ``from()`` behavior for backed enums.

.. code-block:: php

   Status::fromName('Draft');       // Status::Draft

``hasName()`` and ``hasValue()``
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Use these as small intent-revealing checks when validating external input.

.. code-block:: php

   EnumHelper::hasName(Status::class, 'Draft'); // true
   EnumHelper::hasValue(Status::class, 'draft'); // true

Labels and descriptions
-----------------------

``HasDescription``
^^^^^^^^^^^^^^^^^^

This trait turns ``CamelCase`` names into readable strings. It is useful as a
low-cost default when you want something better than the raw case name.

``LabeledEnumInterface`` and ``HasLabel``
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Use ``LabeledEnumInterface`` when a case needs an explicit presentation label.
The package also ships with ``HasLabel`` as a simple default, but most
user-facing enums will benefit from a custom implementation.

Comparison helpers
------------------

``Comparable``
^^^^^^^^^^^^^^

Use ``Comparable`` when you want intent-revealing methods instead of ad-hoc
strict comparisons.

.. code-block:: php

   Status::Draft->is(Status::Published);    // false
   Status::Draft->isNot(Status::Published); // true
   Status::Draft->in([Status::Draft, Status::Published]); // true

When not to use these helpers
-----------------------------

- Do not add every trait to every enum just because it is available.
- Do not use packaged enums when your semantics are business-specific.
- Do not use ``values()`` or ``options()`` on plain ``UnitEnum`` types.
