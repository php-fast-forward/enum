State Machines
==============

``StateMachine\\HasTransitions`` is useful when an enum represents a workflow with explicit allowed transitions.

What problem it solves
----------------------

Without the trait, transition rules usually end up spread across ``match``
expressions, guard methods, or service classes. ``HasTransitions`` keeps that
behavior next to the enum cases, which makes the workflow easier to inspect and
test.

Example
-------

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

   ArticleWorkflow::Draft->canTransitionTo(ArticleWorkflow::Reviewing); // true

What the trait adds
-------------------

- ``allowedTransitions()`` for the current case
- ``canTransitionTo()`` and ``assertCanTransitionTo()`` for validation
- ``isTerminal()`` and ``terminalStates()`` for end states
- ``isInitial()`` and ``initialStates()`` for inferred or explicit entry points

When to use explicit initial states
-----------------------------------

If your workflow has more than one valid entry state, implement
``initialStateCases()`` directly. Otherwise the trait infers initial states by
finding cases with no incoming transitions.

When to avoid it
----------------

Do not force every state enum into a transition system. Use the trait only when the transitions are part of the public behavior you want to model.
