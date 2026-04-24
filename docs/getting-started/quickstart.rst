Quickstart
==========

This walkthrough shows the smallest practical path from installation to a
useful enum. It intentionally covers the three ideas new users need first:

1. adding methods directly to an enum with traits
2. reading the same data externally with ``EnumHelper``
3. understanding why both approaches exist

Build a Backed Enum with Trait Helpers
--------------------------------------

Start with a backed enum because it demonstrates the most common helpers in one
place.

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Trait\HasNameLookup;
   use FastForward\Enum\Trait\HasNames;
   use FastForward\Enum\Trait\HasOptions;
   use FastForward\Enum\Trait\HasValues;

   enum Status: string
   {
       use HasNameLookup;
       use HasNames;
       use HasOptions;
       use HasValues;

       case Draft = 'draft';
       case Published = 'published';
   }

   Status::values();   // ['draft', 'published']
   Status::names();    // ['Draft', 'Published']
   Status::options();  // ['Draft' => 'draft', 'Published' => 'published']
   Status::fromName('Draft'); // Status::Draft

What this gives you
-------------------

- ``values()`` returns the backed values in declaration order
- ``names()`` returns case names without requiring manual ``cases()`` mapping
- ``options()`` returns a simple ``name => value`` array for forms, prompts, or docs
- ``fromName()`` adds a native-feeling name lookup that PHP does not provide out of the box

Reading the Same Enum Through ``EnumHelper``
--------------------------------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Helper\EnumHelper;

   EnumHelper::names(Status::class);     // ['Draft', 'Published']
   EnumHelper::valueMap(Status::class);  // ['draft' => Status::Draft, 'published' => Status::Published]

This is useful when:

- you cannot or do not want to modify the enum declaration
- you want to keep utility logic in an application service
- the enum comes from another package

Seeing a Packaged Enum
----------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Calendar\Month;
   use FastForward\Enum\Logger\LogLevel;
   use FastForward\Enum\Runtime\Environment;
   use FastForward\Enum\Sort\SortDirection;

   Environment::Production->isProduction(); // true
   Month::December->quarter();              // 4
   LogLevel::Critical->isAtLeast(LogLevel::Warning); // true
   SortDirection::Descending->reverse();    // SortDirection::Ascending

What to read next
-----------------

- Continue with :doc:`../usage/helper-methods` if you want a method-by-method guide for traits and ``EnumHelper``.
- Continue with :doc:`../usage/working-with-enums` if you want to see where the package sits inside application code.
- Continue with :doc:`../usage/catalogs` if you want to decide whether a packaged enum fits your use case.
