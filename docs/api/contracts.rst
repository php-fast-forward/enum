Interfaces
==========

The public interfaces live in the package root namespace, not in a ``Contracts`` bucket.

Why root-level interfaces?
--------------------------

This package keeps its public contracts shallow on purpose. The goal is to make
discovery easy for package users and avoid namespace chains that add structure
without adding real meaning.

Interfaces
----------

- ``LabeledEnumInterface``
- ``DescribedEnumInterface``
- ``ReversibleInterface``

This keeps the public API shallow and discoverable.

When to use them
----------------

``LabeledEnumInterface``
^^^^^^^^^^^^^^^^^^^^^^^^

Use this when enum cases need explicit presentation labels and you want
``EnumHelper::labels()`` or ``EnumHelper::labelMap()`` to work.

``DescribedEnumInterface``
^^^^^^^^^^^^^^^^^^^^^^^^^^

Use this when enum cases need longer human-readable descriptions.

``ReversibleInterface``
^^^^^^^^^^^^^^^^^^^^^^^

Use this for enums that have a meaningful inverse, such as sort directions or
case-sensitivity flags.
