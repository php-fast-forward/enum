Working with Enums
==================

This package does not expose a service container integration layer. In practice, the most common
ways to use it are:

- importing enum cases directly
- using traits inside enums you control
- calling ``EnumHelper`` from application services, serializers, or validators

Three common usage styles
-------------------------

.. list-table::
   :header-rows: 1

   * - Style
     - Best when
     - Typical examples
   * - Traits on your enum
     - You own the enum declaration and want the behavior directly on the type
     - ``Status::values()``, ``Direction::names()``, ``Visibility::fromName()``
   * - ``EnumHelper``
     - The enum lives elsewhere or you want to keep utility access external
     - presenters, validators, serializers, admin form builders
   * - Packaged enums
     - The semantics are generic enough to be reused across projects
     - ``Environment``, ``LogLevel``, ``Month``, ``SortDirection``

Direct enum usage
-----------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Runtime\Environment;

   final class RuntimeModeResolver
   {
       public function isLive(Environment $environment): bool
       {
           return $environment->isProduction();
       }
   }

Using ``EnumHelper`` from application code
------------------------------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Helper\EnumHelper;

   final class StatusPresenter
   {
       /**
        * @param class-string<\UnitEnum> $enumClass
        */
       public function names(string $enumClass): array
       {
           return EnumHelper::names($enumClass);
       }
   }

Using traits inside your own enum
---------------------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Trait\HasNameLookup;
   use FastForward\Enum\Trait\HasNames;
   use FastForward\Enum\Trait\HasValues;

   enum Visibility: string
   {
       use HasNameLookup;
       use HasNames;
       use HasValues;

       case Public = 'public';
       case Private = 'private';
   }

Best practices
--------------

- Prefer traits when you own the enum declaration.
- Prefer ``EnumHelper`` when you need external operations over enums defined elsewhere.
- Keep integration code small and let the enum remain the main source of behavior.
- Prefer packaged enums only when the names and semantics are already a good match for your domain.
