Helper
======

``FastForward\\Enum\\Helper\\EnumHelper`` provides static helpers for both class strings and enum cases.

Why it exists
-------------

``EnumHelper`` is the external face of the package. It is especially useful
when:

- the enum is defined in another package
- you do not want to add traits to the enum declaration
- you want one shared helper surface in presenters, forms, serializers, or validators

Accepted inputs
---------------

Most methods accept either:

- a class string such as ``Status::class``
- or a concrete enum case such as ``Status::Draft``

That means you can call helpers without normalizing the enum manually first.

Main methods
------------

.. list-table::
   :header-rows: 1

   * - Method
     - Returns
     - Typical use
   * - ``cases()``
     - enum case list
     - general iteration
   * - ``names()``
     - ``list<string>``
     - dropdown labels, documentation, debugging
   * - ``values()``
     - ``list<int|string>``
     - backed enums, schema generation, allowed values
   * - ``options()``
     - ``array<string, int|string>``
     - forms, prompts, UI option lists
   * - ``nameMap()``
     - ``array<string, UnitEnum>``
     - lookups by case name
   * - ``valueMap()``
     - ``array<int|string, BackedEnum>``
     - lookups by backed value
   * - ``fromName()`` / ``tryFromName()``
     - enum case or ``null``
     - name-based input normalization
   * - ``hasName()`` / ``hasValue()``
     - ``bool``
     - validation and guards
   * - ``labels()`` / ``labelMap()``
     - strings or name-to-label map
     - presentation-friendly enums implementing ``LabeledEnumInterface``

Examples
--------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Helper\EnumHelper;

   EnumHelper::names(Status::class);
   EnumHelper::values(Status::Draft);
   EnumHelper::fromName(Status::class, 'Draft');
   EnumHelper::options(Status::class);
   EnumHelper::valueMap(Status::class);

Failure behavior
----------------

``EnumHelper`` validates the enum type you pass in:

- methods that require any enum validate ``UnitEnum``
- methods that require backed values validate ``BackedEnum``

If the wrong type is passed, the helper throws ``ValueError`` instead of
failing later in a less obvious way.

Use it when you want enum utilities without mixing traits into the enum definition itself.
