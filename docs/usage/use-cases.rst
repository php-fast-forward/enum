Use Cases
=========

The package is intentionally small, but it covers several recurring enum scenarios that show up in
real applications.

Building select options
-----------------------

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

   Status::options(); // ['Draft' => 'draft', 'Published' => 'published']

This is useful for forms, CLI prompts, admin dashboards, and documentation generators.

Validating incoming values
--------------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Trait\HasNameLookup;
   use FastForward\Enum\Trait\HasValues;

   enum Status: string
   {
       use HasNameLookup;
       use HasValues;

       case Draft = 'draft';
       case Published = 'published';
   }

   Status::tryFrom('draft');    // Status::Draft
   Status::fromName('Draft');   // Status::Draft
   Status::tryFromName('Ghost'); // null

Use ``tryFrom()`` for backed values and ``fromName()`` when the external input matches case names.
Use ``tryFromName()`` when invalid names should return ``null`` instead of throwing.

Documenting domain workflows
----------------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\StateMachine\HasTransitions;

   enum ArticleWorkflow: string
   {
       use HasTransitions;

       case Draft = 'draft';
       case Reviewing = 'reviewing';
       case Published = 'published';
       case Archived = 'archived';

       /**
        * @return array<string, list<self>>
        */
       protected static function transitionMap(): array
       {
           return [
               self::Draft->name => [self::Reviewing, self::Archived],
               self::Reviewing->name => [self::Published, self::Draft],
               self::Published->name => [self::Archived],
               self::Archived->name => [],
           ];
       }
   }

   ArticleWorkflow::Draft->allowedTransitions();
   ArticleWorkflow::Reviewing->assertCanTransitionTo(ArticleWorkflow::Published);

This keeps transition rules close to the enum instead of spreading them across conditionals.

Presenting user-facing labels
-----------------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\LabeledEnumInterface;
   use FastForward\Enum\Helper\EnumHelper;

   enum Priority: int implements LabeledEnumInterface
   {
       case Low = 1;
       case High = 2;

       public function label(): string
       {
           return match ($this) {
               self::Low => 'Low priority',
               self::High => 'High priority',
           };
       }
   }

   EnumHelper::labelMap(Priority::class); // ['Low' => 'Low priority', 'High' => 'High priority']

Use explicit labels for public UI text. The default ``HasLabel`` trait is better suited to diagnostics
and fallbacks.

Filtering with typed operators
------------------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Comparison\ComparisonOperator;

   ComparisonOperator::GreaterThanOrEqual->compare(10, 5); // true
   ComparisonOperator::In->compare('draft', ['draft', 'published']); // true
   ComparisonOperator::In->negate(); // ComparisonOperator::NotIn

Typed operators are useful for query builders, filtering DTOs, rule systems, and admin screens where
plain strings would hide behavior.

Reusing stable catalogs
-----------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Logger\LogLevel;
   use FastForward\Enum\Sort\SortDirection;

   LogLevel::Critical->isAtLeast(LogLevel::Warning);
   SortDirection::Descending->applyToComparisonResult(3);

This works well for cross-project concerns such as logging, sort behavior, runtime environments, or calendar calculations.

Sorting with explicit behavior
------------------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use FastForward\Enum\Sort\CaseSensitivity;
   use FastForward\Enum\Sort\NullsPosition;
   use FastForward\Enum\Sort\SortDirection;

   SortDirection::Ascending->applyToComparisonResult(-1); // -1
   SortDirection::Descending->applyToComparisonResult(-1); // 1
   NullsPosition::Last->compareNullability(null, 'value'); // 1
   CaseSensitivity::Insensitive->equals('Draft', 'draft'); // true

Troubleshooting ambiguous semantics
-----------------------------------

If a packaged enum feels almost right but not quite, it is usually a sign that your application
should define its own enum. Reuse the traits and helper APIs instead of stretching a shared catalog
beyond its intended semantics.
