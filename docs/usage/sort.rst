Sort Helpers
============

The ``Sort`` namespace groups enums that help with ordering logic without
coupling you to a specific library.

Why this namespace exists
-------------------------

Sorting code often accumulates "magic" values such as ``1``, ``-1``, ``ASC``,
``DESC``, ad-hoc null rules, and case-sensitivity flags. These enums make those
choices explicit and typed.

Examples
--------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Sort\CaseSensitivity;
   use FastForward\Enum\Sort\ComparisonResult;
   use FastForward\Enum\Sort\NullsPosition;
   use FastForward\Enum\Sort\SortDirection;

   SortDirection::Descending->applyToComparisonResult(5); // -5
   NullsPosition::Last->compareNullability(null, 'value'); // 1
   CaseSensitivity::Insensitive->equals('Draft', 'draft'); // true
   ComparisonResult::fromComparisonResult(-1); // ComparisonResult::RightGreater

What each enum is for
---------------------

``SortDirection``
^^^^^^^^^^^^^^^^^

Represents ascending vs descending order and can invert comparator results
through ``applyToComparisonResult()``.

``NullsPosition``
^^^^^^^^^^^^^^^^^

Represents whether ``null`` values should sort first or last.

``CaseSensitivity``
^^^^^^^^^^^^^^^^^^^

Represents whether string comparisons should preserve case or normalize it.

``ComparisonResult``
^^^^^^^^^^^^^^^^^^^^

Represents comparator-style outcomes such as ``LeftGreater`` and
``RightGreater`` without passing around raw integers.
