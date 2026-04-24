Use Cases
=========

The package is intentionally small, but it covers several recurring enum scenarios that show up in
real applications.

Building select options
-----------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use App\Domain\Status;

   Status::options();

This is useful for forms, CLI prompts, admin dashboards, and documentation generators.

Validating incoming values
--------------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use App\Domain\Status;

   Status::tryFrom('draft');
   Status::fromName('Draft');

Use ``tryFrom()`` for backed values and ``fromName()`` when the external input matches case names.

Documenting domain workflows
----------------------------

.. code-block:: php

   <?php

   declare(strict_types=1);

   use App\Domain\ArticleWorkflow;

   ArticleWorkflow::Draft->allowedTransitions();
   ArticleWorkflow::Reviewing->assertCanTransitionTo(ArticleWorkflow::Published);

This keeps transition rules close to the enum instead of spreading them across conditionals.

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

Troubleshooting ambiguous semantics
-----------------------------------

If a packaged enum feels almost right but not quite, it is usually a sign that your application
should define its own enum. Reuse the traits and helper APIs instead of stretching a shared catalog
beyond its intended semantics.
