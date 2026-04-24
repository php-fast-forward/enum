Traits API
==========

Main trait groups
-----------------

- collection-style helpers: ``HasValues``, ``HasNames``, ``HasOptions``
- lookup helpers: ``HasNameLookup``, ``HasNameMap``, ``HasValueMap``
- behavior helpers: ``Comparable``, ``HasDescription``, ``HasLabel``

These traits are intentionally small and composable. Use only the traits that
match the behavior your enum really needs.

Collection traits
-----------------

``HasNames``
^^^^^^^^^^^^

Adds ``names()`` to any enum.

``HasValues``
^^^^^^^^^^^^^

Adds ``values()`` to backed enums.

``HasOptions``
^^^^^^^^^^^^^^

Adds a ``name => value`` option array for backed enums.

Lookup traits
-------------

``HasNameLookup``
^^^^^^^^^^^^^^^^^

Adds ``tryFromName()``, ``fromName()``, and ``hasName()``.

``HasNameMap`` and ``HasValueMap``
^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^^

Add fast reusable lookup arrays for case names and backed values.

Behavior traits
---------------

``Comparable``
^^^^^^^^^^^^^^

Adds explicit comparison helpers such as ``is()`` and ``in()``.

``HasDescription``
^^^^^^^^^^^^^^^^^^

Adds a readable description based on the case name.

``HasLabel``
^^^^^^^^^^^^

Adds a default ``label()`` implementation. This can be useful as a fallback,
but user-facing enums often benefit from a custom label implementation instead.

Trait composition example
-------------------------

.. code-block:: php

   enum Status: string
   {
       use HasValues;
       use HasNames;
       use HasOptions;
       use HasNameLookup;
       use Comparable;
   }
